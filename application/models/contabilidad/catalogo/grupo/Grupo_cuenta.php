<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Grupo_cuenta extends CI_Model{
    
    public function __construct() {
        parent::__construct();
         $this->load->database();
    }
    
    public function agregar(){
        
        $form_data = $this->input->post();
        unset($form_data['botonSubmit']);
        
        $this->db->insert('grupo_cuenta',$form_data);
    }
    
    public function encontrar_por_id($idgrupo = NULL) {
        if($idgrupo != NULL){
            
        $query = $this->db->where('idgrupo_cuenta',$idgrupo);
        $query = $this->db->get('grupo_cuenta_view');
            
        }
        return $query->result_array(); 
        
    }
    
    public function leer($estado) {
        
        if($estado== 0 || $estado==1){
        $query = $this->db->query('SELECT idgrupo_cuenta,grupo_cuenta,nivel,nivel_anterior,categoria FROM grupo_cuenta_view WHERE estado='.$estado.' AND idgrupo_cuenta>0');
        }
        return $query->result_array();
        
    }
    
    public function modificar($idgrupo){
         $form_data = $this->input->post();
         unset($form_data['botonSubmit']);
         
         $this->db->where('idgrupo_cuenta',$idgrupo);
         $this->db->update('grupo_cuenta',$form_data);
    }
    
    public function cambiar_estado($idgrupo,$estado){
         
        $this->db->query('UPDATE grupo_cuenta SET estado='.$estado.' WHERE idgrupo_cuenta='.$idgrupo );
         
    }
    
    /////////// lista por nombre de grupos
    
    function lista_grupo() {
        $query = $this->db->query('select idgrupo_cuenta,grupo_cuenta from grupo_cuenta WHERE estado > 0');
        $dropdowns = $query->result_array();
        foreach ($dropdowns as $dropdown) {
          $lista[$dropdown['idgrupo_cuenta']] = $dropdown['grupo_cuenta'];
        }
        $option = $lista;
        return $option;
      }
   
}

/*Fin del archivo my_model.php*/