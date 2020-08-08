<?php
/**
 * Name:    	Controlador Inicio
 * Author:  	Rigoberto Alejandres
 * Email: 		isc.alej@gmail.com
 * Twitter: 	@iscalej
 * Created:  	23.06.2019
 * Description: Controlador para mostrar el inicio de la Aplicación.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// Cargamos los Modelos
		$this->load->model('inicio_model');
	}

	public function index(){
	
		$data['conf'] 	=	$this->ajustes_model->m_app();

		// Obtenemos los datos del Usuario actual logueado así como los datos de los Grupos a los que pertenece
		$userid 	=	$this->session->userdata('user_id'); // ID del Usuario actual en la sessión

		// Si exste Usuario Logueado
		if(isset($userid) && $userid){

			$user 		=	$this->ion_auth->user($userid)->row(); // Obtenemos los datos del usuario actual con el método de IonAuth
			$grupos		=   $this->ion_auth->get_users_groups($userid)->result(); // Obtenemos los grupos del usuario actual con el método de IonAuth

			// SI existe el usuario, agregamos a la sesión los grupos a los cuales pertenece
			// para poder gestionar los permisos en la aplicación 
			if(isset($user) && $user){// Hay datos del usuario

				// Capturamos parámetros adicionales del usuario
				$foto 	=	$user->photo; // Foto del Usuario
				
				if(isset($grupos) && $grupos){//Hay asignación del grupo al Usuario
					
					// Para cada registro de grupos, procedemos a guardar en la sessión 
					foreach ($grupos as $k => $row) {
						$this->session->set_userdata( array( strtolower ($row->name) => $row->id) );
					}// End foreach 

				}//End if($grupos)

				// Asignamos más ajustes a la variable de sesión
				$this->session->set_userdata(array('photo' => $foto));

				// Creamos el array para pasar a la vista
				$data['user']		=	$user;
				$data['grupos']		=	$grupos;

			}//End if($user)

		}else{
			// Cargamos la Librería para autenticar al Usuario
        	$this->load->library('google');

			//google login url
        	$data['loginURL'] = $this->google->loginURL();

		}// End if(isset($userid) && $userid)

		//Cargamos la vista para desplegar el Inicio de la Aplicación
		$data['opc']	=	0;
		$this->load->view('secciones/seccion_inicio_view',$data);

	}// End index


}// End class