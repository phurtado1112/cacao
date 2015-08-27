<?php

class Estructura_base_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
     function estructura_base() {
        $tags = $this->db->query('select distinct idestructura_base,descripcion_estructura_base from estructura_base WHERE idestructura_base > 0');
        
        return $tags->result_array();
        
      }
}