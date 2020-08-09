<?php
/**
 * Name:    Dpca Controller
 * Author:  Rigoberto Alejandres
 * Email: 	isc.alej@gmail.com
 * @iscalej
 * Created:  08.08.2017
 * Description:  Controlador para administrar DPCA
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dpca extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//Cargamos los Modelos de Datos
		$this->load->model('data_model');
		$this->load->model('dpca_model');
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
	}

	/**
	* Controlador para abrir un nuevo Intercambio de DCPA
	*/	
	public function nuevo(){
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

        // Obtenemos los ajustes del Usuario
        $conf 	=	$this->ajustes_model->m_app();

        // Capturamos la badera
        $ban 	=	$this->input->get_post('id');

        switch ($ban) {
        	case 1:
        		// code...
        		break;
        	
        	default:// Abrir Nuevo DPCA
        		// Capturamos ID del Usuario
        		$userid 	=	$this->session->userdata('user_id'); // ID del Usuario logueado
        		$prog 		=	$conf->conf_intercambios; // Total de intercambios por día

        		// Generamos intervalo de fechas
            	$desde 	= human_to_unix(date('Y-m-d',time()) . ' 00:00:00');
            	$hasta 	= human_to_unix(date('Y-m-d',time()) . ' 23:59:59');

            	// Creamos la cadena de consulta
            	$c1['sql']	=	" users.id = ".$userid." AND intercambios.in_status = 2 AND intercambios.in_fecha BETWEEN '" . $desde ."' AND '" . $hasta ."'";

				// Obtenemos el Total de Intercambios del día
				$total		=	$this->dpca_model->m_intercambios(0,$c1);

				// Si todavía se puede abrir intercambio
				if($total < $prog){
					// Obtenemos el Siguiente ID 
					$c1['campo']	=	"interid";
					$c1['tabla']	=	"intercambios";

					$interid 		=	$this->data_model->m_get_last_id($c1) + 1;// ID del próximo Carnicero

					// Creamos array para abrir nuevo Intercambio
					$intercambio 	=	array(
						'ban'			=>	1,
						'interid'		=>	$interid,
						'in_solid'		=>	1, // N/A
						'in_fecha'		=>	time(),
						'in_userid'		=>	$userid
					);

					// Llamamos la función del Modelo que abre el intercambio
					$res 	=	$this->dpca_model->m_intercambios(2,$intercambio);

					// Comprobamos resultado de la transacción
					if($res){
						// Agregamos el ID del Intercambio en la sesión
						$this->session->set_userdata(array('interid' => $interid));

						// Response
						echo 1; // Éxito
					}else{
						echo 0; // Error
					}

				}else{
					echo 0; // Error
				}

        		break;
        }

	}

}