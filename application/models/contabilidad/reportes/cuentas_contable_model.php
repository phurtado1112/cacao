<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cuentas_contable_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function catalogo_cuenta_contable_reporte($inicio, $num_por_pagina) {
        $this->db->select('idestructura_base, descripcion_estructura_base, idcategoria_cuenta, categoria_cuenta ,idnivel_anterior,idgrupo_cuenta, grupo_cuenta, idcuenta_contable, cuenta_contable');
        $this->db->from('catalogo_cuenta_reporte_view');
        $this->db->where('estado','1');
        $this->db->where('idcuenta_contable IS NOT NULL' ,null, false);
        $this->db->order_by('idestructura_base', 'ASC');
        $this->db->limit($inicio, $num_por_pagina);
        $datos = $this->db->get();
        return $datos->result_array();
    }
    
    public function catalogo_cuenta_contable_reporte_pdf() {
        $this->db->select('*');
        $this->db->from('catalogo_cuenta_reporte_view');
        $this->db->where('estado','1');
        $this->db->where('idcuenta_contable IS NOT NULL' ,null, false);
        $this->db->order_by('idestructura_base', 'ASC');
        $datos = $this->db->get();
        return $datos->result_array();
    }

    // numero de registros
    public function cantidad_cuentas_contables() {
        $this->db->select('idcuenta_contable, cuenta_contable, grupo_cuenta, categoria_cuenta');
        $this->db->from('catalogo_cuenta_reporte_view');
        $this->db->where('estado','1');
        $this->db->where('idcuenta_contable IS NOT NULL' ,null, false);
        $datos = $this->db->get();
        return $datos->num_rows();
    }
    
    public function buscar_cuenta_contable_saldos($cuenta ,$periodo) {
        $cuentas_saldos = $this->db->query('select '.$periodo.' from saldos where idcuenta_contable="'.$cuenta.'"');
        $cuetas_en_saldos = $cuentas_saldos->result_array();
        return $cuetas_en_saldos;
    }

}
