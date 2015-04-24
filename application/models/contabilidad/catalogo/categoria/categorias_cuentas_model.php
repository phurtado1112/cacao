<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Categorias_cuentas_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
         $this->load->database();
    }
    
    public function agregar(){
        
        $form_data = $this->input->post();
        unset($form_data['botonSubmit']);
        
        $this->db->insert('categoria_cuenta',$form_data);
    }
    
    public function encontrar_por_id($idcategorias = NULL) {
        if($idcategorias != NULL){
            
        $query = $this->db->where('idcategoria_cuenta',$idcategorias);
        $query = $this->db->get('categoria_cuenta_view');
            
        }
        return $query->result_array(); 
        
    }
    
    public function leer($estado){
        
        if($estado== 0 || $estado==1){
        $query = $this->db->query('SELECT idcategoria_cuenta,categoria,nombre FROM categoria_cuenta_view WHERE estado='.$estado.'');
        }
        
        return $query->result_array();
        
    }
    
    public function modificar($idcategoria_cuenta){
         $form_data = $this->input->post();
         unset($form_data['botonSubmit']);
         
         $this->db->where('idcategoria_cuenta',$idcategoria_cuenta);
         $this->db->update('categoria_cuenta',$form_data);
    }
    
    public function cambiar_estado($idcategorias,$estado){
         
        $this->db->query('UPDATE categoria_cuenta SET estado='.$estado.' WHERE idcategoria_cuenta='.$idcategorias );
         
    }
   
    //////////// metodo para listar por nombre
    
     function lista_categoria() {
        $query = $this->db->query('select idcategoria_cuenta,categoria_cuenta from categoria_cuenta WHERE estado > 0');
        $dropdowns = $query->result_array();
        foreach ($dropdowns as $dropdown) {
          $lista[$dropdown['idcategoria_cuenta']] = $dropdown['categoria_cuenta'];
        }
        $option = $lista;
        return $option;
      }
      
      public function buscar($campo,$valor){
          
          if($valor !=NULL && !empty($campo)){
         
        $query = $this->db->query("select idcategoria_cuenta,categoria,nombre,estado from categoria_cuenta_view WHERE estado > 0 AND ".$campo." LIKE '".$valor."%'");
        
        }
        
        return $query->result_array();
      }
      
   
}

/*Fin del archivo my_model.php*/