<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Catalogo_cuentas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    } 

    //agregar un nuevo catalogo de cuentas
    public function agregar_catalogo() {

        $form_data = $this->input->post();
        unset($form_data['botonSubmit']);
        
        $this->db->insert('catalogo_cuenta', $form_data);
    }
    
    
       ///////////////////////////////////////////////////////////
    

    public function encontrar_por_id($idcuenta = NULL) {
        if ($idcuenta != NULL) {

            $query = $this->db->where('idcuenta_contable', $idcuenta);
            $query = $this->db->get('catalogo_cuenta_view');
        }
        return $query->result_array();
    }

    //editar catalogo
    public function modificar_catalogo($idcategorias) {
        $form_data = $this->input->post();
        unset($form_data['botonSubmit']);

        $this->db->where('idcuenta_contable', $idcategorias);
        $this->db->update('catalogo_cuenta', $form_data);
    }

    //activar o inactivar
    public function cambiar_estado_catalogo($idcategorias, $estado) {

        $this->db->query("UPDATE catalogo_cuenta SET estado=" . $estado ." WHERE idcuenta_contable='" . $idcategorias."'");
    }

    //listar activos e inactivos 
    
    public function catalogo_cuentas_paginacion($estado, $inicio, $num_por_pagina) {
        $datos = $this->db->query('SELECT idcuenta_contable,cuenta,naturaleza,grupo_cuenta FROM catalogo_cuenta_view WHERE estado=' . $estado . ' ORDER BY idcuenta_contable LIMIT ' . $inicio . ',' . $num_por_pagina . '');
        return $datos->result_array();
    }

    // numero de registros activos e inactivos
    public function numero_catalogo_cuentas($estado) {
        $numero_registros = $this->db->query('SELECT idcuenta_contable,cuenta,naturaleza,grupo_cuenta FROM catalogo_cuenta_view WHERE estado=' . $estado . '');
        return $numero_registros->num_rows();
    }

    //busqueda por ajax
    public function catalogo_buscar($campo, $valor, $inicio, $num_por_pagina) {

        if ($valor != NULL && !empty($campo)) {
            $query = $this->db->query("select idcuenta_contable,cuenta,naturaleza,grupo_cuenta, estado from catalogo_cuenta_view WHERE estado=1 AND " . $campo . " like '%" . $valor . "%' ORDER BY idcuenta_contable LIMIT " . $inicio . "," . $num_por_pagina . "");
        }

        return $query->result_array();
    }

    public function numero_cuentas_buscadas($campo, $valor) {
        $numero_registros = $this->db->query("SELECT idcuenta_contable,cuenta,naturaleza,grupo_cuenta FROM catalogo_cuenta_view WHERE estado=1 AND " . $campo . " LIKE '%" . $valor . "%' ORDER BY idcuenta_contable");
        return $numero_registros->num_rows();
    }
    
     public function cuenta_dependencia_grupo($campo, $valor) {
        $query = $this->db->query("select * from catalogo_cuenta WHERE " . $campo . "=" . $valor . "");
        return $query->result_array();
    }
    public function cuenta_dependencia_campo($campo, $valor) {
        $query = $this->db->query("select * from catalogo_cuenta WHERE " . $campo . "=" . $valor . "");
        return $query->result_array();
    }
   
     public function eliminar_cuenta($idcuenta){
         
        $this->db->query('DELETE FROM catalogo_cuenta WHERE idcuenta_contable="'.$idcuenta.'"');
    }
    //reporte
    
    public function cuentas_lista( $estado=1) {
        $query = $this->db->where('estado', $estado);
        $query = $this->db->get('catalogo_cuenta');
            
        return $query->result_array();
    }
    /////////////////
     public function encontrar_por_idgrupo($idgrupo_cuenta, $estado=1 ){
        if ($idgrupo_cuenta != NULL) {

            $query = $this->db->where('idgrupo_cuenta', $idgrupo_cuenta);
            $query = $this->db->where('estado', $estado);
            $query = $this->db->get('catalogo_cuenta');
        }
        return $query->result_array();
    }
    
    

}

/*Fin del archivo my_model.php*/