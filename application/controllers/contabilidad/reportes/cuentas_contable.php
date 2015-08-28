<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cuentas_contable extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $data['titulo'] = 'Catalogo Cuentas';
        $this->load->view('modules/menu/menu_contabilidad', $data);
        $this->load->model('contabilidad/reportes/cuentas_contable_model');
    }

    public function index() {
        $this->load->view('contabilidad/reportes/cuentas_contables_rep_view');
        $this->load->view('modules/foot/contabilidad/reporte_foot');
    }

    public function cuentas_contables_reporte($inicio=0) {
        
        //configuramos la url de la paginacion
        $config['base_url'] = base_url() . 'index.php/contabilidad/reportes/cuentas_contable/cuentas_contables_reporte';
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['total_rows'] = $this->cuentas_contable_model->cantidad_cuentas_contables();
        $config['per_page'] = 50;
        $config['num_links'] = 4;
        $config['uri_segment'] = 5;
        //configuracion de estilo de paginacion 
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        //cargamos la librería con nuestra configuracion
        $this->jquery_pagination->initialize($config);

        //obtemos los valores
        $query_cuentas = $this->cuentas_contable_model->catalogo_cuenta_contable_reporte($inicio, $config['per_page']);
        $paginacion = $this->jquery_pagination->create_links();

        $data['num'] = $inicio;
        $data['cuentas'] = $query_cuentas;
        $data['paginacion'] = $paginacion;
        
//        $cuentas['cuentas'] = $this->cuentas_contable_model->catalogo_cuenta_contable_reporte();
        $this->load->view('contabilidad/reportes/cuentas_contables_rep_ajax_view',$data);
    }

    public function generar_pdf() {
        
    }

}
