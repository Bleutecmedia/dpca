<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Name:    Dpca_model
 * Author:  Rigoberto Alejandres
 * Email: 	isc.alej@gmail.com
 * Twitter: @iscalej
 * Created:  08.08.2020
 * Description:  Modelo para administrar los DPCA
 */

class Dpca_model extends CI_Model{

	function __construct(){
		parent::__construct();
    }

    /**
    * Función del Modelo para administrar los Intercambios del DPCA
    */
    public function m_intercambios($id="",$p1=""){
        switch ($id) {
            case 1: // LISTAR
                if(isset($p1['ban']) && $p1['ban'] == 1){ // Retorna datos de un Intercambio en base a su ID
                    $q  =   $this
                        ->db
                        ->select('intercambios.*')
                        ->from('intercambios')
                        ->join('users','users.id = intercambios.in_userid')
                        ->order_by('intercambios.in_fecha','DESC')
                        ->limit (1)
                        ->where($p1['sql'])
                        ->get();

                    if ($q->num_rows() > 0){
                        foreach ($q->result() as $row) {
                            return $row;
                        }
                        return $q->num_rows();
                    }
                    return false;

                }else if(isset($p1['ban']) && $p1['ban'] == 2){// Retorna datos del último DCPA del día abierto
                    $q  =   $this
                        ->db
                        ->select('intercambios.*')
                        ->from('intercambios')
                        ->join('users','users.id = intercambios.in_userid')
                        ->order_by('id','DESC')
                        ->limit (1)
                        ->where($p1['sql'])
                        ->get();

                    if ($q->num_rows() > 0){
                        foreach ($q->result() as $row) {
                            return $row;
                        }
                        return $q->num_rows();
                    }
                    return false;

                }
                break;

            case 2: // TRANSACCIONES
                //Iniciamos la Transacción manual
                $this->db->trans_begin();

                if(isset($p1['ban']) && $p1['ban'] == 1){// Abre un Intercambio DPCA
                    // Quitamos ban
                    unset($p1['ban']);

                    // Guardamos registro
                    $this->db->insert('intercambios',$p1);

                }else if(isset($p1['ban']) && $p1['ban'] == 2){

                }

                //Comprobamos el resultado de las Transacciones
                if ($this->db->trans_status() === FALSE ) {//No se ejecutó, deshacemos los cambios y retornamos FALSE
                    $this->db->trans_rollback(); //Deshacemos los cambios
                    return FALSE;
                }else{//Si se realizó, completamos la transacción y retornamos TRUE
                    $this->db->trans_complete();/* Ejecutamos la Transacción */
                    return TRUE;
                }
                break;
            
            default: // Retorna total de DPCA de en un día
                $q  =   $this
                        ->db
                        ->select('*')
                        ->from('intercambios')
                        ->join('users','users.id = intercambios.in_userid')
                        ->where($p1['sql'])
                        ->get();

                    if ($q->num_rows() > 0){
                        return $q->num_rows();
                    }
                    return 0;

                break;
        }
    }


    /** 
    *	Función del Modelo para retornar último registro de una tabla
    */
	public function m_last($p1=""){
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

	}//End function last

}// End class

/* End of file Usuarios_model.php */
/* Location: ./application/models/Usuarios_model.php */