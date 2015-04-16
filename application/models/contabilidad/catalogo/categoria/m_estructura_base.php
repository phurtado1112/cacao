<?php

class M_Estructura_Base extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
     function lista_dropdown() {
        $tags = $this->db->query('select distinct idestructura_base,descripcion_estructura_base from estructura_base WHERE idestructura_base > 0');
        $dropdowns = $tags->result_array();
        foreach ($dropdowns as $dropdown) {
          $dropdownlist[$dropdown['idestructura_base']] = $dropdown['descripcion_estructura_base'];
        }
        $finaldropdown = $dropdownlist;
        return $finaldropdown;
      }
}