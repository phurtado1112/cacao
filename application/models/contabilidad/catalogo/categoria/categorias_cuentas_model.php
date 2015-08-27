<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Categorias_cuentas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //listar activos e inactivos
    public function categorias_cuentas_paginacion($estado, $inicio, $num_por_pagina) {
        $datos = $this->db->query('SELECT idcategoria_cuenta,categoria,nombre,idestructura_base FROM categoria_cuenta_view WHERE estado=' . $estado . ' AND idcategoria_cuenta > 0 ORDER BY idestructura_base LIMIT ' . $inicio . ',' . $num_por_pagina . '');
        return $datos->result_array();
    }

    // numero de registros activos e inactivos
    public function numero_categorias_cuentas($estado) {
        $numero_registros = $this->db->query('SELECT idcategoria_cuenta,categoria,nombre FROM categoria_cuenta_view WHERE estado=' . $estado . '');
        return $numero_registros->num_rows();
    }

    //busqueda por ajax      
    public function buscar_categoria($campo, $valor, $inicio, $num_por_pagina) {

        if ($valor != "" && !empty($campo)) {
            $query = $this->db->query("select idcategoria_cuenta,categoria,nombre,estado from categoria_cuenta_view WHERE estado=1 AND " . $campo . " LIKE '%" . $valor . "%' ORDER BY idcategoria_cuenta LIMIT " . $inicio . "," . $num_por_pagina . "");
        }
        return $query->result_array();
    }

    public function numero_categorias_buscadas($campo, $valor) {
        $numero_registros = $this->db->query("SELECT idcategoria_cuenta,categoria,nombre FROM categoria_cuenta_view WHERE estado=1 AND " . $campo . " LIKE '%" . $valor . "%' ORDER BY idcategoria_cuenta");
        return $numero_registros->num_rows();
    }

    //agregar registros 
    public function agregar_categoria() {

        $form_data = $this->input->post();
        unset($form_data['botonSubmit']);

        $this->db->insert('categoria_cuenta', $form_data);
    }

    // activar o inactivar
    public function cambiar_estado_categoria($idcategorias, $estado) {

        $this->db->query('UPDATE categoria_cuenta SET estado=' . $estado . ' WHERE idcategoria_cuenta=' . $idcategorias);
    }

///metodo complementario para editar e inactivar 
    public function encontrar_por_id($idcategorias = NULL) {
        if ($idcategorias != NULL) {

            $query = $this->db->where('idcategoria_cuenta', $idcategorias);
            $query = $this->db->get('categoria_cuenta_view');
        }
        return $query->result_array();
    }

///metodo complementario para encontrar por campo 
    public function encontrar_por_campo($categoria, $idcategoria) {
        if ($categoria != NULL) {

            $query = $this->db->query('SELECT * FROM categoria_cuenta WHERE categoria_cuenta="' . $categoria . '" AND idcategoria_cuenta = "' . $idcategoria . '" ');
        }
        return $query->result_array();
    }

//para establecer numero de cuenta    
    public function encontrar_por_id_datos($idcategorias = NULL) {
        if ($idcategorias != NULL) {

            $query = $this->db->where('idcategoria_cuenta', $idcategorias);
            $query = $this->db->get('categoria_cuenta');
        }
        return $query->result_array();
    }

//modificar    
    public function modificar_categoria($idcategoria_cuenta) {
        $form_data = $this->input->post();
        unset($form_data['botonSubmit']);

        $this->db->where('idcategoria_cuenta', $idcategoria_cuenta);
        $this->db->update('categoria_cuenta', $form_data);
    }

/// metodo para listar por nombre

    function categoria_lista() {
        $query = $this->db->query('select idcategoria_cuenta,categoria_cuenta from categoria_cuenta WHERE estado = 1');
        return $query->result_array();
    }

    public function eliminar_categoria($idcategorias) {

        $this->db->query('DELETE FROM categoria_cuenta WHERE idcategoria_cuenta=' . $idcategorias);
    }

}

/*Fin del archivo my_model.php*/