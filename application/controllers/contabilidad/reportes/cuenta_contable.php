<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cuenta_contable extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $data['titulo'] = 'Catalogo Cuentas';
        $this->load->view('modules/menu/menu_contabilidad', $data);
        $this->load->model('contabilidad/reportes/jasper_model');
    }

    public function index() {
        
    }

    public function cuentas_contables_reporte() {
        $this->load->view('modules/foot/contabilidad/reporte_foot');
    }

    function pdf() {
        $this->load->helper('jasperclient_helper');
        $c = new Client('http://localhost:8080/jasperserver/services/repository?wsdl', 'cacaojasperuser', 'Cju2015');
        $controls = array(XXX);
        $report = $c->reportService()->runReport('XXX', 'pdf', null, null, $controls);
        $data["report"] = $report;
        $this->load->view('jasperreport_view', $data);
    }

    public function ejecutar() {
        $ruta = 'reportes/reporte_cuentas_contables.pdf';
        $parametros = array();
//        $this->load->view('contabilidad/reportes/reporte_prueba_view');
        $pdf = $this->jasper_model->generarReportePdf('/reports/contabilidad/', 'prueba', $parametros, $ruta);
        $this->load->view('modules/foot/contabilidad/reporte_foot');
        if ($pdf) {
            echo 'EL DATO DE PDF ES: ' . $pdf;
        } else {
            echo 'NO HAY DATOS';
        }
    }

}
