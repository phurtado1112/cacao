<?php
class Tipo_moneda_model extends CI_Model{
    
    public function __construct(){
            parent:: __construct();
}

function lista_moneda() {
        $lista_moneda = $this->db->query('select idmoneda, descripcion_moneda,local from tipo_moneda ');
        return $lista_moneda->result_array();
        
    }

}