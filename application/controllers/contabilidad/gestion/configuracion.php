<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Configuracion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
    }

    public function index() {
        $data['titulo'] = 'Configuracion';
        $this->load->view('modules/menu/menu_contabilidad', $data);
        $this->load->view('contabilidad/gestion/configuracion_modulo');
        $this->load->view('modules/foot/contabilidad/categoria_foot');
}

        }