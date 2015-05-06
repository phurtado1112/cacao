<?php
class Tipo_moneda_model extends CI_Model{
    
    public function __construct(){
            parent:: __construct();
            $this->load->database();
}

function lista_moneda(){
    $tags = $this->db->query('select idmoneda, descripcion_moneda from tipo_moneda where idmoneda > 0');
    $dropdowns = $tags->result_array();
    foreach($dropdowns as $dropdown){
    $dropdownlist[$dropdown['idmoneda']] = $dropdown['descripcion_moneda'];
    
    }
    $finaldropdown = $dropdownlist;
    return $finaldropdown; 
}


}