<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Cacao extends CI_Controller{
 
    public function __construct() {
        parent::__construct();   
        $this->load->helper('url');

    }
    
    public function index() {
         $this->load->view('login');
    }
    
}

/*Fin del archivo my_controller.php*/