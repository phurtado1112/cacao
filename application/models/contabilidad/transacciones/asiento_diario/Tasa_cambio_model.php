<?php
class Tasa_Cambio_model extends CI_Model{
    
    public function __construct(){
            parent:: __construct();
            $this->load->database();
}

function lista_tasa_cambio(){
    $tags = $this->db->query('select idtasa_cambio, tasa_cambio from tasa_cambio where idtasa_cambio > 0');
    $dropdowns = $tags->result_array();
    foreach($dropdowns as $dropdown){
    $dropdownlist[$dropdown['idtasa_cambio']] = $dropdown['tasa_cambio'];
    
    }
    $finaldropdown = $dropdownlist;
    return $finaldropdown; 
}


}