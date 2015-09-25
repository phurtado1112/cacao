<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Grupo_cuentas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //listar activos e inactivos 
    public function grupo_cuentas_paginacion($estado, $inicio, $num_por_pagina) {
        $datos = $this->db->query('SELECT idgrupo_cuenta,grupo_cuenta,nivel,nivel_anterior,categoria FROM grupo_cuenta_view WHERE estado=' . $estado . ' AND idgrupo_cuenta > 0 ORDER BY idgrupo_cuenta LIMIT ' . $inicio . ',' . $num_por_pagina . '');
        return $datos->result_array();
    }

    // numero de registros activos e inactivos
    public function numero_grupo_cuentas($estado) {
        $numero_registros = $this->db->query('SELECT idgrupo_cuenta,grupo_cuenta,nivel,nivel_anterior,categoria FROM grupo_cuenta_view WHERE estado=' . $estado . '');
        return $numero_registros->num_rows();
    }

    public function grupo_buscar($campo, $valor, $inicio, $num_por_pagina) {
        if ($valor != "" && !empty($campo)) {

            $query = $this->db->query("select idgrupo_cuenta,grupo_cuenta,nivel,nivel_anterior, categoria , estado from grupo_cuenta_view WHERE estado=1 AND " . $campo . " LIKE '%" . $valor . "%' ORDER BY idgrupo_cuenta LIMIT " . $inicio . "," . $num_por_pagina . "");
        }
        return $query->result_array();
    }

    public function numero_grupo_ciuentas_buscadas($campo, $valor) {
        $numero_registros = $this->db->query("SELECT idgrupo_cuenta,grupo_cuenta,nivel,nivel_anterior,categoria FROM grupo_cuenta_view WHERE estado=1 AND " . $campo . " LIKE '%" . $valor . "%' ORDER BY idgrupo_cuenta");
        return $numero_registros->num_rows();
    }

    public function grupo_agregar() {

        $form_data = $this->input->post();
        unset($form_data['botonSubmit']);

        $this->db->insert('grupo_cuenta', $form_data);
    }

    public function encontrar_por_id($idgrupo = NULL) {
        if ($idgrupo != NULL) {

            $query = $this->db->where('idgrupo_cuenta', $idgrupo);
            $query = $this->db->get('grupo_cuenta_view');
        }
        return $query->result_array();
    }

    public function encontrar_por_id_datos($idgrupo = NULL) {
        if ($idgrupo != NULL) {

            $query = $this->db->where('idgrupo_cuenta', $idgrupo);
            $query = $this->db->get('grupo_cuenta');
        }
        return $query->result_array();
    }

    public function grupo_modificar($idgrupo) {
        $form_data = $this->input->post();
        unset($form_data['botonSubmit']);

        $this->db->where('idgrupo_cuenta', $idgrupo);
        $this->db->update('grupo_cuenta', $form_data);
    }

    public function grupo_cambiar_estado($idgrupo, $estado) {

        $this->db->query('UPDATE grupo_cuenta SET estado=' . $estado . ' WHERE idgrupo_cuenta=' . $idgrupo);
    }

    /////////// lista por nombre de grupos

    function lista_grupo() {
        $query = $this->db->query('select idgrupo_cuenta,grupo_cuenta from grupo_cuenta WHERE estado > 0 AND idgrupo_cuenta >0 AND acepta_cuenta = 1');
        $dropdowns = $query->result_array();
        if ($dropdowns) {
            foreach ($dropdowns as $dropdown) {
                $lista[$dropdown['idgrupo_cuenta']] = $dropdown['grupo_cuenta'];
            }
        } else {
            $lista = "";
        }

        $option = $lista;
        return $option;
    }

    public function lista_grupo_por_nivel_categoria($campo, $valor, $campo_c, $valor_c) {
        
        $query = $this->db->query("SELECT idgrupo_cuenta,grupo_cuenta FROM grupo_cuenta WHERE (" . $campo . "=" . $valor . " AND  " . $campo_c . "=" . $valor_c . ") AND (estado=1 OR idgrupo_cuenta=0 )");
        return $query->result_array();
    }

    public function grupo_dependencia_categoria($campo, $valor) {
        $query = $this->db->query("select * from grupo_cuenta WHERE " . $campo . "=" . $valor . "");
        return $query->result_array();
    }

    public function eliminar_grupo($idgrupo) {
        $this->db->query('DELETE FROM grupo_cuenta WHERE idgrupo_cuenta =' . $idgrupo);
    }
    /// reportes
    
     public function grupo_lista( $idgrupo_cuenta) {
        $query = $this->db->where('idgrupo_cuenta', $idgrupo_cuenta);
        $query = $this->db->get('grupo_cuenta');
            
        return $query->result_array();
    }
    
    ////////////////////////////
    public function buscar_grupo_reporte($campo, $valor) {
        $numero_registros = $this->db->query("SELECT * FROM grupo_cuenta WHERE idcategoria_cuenta=".$campo." AND nivel=".$valor." ");
        return $numero_registros->result_array();
    }
    
    public function buscar_grupo_reporte_niveles($campo, $valor) {
        $numero_registros = $this->db->query("SELECT * FROM grupo_cuenta WHERE idnivel_anterior=".$campo." AND nivel=".$valor." ");
        return $numero_registros->result_array();
    }
    
//    function lista_grupo_reporte() {
//        $query = $this->db->query('select idgrupo_cuenta,grupo_cuenta from grupo_cuenta WHERE estado > 0 AND idgrupo_cuenta >0 AND acepta_cuenta = 1');
//        return $query->result_array();
//        
//    }

}

/*Fin del archivo my_model.php*/