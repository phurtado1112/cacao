<?php if (! defined ('BASEPATH')) {exit ('No direct script access allowed');};

class Asiento_diario_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
    }
    
    public function listar(){
         $this->load->database();
         $query = $this->db->query('select idasiento_diario, numero_asiento_diario, origen, descripcion_asiento_diario, fecha_creacion, balance_debito, balance_credito from asiento_diario_view where idasiento_diario >0');
                 
        return $query->result_array();
   }
   
   public function crear(){
       $this->load->database();
       
       $form_data = $this->input->post();
       unset($form_data['botonSubmit']);
       $this->db->insert('asiento_diario',$form_data);
   }
   
    public function encontrar_por_id($idasiento_diario = NULL) {
        if($idasiento_diario != NULL){
            
        $query = $this->db->where('idasiento_diario',$idasiento_diario);
        $query = $this->db->get('asiento_diario_view');
            
        }
        return $query->result_array(); 
        
    }
    
    public function modificar($idasiento_diario){
         $form_data = $this->input->post();
         unset($form_data['botonSubmit']);
         
         $this->db->where('idasiento_diario',$idasiento_diario);
         $this->db->update('idasiento_diario',$form_data);
    }
    
   
  
}
