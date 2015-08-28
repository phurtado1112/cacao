<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cuentas_contable_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function catalogo_cuenta_contable_reporte($inicio, $num_por_pagina) {
        $this->db->select('idcuenta_contable, cuenta_contable, naturaleza_cuenta_contable, grupo_cuenta, categoria_cuenta');
        $this->db->from('catalogo_cuenta_reporte_view');
        $this->db->where('estado','Activo');
        $this->db->order_by('idcuenta_contable', 'ASC');
        $this->db->limit($inicio, $num_por_pagina);
        $datos = $this->db->get();
        return $datos->result_array();
    }

    // numero de registros
    public function cantidad_cuentas_contables() {
        $this->db->select('idcuenta_contable, cuenta_contable, naturaleza_cuenta_contable, grupo_cuenta, categoria_cuenta');
        $this->db->from('catalogo_cuenta_reporte_view');
        $this->db->where('estado','Activo');
        $datos = $this->db->get();
        return $datos->num_rows();
    }

}
