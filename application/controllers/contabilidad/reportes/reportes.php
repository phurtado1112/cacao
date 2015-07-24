<?php

class Reportes_contabilidad extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('loged_in') != true) {
            exit('<script>alert("no tiene acceso");window.location=("http://localhost/cacao");</script>');
        }
        $data['titulo'] = 'Reporte Catalogo Cuentas';
        $this->load->view('modules/menu/menu_contabilidad', $data);
    }

    public function cuenta_contable_reporte() {
        $this->load->view('contabilidad/reportes/cuenta_contable_reporte_view');
        $this->load->view('modules/foot/contabilidad/reporte_ccc_foot');
    }

}
