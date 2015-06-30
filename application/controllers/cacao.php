<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}
class Cacao extends CI_Controller{
 
    public function __construct() {
        parent::__construct(); 
        $this->load->view('login');
    }
    
    public function index() {
         
    }
    
}