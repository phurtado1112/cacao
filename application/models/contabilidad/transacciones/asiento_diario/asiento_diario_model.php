<?php if (! defined ('BASEPATH')) {exit ('No direct script access allowed');};

class Asiento_diario_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
    }
    
     public function asiento_diario_listar(){
         $this->load->database();
         $query = $this->db->query('select idasiento_diario, numero_asiento_diario, origen, descripcion_asiento_diario, fecha_creacion, balance_debito, balance_credito from asiento_diario_view where idasiento_diario >0');
                 
        return $query->result_array();
   }
   
      public function asiento_diario_listar_num(){
         $this->load->database();
         $query = $this->db->query('select idasiento_diario, numero_asiento_diario, origen, descripcion_asiento_diario, fecha_creacion, balance_debito, balance_credito from asiento_diario_view where idasiento_diario >0');
                 
        return $query->num_rows();
   }
   
   public function asiento_diario_crear($numero_asiento_diario, $idorigen_asiento_diario, $descripcion_asiento_diario,
        $fecha_creacion, $fecha_fiscal, $usuario_creacion, $idtasa_cambio, $balance_debito, $balance_credito
           ){
             $this->db->query("INSERT INTO asiento_diario(
             numero_asiento_diario, idorigen_asiento_diario, descripcion_asiento_diario, fecha_creacion, fecha_fiscal, usuario_creacion, idtasa_cambio, balance_debito, balance_credito
             ) VALUES( '".$numero_asiento_diario."',".$idorigen_asiento_diario.",'".$descripcion_asiento_diario."', '".$fecha_creacion."','".$fecha_fiscal."','".$usuario_creacion."',".$idtasa_cambio.",".$balance_debito.",".$balance_credito.")");
            }
            
            
    public function asiento_diario_encontrar_por_id($idasiento_diario = NULL) {
        if($idasiento_diario != NULL){
            
        $query = $this->db->where('idasiento_diario',$idasiento_diario);
        $query = $this->db->get('asiento_diario_view');
            
        }
        return $query->result_array(); 
        
    }
  ////////////////////lista de idasiento_diario///////////////////////////////////
 
    public function volver_idasiento_diario(){
        $query = $this->db->query("select idasiento_diario from asiento_diario");
        
        return $query->result_array();
    }
    
    
  ////////////////////////////////////////////////////////////////////////////////  
    public function asiento_diario_modificar($idasiento_diario){
         $form_data = $this->input->post();
         unset($form_data['botonSubmit']);
         
         $this->db->where('idasiento_diario',$idasiento_diario);
         $this->db->update('idasiento_diario',$form_data);
    }
    
    public function asiento_diario_paginacion($inicio,$num_por_pagina) {
       $datos = $this->db->query('SELECT numero_asiento_diario,origen,descripcion_asiento_diario, fecha_creacion, balance_debito,balance_credito FROM asiento_diario_view WHERE idasiento_diario > 0 ORDER BY idasiento_diario LIMIT '.$inicio.','.$num_por_pagina.'');
       return $datos->result_array();
    }
    
 
    
     public function asiento_diario_buscar($campo, $valor, $inicio, $num_por_pagina) {

        if ($valor != NULL && !empty($campo)) {

            $query = $this->db->query("SELECT numero_asiento_diario,origen,descripcion_asiento_diario, fecha_creacion, balance_debito,balance_credito FROM asiento_diario_view WHERE idasiento_diario > 0 AND " . $campo . " like '" . $valor . "%'ORDER BY idasiento_diario LIMIT " . $inicio . "," . $num_por_pagina . "");
        }

        return $query->result_array();
    }
  
 
 
  
}
