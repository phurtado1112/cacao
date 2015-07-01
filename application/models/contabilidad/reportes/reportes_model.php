<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Reportes_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function catalogo_cuenta_contable_reporte() {
         $this->db->select('idcuenta_contable, cuenta_contable, naturaleza_cuenta_contable, grupo_cuenta, categoria_cuenta');
         $datos = $this->db->get('catalogo_cuenta_reporte_view');
         return $datos;
    }
}
