<?php
/**
 * Name:    Datos Controller
 * Author:  Rigoberto Alejandres
 * Email: 	isc.alej@gmail.com
 * @iscalej
 * Created:  28.11.2017
 * Description:  Controlador para administrar los Datos en la Aplicación.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Datos extends CI_Controller {

	public function __construct(){
		parent::__construct();
		//Cargamos los Modelos de Datos
		$this->load->model('data_model');
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

	public function validate(){
		//FUNCIÓN PARA VALIDAR CAMPOS ÚNICOS EN LA BASE DE DATOS

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
		$campo1 =	$this->input->get('fieldId');		// ID del campo a validar
		$term 	=	$this->input->get('fieldValue');	// Valor del campo a validar
		$id_r 	=	$this->input->get('id');			// ID llave primaria

		//La bandera nos indica en qué tabla está el campo a validar validar
		switch ($campo1){
			case 'nombre_del_campo':

				break;
			default:// Valida barcode
				$tabla 		=	""; // Nombre de la Tabla de la cual validar campo
				$campo2 	=	""; // Nombre de la Llave primaria de la tabla
				break;
		}
		
		//Creamos el array para la consulta
		$c1['tabla']	=	$tabla;
		$c1['campo1']	=	$campo1;
		$c1['campo2']	=	$campo2;
		$c1['term']		=	$term;
		$c1['id_r']		=	$id_r;

		//Llamamos la función del Modelo para procesar la respuesta
		$res 	=	$this->data_model->m_validate($c1);

		//Procesamos la respuesta
		if($res){
			$bandera 	= FALSE;
			$msj 		= 'Este Anillo ya lo tiene otro Gallo'; 
		}else{
			$bandera 	= TRUE;
			$msj 		= 'Este Anillo es válido, puede continuar...'; 
		}

		//Retornamos el resultado para a validación
		$result = ["$campo1",$bandera,$msj];
		echo json_encode($result);

	}//End function validate()


	public function validateanillo(){
		//FUNCIÓN PARA VALIDAR CAMPOS ÚNICOS EN LA BASE DE DATOS

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
		$anillo 		=	$this->input->get('fieldId');	// Campo a validar
		$c1['anillo'] 	=	$anillo;
		$c1['valor'] 	=	$this->input->get('fieldValue');// Valor a validar
		$c1['gaid'] 	=	$this->input->get('id');		// ID del Gallo
		$c1['userid'] 	=	$this->input->get('userid');	// ID del Usuario dueno del Gallo

		//Llamamos la función del Modelo para procesar la respuesta
		$res 	=	$this->data_model->m_validate_anillo($c1);

		//Procesamos la respuesta
		if($res){
			$bandera 	= FALSE;
			$msj 		= 'Este Anillo ya lo tiene otro Gallo'; 
		}else{
			$bandera 	= TRUE;
			$msj 		= 'Este Anillo es válido, puede continuar...'; 
		}

		//Retornamos el resultado para a validación
		$result = ["$anillo",$bandera,$msj];
		echo json_encode($result);

	}//End function validateanillo()

}