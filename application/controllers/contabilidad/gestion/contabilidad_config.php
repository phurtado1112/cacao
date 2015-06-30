<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Contabilidad_config extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contabilidad/operaciones/Contabilidad_config_model');
    }

    public function index() {
        $data['titulo']="Configuracion de Contabilidad";
    
        $this->load->view('modules/menu/menu_contabilidad', $data);
        $this->load->view('contabilidad/gestion/configuracion_modulo_view', $data);
        $this->load->view('modules/foot/contabilidad/administracion_config_foot');
    }

    public function contabilidad_config_guardar() {

//        filter_input(INPUT_POST, $variable_name);
//        filter_input(INPUT_POST, $variable_name);
//        filter_input(INPUT_POST, $variable_name);
//        filter_input(INPUT_POST, $variable_name);
//        filter_input(INPUT_POST, $variable_name);
//        filter_input(INPUT_POST, $variable_name);
//        filter_input(INPUT_POST, $variable_name);
//        filter_input(INPUT_POST, $variable_name);
//        filter_input(INPUT_POST, $variable_name);
//        filter_input(INPUT_POST, $variable_name);
//        filter_input(INPUT_POST, $variable_name);

        

}
}