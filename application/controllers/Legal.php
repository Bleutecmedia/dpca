<?php
/**
 * Name:    	Legal
 * Author:  	Rigoberto Alejandres
 * Email: 		isc.alej@gmail.com
 * Twitter: 	@iscalej
 * Created:  	30.07.2019
 * Description: Controlador para administrar lo Legal
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Legal extends CI_Controller {

	public function __construct(){
		parent::__construct();
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
	
	}// End index


	public function licencia(){
		// Función del Controlador para gestionar la Licencia
        
        //Para evitar el acceso directo que no sea via ajax 
		if (!$this->input->is_ajax_request()) {
            header('Location: '.base_url(), true, 302);
            exit;
        }

        $this->load->view('legal/legal_licencia_view');
	}// End Licencia


	public function tos(){
		// Función del Controlador para gestionar los Términos y Condiciones
        
        //Para evitar el acceso directo que no sea via ajax 
		if (!$this->input->is_ajax_request()) {
            header('Location: '.base_url(), true, 302);
            exit;
        }

        $this->load->view('legal/legal_tos_view');
	}// End TOS


	public function privacidad(){
		// Función del Controlador para gestionar la Declaratoria de la Privacidad

        //Para evitar el acceso directo que no sea via ajax 
		if (!$this->input->is_ajax_request()) {
            header('Location: '.base_url(), true, 302);
            exit;
        }

        $this->load->view('legal/legal_privacidad_view');
	}// End Privacidad

}