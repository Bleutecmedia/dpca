<?php
/**
 * Name:    Ajustes_model
 * Author:  Rigoberto Alejandres
 * Email: 	isc.alej@gmail.com
 * @iscalej
 * Created:  23.06.2018
 * Description:  Modelo para administrar las Opciones de Configuración de la Aplicación.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajustes_model extends CI_Model{

	public function m_app(){
		// Función del Modelo para retornar los Ajustes de la Aplicación

		// Capuramos ID del Usuario logueado
		$userid 	=	$this->session->userdata('user_id');

		//Función del Modelo para obtener las configuraciones del Sitio en la Base de Datos:
		$q  =   $this->db
                ->select('*')
                ->from('config')
				->join('users','users.id = config.conf_userid')
				->where('users.id',$userid)
                ->get();
	    
	    if($q->num_rows() > 0){
	    	foreach ($q->result() as $row) {
	    		return $row;
	    	}
	    }
	    return false;
	}// End m_app()


	public function m_generales($p1=""){
		// Función del Modelo para guardar los ajustes generales

		//Iniciamos la Transacción manual
		$this->db->trans_begin();

		// Capturamos ID del ajuste 
		$userid 	=	$p1['conf_userid'];

		// Ejecutamos la consulta
		$this->db->where('conf_userid',$userid)->update('config', $p1);

		//Comprobamos el resultado de las Transacciones
		if ($this->db->trans_status() === FALSE ) {//No se ejecutó, deshacemos los cambios y retornamos FALSE
		 	$this->db->trans_rollback(); //Deshacemos los cambios
		 	return FALSE;
		}else{//Si se realizó, completamos la transacción y retornamos TRUE
		 	$this->db->trans_complete();/* Ejecutamos la Transacción */
		 	return TRUE;
		}
		
	}// End m_generales

	public function m_validate($p1=""){
		//Función del Modelo para comprobar existencia de campos
		$q 	= 	$this
				->db
				->select($p1['campo1'])
				->from($p1['tabla'])
				->where($p1['campo1'],$p1['term'])
				->where($p1['campo2'].'<>',$p1['id_r'])
				->get();

		if ($q->num_rows() > 0){
			return TRUE;
		}
		return FALSE;
	}//End function m_validate


}// End class