<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Name:    Reportes_model
 * Author:  Rigoberto Alejandres
 * Email: 	isc.alej@gmail.com
 * Twitter: @iscalej
 * Created:  09.08.2020
 * Description:  Modelo para administrar los Reportes
 */

class Reportes_model extends CI_Model{

	function __construct(){
		parent::__construct();
    }

    /**
    * Función del Modelo para administrar los Intercambios del DPCA
    */
    public function m_intercambios($id="",$p1=""){
        switch ($id) {
            case 1: // LISTAR
                if(isset($p1['ban']) && $p1['ban'] == 1){// DATABLE: Retorna todos los registros CON Limit
                    $q  =   $this
                        ->db
                        ->select('intercambios.*,soluciones.*,users.id AS "userid"')
                        ->from('intercambios')
                        ->join('users','users.id = intercambios.in_userid')
                        ->join('soluciones','soluciones.solid = intercambios.in_solid')
                        ->limit($p1['length'], $p1['start'])
                        ->where($p1['sql'])
                        ->order_by($p1['orderby'],$p1['ordertype'])
                        ->get();

                    if ($q->num_rows() > 0){
                        return $q->result();
                    }
                    return false;

                }else if(isset($p1['ban']) && $p1['ban'] == 2){// DATATABLE: Retorna el total de registros
                    $q  =   $this
                            ->db
                            ->select("interid")
                            ->from('intercambios')
                            ->join('users','users.id = intercambios.in_userid')
                            ->join('soluciones','soluciones.solid = intercambios.in_solid')
                            ->get();

                    if ($q->num_rows() > 0){
                        return $q->num_rows();
                    }
                    return 0;

                }else if(isset($p1['ban']) && $p1['ban'] == 3){// DATABLE: Retorna todos los registros SIN Limit
                    $q  =   $this
                            ->db
                            ->select("interid")
                            ->from('intercambios')
                            ->join('users','users.id = intercambios.in_userid')
                            ->join('soluciones','soluciones.solid = intercambios.in_solid')
                            ->where($p1['sql'])
                            ->order_by($p1['orderby'],$p1['ordertype'])
                            ->get();

                    if ($q->num_rows() > 0){
                        return $q->num_rows();
                    }
                    return 0;
                    
                }else if(isset($p1['ban']) && $p1['ban'] == 4){// Retorna intercambios para el Reporte
                    $q  =   $this
                        ->db
                        ->select('intercambios.*,soluciones.*,users.id AS "userid"')
                        ->from('intercambios')
                        ->join('users','users.id = intercambios.in_userid')
                        ->join('soluciones','soluciones.solid = intercambios.in_solid')
                        ->where($p1['sql'])
                        ->order_by('in_fecha','ASC')
                        ->get();

                    if ($q->num_rows() > 0){
                        return $q->result();
                    }
                    return false;

                }else if(isset($p1['ban']) && $p1['ban'] == 5){// Retorna intercambios para el Reporte
                    $q  =   $this
                        ->db
                        ->select('intercambios.*,soluciones.*,users.id AS "userid"')
                        ->from('intercambios')
                        ->join('users','users.id = intercambios.in_userid')
                        ->join('soluciones','soluciones.solid = intercambios.in_solid')
                        ->where($p1['sql'])
                        ->order_by('in_fecha','DESC')
                        ->limit (1)
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

                if(isset($p1['ban']) && $p1['ban'] == 1){


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

                break;
        }
    }// End


}// End class

/* End of file Reportes_model.php */
/* Location: ./application/models/Reportes_model.php */