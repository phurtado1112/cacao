<?php if (! defined ('BASEPATH')) {exit ('No direct script access allowed');};

class Configuracion_empresa_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
    }
    
    public function configuracion_empresa_actualizar_origen_ad($campo,$idorigen_asiento_diario){
        $this->db->query("UPDATE configuracion_empresa SET ".$campo."='".$idorigen_asiento_diario."' WHERE idempresa = 1");             
   }
    
     public function configuracion_empresa_num_ad_cont(){
        $query = $this->db->query('select numero_ad_cont from configuracion_empresa');
                 
        return $query->result_array();
   }
   
     public function configuracion_empresa_num_ad_bco(){
        $query = $this->db->query('select numero_ad_bco from configuracion_empresa');
                 
        return $query->result_array();
   }  
  
     public function configuracion_empresa_num_ad_cp(){
        $query = $this->db->query('select numero_ad_cp from configuracion_empresa');
                 
        return $query->result_array();
   }
 
  
}
