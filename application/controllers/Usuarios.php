<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Name:        Controlador Usuarios
 * Author:      Rigoberto Alejandres García
 * Email:       isc.alej@gmail.com
 * Twitter:     @iscalej
 * Created:     06.08.2020
 * Description: Controlador para Administrar los Usuarios.
 **/

class Usuarios extends CI_Controller {

    //Max password size constant
    const MAX_PASSWORD_SIZE_BYTES = 4096;

    public function __construct(){
        parent::__construct();
        // Cargamos la Librería para autenticar al Usuario
        $this->load->library('google');

        // Cargamos el Modelo de datos
        $this->load->model('usuarios_model');

        // initialize hash method options (Bcrypt)
        $this->hash_method = $this->config->item('hash_method', 'ion_auth');

    }// End public function __construct()


    public function index(){
        // Comprobamos usuario logueado
        if (!$this->ion_auth->logged_in()){
            header('Location: '.base_url('auth/login'), true, 302);
            exit;
        }

        // Para evitar el acceso directo que no sea via ajax 
        if ( !$this->input->is_ajax_request() ) {
            header('Location: '.base_url(), true, 302);
            exit;
        }

        // Code
        
    }// End index


    /**
    *   Función del Controlador para administrar los ingresos mediante Google
    */
    public function ingresar(){
        // Si es usuario ya está logueado, saltamos hasta el inicio 
        if($this->ion_auth->logged_in()){
            header('Location: '.base_url(), true, 302);
            exit;
        }

        // Code
        $code   =   $this->input->get('code');
        
        // Suponiendo que no está logueado
        if(isset($code)){

            //Intentamos authenticate al Usuario
            $this->google->getAuthenticate($code);

            // Obtenemos el Token de acceso del Usuario
            $token = $this->google->getAccessToken();
            
            // Obtenemos los datos del Usuario desde Google
            $user = $this->google->getUserInfo();

            /** 
            *   De acuerdo a los datos obtenidos del usuario 
            *   procederemos a verificar si el usuario ya está registrado,
            *   actualizamos sus datos o sólo iniciará sesión, lo que implica 
            *   autenticarlo también con Ion-Auth. 
            */

            // Folio de la password
            $folio  =   str_gen(10);

            // Capturamos los datos del Usuario autenticado con google
            $gid        =   $user['id'];
            $email      =   $user['email'];
            $verified   =   $user['verified_email'];
            $first_name =   $user['given_name'];
            $last_name  =   $user['family_name'];
            $photo      =   !empty($user['picture']) ? $user['picture'] : '';
            $lang       =   !empty($user['locale']) ? $user['locale'] : '';
            $profile    =   !empty($user['link']) ? $user['link'] : '';

            // Obtenemos los datos del Usuario mediante el Email
            $c1['email']=   $email;
            $usr        =   $this->usuarios_model->m_usuarios(0,$c1);

            // Creamos el array para actualizar o insertar Usuario
            $usuario    =   array(
                'ban'           =>  1,
                'ip_address'    =>  $this->_prepare_ip($this->input->ip_address()),
                'last_login'    =>  time(),
                'first_name'    =>  $first_name,
                'last_name'     =>  $last_name,
                'photo'         =>  $photo,
                'gid'           =>  $gid,
                'lang'          =>  $lang,
                'verified'      =>  $verified
            );

            // Verificamos si el Usuario
            if($usr){// ACTUALIZAMOS REGISTRO DE USUARIO
                $accion         =   2;

                // Capturamos ID del Usuario
                $userid         =   $usr->id;

            }else{// CREAMOS REGISTRO DE USUARIO
                // Creamos password
                $username   =   explode("@",$email)[0];
                $password   =   $this->hash_password($username);

                $accion         =   1;

                // Obtenemos el siguiente ID de Usuario
                $c1['campo']    =   'id';
                $c1['tabla']    =   'users';
                $userid         =   $this->usuarios_model->m_last($c1) + 1;

                // Agregamos campos sólo al crear el registro
                $usuario['email']       =   $email;
                $usuario['created_on']  =   time();
                $usuario['active']      =   1;
                $usuario['company']     =   $this->config->item('appName');
                $usuario['profile']     =   $profile;
                $usuario['username']    =   $username;
                $usuario['password']    =   $password;

            }

            // Agregamos datos al array de usuario
            $usuario['accion']  =   $accion;
            $usuario['id']      =   $userid;

            /* Llamamos la función del Modelo que inserta o actualiza los
               datos del Usuario en la base de datos de la aplicación web */
            $res    =   $this->usuarios_model->m_usuarios(2,$usuario);

            // Si hay éxito en la actualización de datos
            if($res){

                /* Logueamos al usuario con Ion-Auth */
                $this->ion_auth->login($email, $folio, TRUE);

                // Agregamos los datos adicionales a la sesión
                $sesion['gid']    =   $gid;

                // Agregamos
                $this->session->set_userdata($sesion);
            }
        }

        // Mandamos al Inicio
        header('Location: '.base_url(), true, 302);
        
    }// End ingresar


