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
		$this->load->model('dpca_model');
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

				// Generamos intervalo de fechas
            	$desde 	= human_to_unix(date('Y-m-d',time()) . ' 00:00:00');
            	$hasta 	= human_to_unix(date('Y-m-d',time()) . ' 23:59:59');

            	// Creamos la cadena de consulta
            	$c1['sql']	=	" users.id = ".$userid." AND intercambios.in_status = 2 AND intercambios.in_fecha BETWEEN '" . $desde ."' AND '" . $hasta ."'";

				// Obtenemos el Total de Intercambios del día
				$data['total']		=	$this->dpca_model->m_intercambios(0,$c1);

				// Capturamos ID del Intercambio abierto desde la sesión
				$interid 	=	$this->session->userdata('interid');

				// Verificamos desde la SESIÓN si existe DPCA abierto
				if(isset($interid) && $interid){

					// Creamos la cadena de consulta
            		$c1['sql']	=	" intercambios.interid = " . $interid . " AND intercambios.in_status = 1";

					// Obtenemos sus datos
					$c1['ban']		=	1;
					$data['dpca']	=	$this->dpca_model->m_intercambios(1,$c1);

				}else{
					// NO hay datos de la sesión, verificamos en la db con status
					// Creamos la cadena de consulta
					$c1['sql']	=	" users.id = ".$userid." AND intercambios.in_status = 1 AND intercambios.in_fecha BETWEEN '" . $desde ."' AND '" . $hasta ."'";

					// Obtenemos sus datos
					$c1['ban']		=	2;
					$data['dpca'] 	=	$this->dpca_model->m_intercambios(1,$c1);
				}

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