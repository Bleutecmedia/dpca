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

					// Generamos los pesos de las soluciones
					$pesos 			=	[2205,2210,2210,2215,2215,2215,2220,2225];

					// Generamos las horas
					$horas 			=	array(
						'0'		=> 	'09',
						'1'		=>	'13',
						'2'		=>	'17',
						'3'		=>	'21'
					);

					// Generamos hora inicial
					$inicio 	=	date('Y-m-d') . ' '.$horas[$total] . ':' . str_pad(mt_rand(0,10), 2, "0", STR_PAD_LEFT) . ':' . str_pad(mt_rand(0,59), 2, "0", STR_PAD_LEFT);
					
					// Pasamos a unix
					$sale_inicio 	=	human_to_unix($inicio); // de 0 a 10 minutos desde la hora
					$sale_termina 	=	$sale_inicio + ( mt_rand(28,39) * 60 ); // de 28 a 39 minutos
					$entra_inicio 	=	$sale_termina + mt_rand(20,60); // de 20 a 60 segundos despues
					$entra_termina 	=	$entra_inicio + + ( mt_rand(10,16) * 60 ); // de 10 a 16 minutos 

					// Creamos array para abrir nuevo Intercambio
					$intercambio 	=	array(
						'ban'					=>	1,
						'interid'				=>	$interid,
						'in_solid'				=>	2, // 1.5%
						'in_fecha'				=>	time(),
						'in_userid'				=>	$userid,
						'in_peso_inicial'		=> 	$pesos[array_rand($pesos)],
						'in_hora_sale_inicio'	=>  $sale_inicio,
						'in_hora_sale_termina'	=>  $sale_termina,
						'in_hora_entra_inicio'	=>  $entra_inicio,
						'in_hora_entra_termina'	=> 	$entra_termina 
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
        } // End switch

	}// End nuevo


	/**
	* Función del Controlador para llevar el proceso del DPCA
	*/
	public function proceso(){
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

       	// Saneamos los envíos por $_POST
		$this->input->post(NULL, TRUE);  // returns all POST items with XSS filter

		// Bandera de destroy session
		$end_ses 	=	0;

        // Decidimos qué hacer
        switch ($ban) {
        	case 1: // ACTUALIZAR TIPO DE SOLUCIÓN
        		// Capturamos valores y creamos array para actualizar 
        		$inter 	=	array(
        			'interid'	=>	$this->input->post('item1'),
        			'in_solid'	=>	$this->input->post('item2')
        		);
        		break;

        	case 2: // PESOS DE ENTRADA Y SALIDA
        		// Capturamos valores y creamos array para actualizar 
        		$input 	=	'in_' . $this->input->post('item3');

        		$inter 	=	array(
        			'interid'	=>	$this->input->post('item1'),
        			"$input"	=>	$this->input->post('item2')
        		);
        		break;

        	case 3: // ACTUALIZAR HORAS DE ENTRADA Y SALIDA
        		// Capturamos valores y creamos array para actualizar 
        		$input 	=	'in_hora_' . $this->input->post('item2');

        		$inter 	=	array(
        			'interid'	=>	$this->input->post('item1'),
        			"$input"	=>	time()
        		);
        		break;
        	
        	default: // TERMINAR EL PROCESO
        		// Capturamos valores y creamos array para actualizar 
        		$inter 	=	array(
        			'interid'	=>	$this->input->post('item1'),
        			'in_status'	=>	2
        		);

        		$end_ses 	=	1;
        		break;
        }

        // Llamamos la función del Modelo que guarda los datos en el Intercambio
        $inter['ban']	=	2;
        $res 			=	$this->dpca_model->m_intercambios(2,$inter);

        // Comprobamos resultado de la transacción
        if($res){
        	
        	if($end_ses){
        		$this->session->unset_userdata('interid');
        	}

        	echo 1; // Éxito
        }else{
        	echo 0; // Error
        }
	}

}// End class