    protected function _prepare_ip($ip_address) {
        // just return the string IP address now for better compatibility
        return $ip_address;
    }

    public function hash_password($password, $identity = NULL){
        // Check for empty password, or password containing null char, or password above limit
        // Null char may pose issue: http://php.net/manual/en/function.password-hash.php#118603
        // Long password may pose DOS issue (note: strlen gives size in bytes and not in multibyte symbol)
        if (empty($password) || strpos($password, "\0") !== FALSE ||
            strlen($password) > self::MAX_PASSWORD_SIZE_BYTES)
        {
            return FALSE;
        }

        $algo = $this->_get_hash_algo();
        $params = $this->_get_hash_parameters($identity);

        if ($algo !== FALSE && $params !== FALSE)
        {
            return password_hash($password, $algo, $params);
        }

        return FALSE;
    }//End function hash_password($password, $identity = NULL)

    protected function _get_hash_algo(){
        $algo = FALSE;
        switch ($this->hash_method)
        {
            case 'bcrypt':
                $algo = PASSWORD_BCRYPT;
                break;

            case 'argon2':
                $algo = PASSWORD_ARGON2I;
                break;

            default:
                // Do nothing
        }

        return $algo;
    }//End function _get_hash_algo()

    protected function _get_hash_parameters($identity = NULL){
        // Check if user is administrator or not
        $is_admin = FALSE;
        if ($identity)
        {
            $user_id = $this->get_user_id_from_identity($identity);
            if ($user_id && $this->in_group($this->config->item('admin_group', 'ion_auth'), $user_id))
            {
                $is_admin = TRUE;
            }
        }

        $params = FALSE;
        switch ($this->hash_method)
        {
            case 'bcrypt':
                $params = [
                    'cost' => $is_admin ? $this->config->item('bcrypt_admin_cost', 'ion_auth')
                                        : $this->config->item('bcrypt_default_cost', 'ion_auth')
                ];
                break;

            case 'argon2':
                $params = $is_admin ? $this->config->item('argon2_admin_params', 'ion_auth')
                                    : $this->config->item('argon2_default_params', 'ion_auth');
                break;

            default:
                // Do nothing
        }

        return $params;
    }//End function _get_hash_parameters($identity = NULL)

    public function sudo(){
        //Comprobamos usuario logueado
        if (!$this->ion_auth->logged_in()){
            header('Location: '.base_url('auth/login'), true, 302);
            exit;
        }

        //Para evitar el acceso directo que no sea via ajax
        if (!$this->input->is_ajax_request()) {
            header('Location: '.base_url(), true, 302);
            exit;
        }

        /*
        // Creamos password
        $email      =   'wilsoncalzon@gmail.com';
        $username   =   explode("@",$email)[0];
        $password   =   $this->hash_password($username);

        $id = 3;
        $data = array(
            'password' => $username,
        );

        $this->ion_auth->update($id, $data);

        echo "<pre>";
        print_r($data);
        echo "</pre>";
        */

    }

}// End class
/* End of file Usuarios.php */
