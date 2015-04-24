<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Catalogo_cuentas_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
         $this->load->database();
    }
    
    public function agregar(){
        
        $form_data = $this->input->post();
        unset($form_data['botonSubmit']);
        
        $this->db->insert('catalogo_cuenta',$form_data);
    }
    
    public function encontrar_por_id($idcuenta = NULL) {
        if($idcuenta != NULL){
            
        $query = $this->db->where('idcuenta_contable',$idcuenta);
        $query = $this->db->get('catalogo_cuenta_view');
            
        }
        return $query->result_array(); 
        
    }
    
    public function leer($estado) {
        
        if($estado== 0 || $estado==1){
        $query = $this->db->query('SELECT idcuenta_contable,cuenta,naturaleza,grupo_cuenta FROM catalogo_cuenta_view WHERE estado='.$estado.' AND idcuenta_contable >0');
        }
        return $query->result_array();
        
    }
    
    public function modificar($idcategorias){
         $form_data = $this->input->post();
         unset($form_data['botonSubmit']);
         
         $this->db->where('idcuenta_contable',$idcategorias);
         $this->db->update('catalogo_cuenta',$form_data);
    }
    
    public function cambiar_estado($idcategorias,$estado){
         
        $this->db->query('UPDATE catalogo_cuenta SET estado='.$estado.' WHERE idcuenta_contable='.$idcategorias );
         
    }
    
    function lista_cuentas() {
        $query_cuentas = $this->db->query('select idcuenta_contable,cuenta_contable from catalogo_cuenta WHERE estado > 0');
        $dropdowns = $query_cuentas->result_array();
        foreach ($dropdowns as $dropdown) {
          $lista[$dropdown['idcuenta_contable']] = $dropdown['cuenta_contable'];
        }
        $option = $lista;
        return $option;
      }
   
}

/*Fin del archivo my_model.php*/