<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Name:    Usuarios_model
 * Author:  Rigoberto Alejandres
 * Email: 	isc.alej@gmail.com
 * Twitter: @iscalej
 * Created:  06.08.2020
 * Description:  Modelo para administrar los Usuarios.
 */

class Usuarios_model extends CI_Model{

	function __construct(){
		parent::__construct();
    }


    /** 
    *	Función del Modelo para administrar los datos de los Usuarios que ingresan a la aplicación
    */
    public function m_usuarios($id="",$p1=""){
    	// Decidimos qué hacer
    	switch ($id) {
    		case 1: // LISTAR
    			if(isset($p1['ban']) && $p1['ban'] == 1){

    			}else if(isset($p1['ban']) && $p1['ban'] == 2){

    			}else if(isset($p1['ban']) && $p1['ban'] == 3){

    			}
    			break;

    		case 2: // TRANSACCIONES
    			//Iniciamos la Transacción manual
                $this->db->trans_begin();

    			if(isset($p1['ban']) && $p1['ban'] == 1){// Guarda nuevo usuario o edita existente
    				// Capturamos
    				$accion 	=	$p1['accion'];

    				// Qutamos 
    				unset($p1['ban'],$p1['accion']);

    				// Decidimos qué hacer
    				if(isset($accion) && $accion == 1){ // NUEVO USUARIO
    					// Insertamos el registro
    					$this->db->insert('users',$p1);

                        // Asignamos Grupo al Usuario
                        $this->ion_auth->add_to_group(2, $p1['id']);

                        // Creamos el registro de configuración del Usuario
                        $this->db->insert('config',array('conf_userid'   => $p1['id']));

    				}else if(isset($accion) && $accion == 2){ // EDITAMOS EXISTENTE
    					// Capturamos
    					$userid 	=	$p1['id'];

    					// Quitamos
    					unset($p1['userid']);

    					// Actualizamos registro
    					$this->db->where('id',$userid)->update('users',$p1);

    				}

    			}else if(isset($p1['ban']) && $p1['ban'] == 2){

    			}else if(isset($p1['ban']) && $p1['ban'] == 3){

    			}

    			//Comprobamos el resultado de las Transacciones
                if ($this->db->trans_status() === FALSE) { //No se ejecutó, deshacemos los cambios y retornamos FALSE
                    $this->db->trans_rollback(); //Deshacemos los cambios
                    return FALSE;
                } else { //Si se realizó, completamos la transacción y retornamos TRUE
                    $this->db->trans_complete();/* Ejecutamos la Transacción */
                    return TRUE;
                }
    			break;
    		
    		default: // RETORNA LOS DATOS DE UN USUARIO LOCAL POR EMAIL
    			$q 	= 	$this
						->db
						->select('*')
						->from('users')
						->where('users.email',$p1['email'])
						->get();

					if ($q->num_rows() > 0){
						foreach ($q->result() as $row) {
							return $row;
						}
					}
					return false;

    			break;
    	}
    }// End m_usuarios



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