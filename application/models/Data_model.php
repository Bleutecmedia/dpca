<?php
/**
 * Name:    Data_model
 * Author:  Rigoberto Alejandres
 * Email: 	isc.alej@gmail.com
 * @iscalej
 * Created:  30.06.2018
 * Description:  Modelo para retornar datos necesarios en la aplicación
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_model extends CI_Model{

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

	public function m_get_last_id($p1=""){
		//FUNCION DEL MODELO PARA OBTENER EL ULTIMO ID DEL REGISTRO DE UNA TABLA 

		$q 	= 	$this
				->db
				->select($p1['campo'].' AS "id"')
				->from($p1['tabla'])
				->order_by('id','DESC')
				->limit (1)
				->get();

		if ($q->num_rows() > 0){
			foreach ($q->result() as $row){
				return $row->id;
			}
		}
		return 0;
	}// End _m_get_last
	
}