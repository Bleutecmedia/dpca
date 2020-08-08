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

        // Saneamos los envíos por $_POST
		$this->input->post(NULL, TRUE);  // returns all POST items with XSS filter  

		// Procedemos a validar los campos desde el lado del servidor, enviados por el formulario desde $_POST
		$this->load->library('form_validation');// Cargamos la librería para Validaciones de CodeIgnite

	
	}// End generales()

}// End class