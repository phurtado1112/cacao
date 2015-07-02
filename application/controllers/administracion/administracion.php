<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Administracion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('loged_in') != true) {

            exit('<script>alert("no tiene acceso");window.location=("http://localhost/cacao");</script>');
        }
        $data['titulo'] = 'Administracion';
        $this->load->view('modules/menu/menu_administracion');
        $this->load->view('administracion/index');
        $this->load->view('modules/foot');
    }

    public function index() {
        
    }

}

/*Fin del archivo my_controller.php*/