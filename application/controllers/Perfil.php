<?php
/**
 * Name:    	Perfil
 * Author:  	Rigoberto Alejandres
 * Email: 		isc.alej@gmail.com
 * Twitter: 	@iscalej
 * Created:  	23.06.2019
 * Description: Controlador para administrar Perfil del Usuario.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Perfil extends CI_Controller {

	//Max password size constant
	const MAX_PASSWORD_SIZE_BYTES = 4096;


	public function __construct(){
		parent::__construct();
		// Cargamos los Modelos de datos
		$this->load->model('ajustes_model');

		// initialize hash method options (Bcrypt)
		$this->hash_method = $this->config->item('hash_method', 'ion_auth');
	}

	public function index(){
		
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
		
		// Obtenemos datos del Usuario actual logueado
		$userid			=	$this->session->userdata('user_id');
		$data['user']	=	$this->ion_auth->user($userid)->row();
		
		// Cargamos la vista para deplegar el Inicio de la Aplicación
		$data['opc']	=	0;
		$this->load->view('usuarios/usuarios_perfil_view',$data);
	}// End index

	public function datos(){
		// Función del Controlador para admministrar los datos de un Usuario

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

         // Obtenemos la Configuración del Sitio
		$data['conf'] 		=	$this->ajustes_model->m_app(); //Configuración del Sitio

        // Recibimos la bandera
        $ban 	=	$this->input->get_post('id');

        // Decidimos qué hacer
        if( isset($ban) && $ban == 1 ){// Editar o guardar nuevo usuario
        	//Función del Modelo para guardar nuevo registro de usuario o editar perfil o editar usuario
			$ban 	=	$this->input->post('accion');

			$this->input->post(NULL, TRUE); // Returns all POST items with XSS filter
			$this->load->library('form_validation');// Cargamos la librería para Validaciones de CodeIgniter

			//Creamos las reglas de validación GENERALES para cada uno de los Campos del formulario
			$this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'trim|required');
			$this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'trim|required');
			$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim|required|regex_match[/^\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{4}$/]');
			$this->form_validation->set_rules('cellphone', $this->lang->line('label_telefono_cel'), 'trim|required|regex_match[/^\(?[0-9]{3}\)?[-. ]?[0-9]{3}[-. ]?[0-9]{4}$/]');
			$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');

			//ID del registro, aplica para EDITAR un registro
			$next_id 		=	$this->input->post('userid');

			if(isset($ban) && $ban == 1){//NUEVO USUARIO
				//Verificamos que el usaurio esté logueado y sea Administrador
				if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()){
					header('Location: '.base_url('auth/login'), true, 302);
					exit;
				}

				//Generamos la Password para el usuario nuevo
				$pass   = 	$this->hash_password( $this->input->post('username') );

				//Creamos las reglas de validación DE ESTA OPCION para cada uno de los Campos del formulario
				$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|is_unique[users.email]');
				$this->form_validation->set_rules('username',lang('label_username'), 'trim|required|min_length[5]|is_unique[users.username]');

				//Campos para obtener el siguiente ID
				$c1['campo']	=	"id";
				$c1['tabla']	=	"users";

				//ID del registro, aplica para NUEVO de un registro
				$next_id 		=	$this->ajustes_model->m_get_last_id($c1) + 1;//Obtenemos el ID asignado a la siguiente Solicitud

			}else if(isset($ban) && $ban == 2){//EDITAR USUARIO
				//Verificamos que el usaurio esté logueado y sea Administrador
				if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()){
					header('Location: '.base_url('auth/login'), true, 302);
					exit;
				}

				//Creamos las reglas de validación DE ESTA OPCION para cada uno de los Campos del formulario
				$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'trim|required|valid_email|callback__validar_email');
				$this->form_validation->set_rules('username',lang('label_username'), 'trim|required|min_length[5]|callback__validar_username');

			}else if(isset($ban) && $ban == 3){//EDITAR PERFIL
				//Verificamos que el usuario esté logueado
				if (!$this->ion_auth->logged_in()){
					header('Location: '.base_url('auth/login'), true, 302);
					exit;
				}

				//Creamos las reglas de validación DE ESTA OPCION para cada uno de los Campos del formulario
				$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|callback__validar_email');
				$this->form_validation->set_rules('username',lang('label_username'), 'trim|required|min_length[5]|callback__validar_username');
				
			}

			//Completamos el array para Guardar los datos
			$data 		=	array(
				'username'			=>	$this->input->post('username'),
				'email'				=>	$this->input->post('email'),
				'first_name'		=>	$this->input->post('first_name'),
				'last_name'			=>	$this->input->post('last_name'),
				'company'			=>	$this->input->post('company'),
				'phone'				=>	$this->input->post('phone'),
				'cellphone'			=>	$this->input->post('cellphone')
			);

			//Lamamos la función de IonAuth para guardar o editar 
			if(isset($ban) && $ban == 1){//NUEVO REGISTRO

				//Capturamos los datos necesarios para llamar la función que inserta nuevo registro:
				$username 	=	$data['username'];
				$email 		=	$data['email'];

				//Quitamos las variables de username y email del array
				unset($data['username'],$data['email']);

				//Recibimos array el usuario:
				$grupos_in 	=	$this->input->post('grupos_in');
				
				$groupos = array('2'); //Por defecto, ponemos como miembros operarios a todos los usuarios
				if(is_array($grupos_in) && count($grupos_in) > 0){
					$groupos 	=	$grupos_in;
				}			

				//Agregamos compania al registro del usuario
				$data['company']	=	"Chimiriwe Software";
				//Llamamos la función de IonAuth para guardar nuevo usuario
				$res 	=	$this->ion_auth->register($username,$pass,$email,$data,$groupos);
			}else if(isset($ban) && $ban == 2){//EDITAR USUARIO

				//Actializamos el Grupo asignado
				$grupos_in 	=	$this->input->post('grupos_in');
				
				$groupos = array('2'); //Por defecto, ponemos como miembros operarios a todos los usuarios
				if(is_array($grupos_in) && count($grupos_in) > 0){
					$groupos 	=	$grupos_in;
				}	

				//ELiminamos la asignación actual de grupos
				$res 	=	$this->ion_auth->remove_from_group(NULL, $next_id);

				//Si el resultado es verdadero, volvemos a asignar el grupo
				if($res){
					$res =	$this->ion_auth->add_to_group($groupos, $next_id);

					//Si el resultado es verdadero, actualizamos los datos del usuario
					if($res){
						$res 	=	$this->ion_auth->update($next_id, $data);
					}
				}
			}else if(isset($ban) && $ban == 3){//EDITAR PERFIL
				//Actualizamos los datos del usuario
				$res 	=	$this->ion_auth->update($next_id, $data);
			}

			//Procesamos la respuesta
			if($res){
				echo 1;
			}else{
				echo 0;
			}
        }

	}// End datos()


	public function validate(){
		//FUNCIÓN PARA VALIDAR NOMBRE DE USUARIO Y CORREO ELECTRÓNICO

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

		//Recibios los datos enviados desde $_GET
		$ban 	= 	$this->input->get('id'); 			// Qué campo validar
		$campo1 =	$this->input->get('fieldId');		// ID del campo a validar
		$term 	=	$this->input->get('fieldValue');	// Valor del campo a validar
		$id_r 	=	$this->input->get('item1');			// ID llave primaria

		//Validamos existecia del ID, si no, para validad <> 0 (todos)
		if(!$id_r){
			$id_r 	=	0;
		}

		//La bandera nos indica en qué tabla está el campo a validar validar
		if($ban == 1 or $ban == 2){		//Email y Useraname de Usuarios
			$tabla 		=	"users"; 	// Nombre de la Tabla de la cual validar campo
			$campo2 	=	"id";		// Nombre de la Llave primaria de la tabla
		}

		//Creamos el array para la consulta
		$c1['tabla']	=	$tabla;
		$c1['campo1']	=	$campo1;
		$c1['campo2']	=	$campo2;
		$c1['term']		=	$term;
		$c1['id_r']		=	$id_r;

		//Llamamos la función del Modelo para procesar la respuesta
		$res 	=	$this->ajustes_model->m_validate($c1);

		//Procesamos la respuesta
		if($res){
			$bandera 	= FALSE;
			$msj 		= sprintf( lang('label_novalid'),'<b>'.$campo1.'</b>' ); 
		}else{
			$bandera 	= TRUE;
			$msj 		= sprintf( lang('label_sivalid'),'<b>'.$campo1.'</b>' ); 
		}

		//Retornamos el resultado para a validación
		$result = ["$campo1",$bandera,$msj];
		echo json_encode($result);

	}//End function validate()



	protected function _prepare_ip($ip_address) {
		// just return the string IP address now for better compatibility
		return $ip_address;
	}//END _prepare_ip


	public function hash_password($password=NULL, $identity = NULL){

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

}// End class