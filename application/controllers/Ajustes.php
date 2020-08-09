<?php
/**
 * Name:    	Controlador Inicio
 * Author:  	Rigoberto Alejandres
 * Email: 		isc.alej@gmail.com
 * Twitter: 	@iscalej
 * Created:  	23.06.2019
 * Description: Controlador para ajustes de la Aplicación.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajustes extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// Cargamos los Modelos de datos
		$this->load->model('ajustes_model');
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

		// Obtenemos la Configuración del Sitio
		$data['conf'] 		=	$this->ajustes_model->m_app(); //Configuración del Sitio
		
		// Cargamos la vista para deplegar el Inicio de la Aplicación
		$data['opc']	=	0;
		$this->load->view('ajustes/ajustes_inicio_view',$data);


	}// End index


	public function paciente(){
		// Función del Controlador para ingresar nombre del Paciente

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

        // Obtenemos los ajustes del Usuario actual
        $conf 	=	$this->ajustes_model->m_app();

        // Procedemos a validar los campos desde el lado del servidor, enviados por el formulario desde $_POST
		$this->load->library('form_validation');// Cargamos la librería para Validaciones de CodeIgnite

        // Saneamos los envíos por $_POST
		$this->input->post(NULL, TRUE);  // returns all POST items with XSS filter  

		// Creamos las reglas de validación
		$this->form_validation->set_rules('paciente','Nombre de Paciente', 'trim|required');

		// Corremos la validación y comprobamos si pasa o no
        if ($this->form_validation->run() == FALSE){// No pasa la validación, manda error
        	//echo "<div class='alert alert-error'>".validation_errors()."</div>";
        	echo 0;
        }else{
        	$datos 	=	array(
        		'confid'		=>	$conf->confid,
        		'conf_paciente'	=>	$this->input->post('paciente')
        	);

        	// Llamamos la función del Modelo para guardar los ajustes
        	$res 	=	$this->ajustes_model->m_generales($datos);

        	// Comprobamos resultados de la Transacción
        	if($res){
        		echo 1; // Success
        	}else{
        		echo 0; // Error
        	}
        }

	}// End generales()


	public function generales(){
		// Función del Controlador para ajustes Generales de la Aplicación

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

        // Obtenemos los ajustes del Usuario actual
        $conf 	=	$this->ajustes_model->m_app();

        // Procedemos a validar los campos desde el lado del servidor, enviados por el formulario desde $_POST
		$this->load->library('form_validation');// Cargamos la librería para Validaciones de CodeIgnite

        // Saneamos los envíos por $_POST
		$this->input->post(NULL, TRUE);  // returns all POST items with XSS filter  

		// Creamos las reglas de validación
		$this->form_validation->set_rules('paciente','Nombre de Paciente', 'trim|required');
		$this->form_validation->set_rules('intercambios','Número de Intercambios', 'trim|required|numeric|is_natural');

		// Corremos la validación y comprobamos si pasa o no
        if ($this->form_validation->run() == FALSE){// No pasa la validación, manda error
        	//echo "<div class='alert alert-error'>".validation_errors()."</div>";
        	echo 0;
        }else{
        	$datos 	=	array(
        		'confid'			=>	$conf->confid,
        		'conf_paciente'		=>	$this->input->post('paciente'),
        		'conf_intercambios'	=>	$this->input->post('intercambios')
        	);

        	// Llamamos la función del Modelo para guardar los ajustes
        	$res 	=	$this->ajustes_model->m_generales($datos);

        	// Comprobamos resultados de la Transacción
        	if($res){
        		echo 1; // Success
        	}else{
        		echo 0; // Error
        	}
        }

	}// End generales()

}// End class