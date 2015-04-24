<?php
class Origen_asiento_diario_model extends CI_Model{
    
    public function __construct(){
            parent:: __construct();
            $this->load->database();
}

function lista_origen_asiento_diario(){
    $tags = $this->db->query('select idorigen_asiento_diario, descripcion_origen_asiento_diario from origen_asiento_diario where idorigen_asiento_diario > 0');
    $dropdowns = $tags->result_array();
    foreach($dropdowns as $dropdown){
    $dropdownlist[$dropdown['idorigen_asiento_diario']] = $dropdown['descripcion_origen_asiento_diario'];
    
    }
    $finaldropdown = $dropdownlist;
    return $finaldropdown; 
}


}