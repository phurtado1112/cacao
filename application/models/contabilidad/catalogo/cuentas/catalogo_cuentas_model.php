<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Catalogo_cuentas_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
         $this->load->database();
    }
    //agregar un nuevo catalogo de cuentas
    public function agregar_catalogo(){
        
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
    

    //editar catalogo
    public function modificar_catalogo($idcategorias){
         $form_data = $this->input->post();
         unset($form_data['botonSubmit']);
         
         $this->db->where('idcuenta_contable',$idcategorias);
         $this->db->update('catalogo_cuenta',$form_data);
    }
    
    
    //activar o inactivar
    public function cambiar_estado_catalogo($idcategorias,$estado){
         
        $this->db->query('UPDATE catalogo_cuenta SET estado='.$estado.' WHERE idcuenta_contable='.$idcategorias );
         
    }
    
    
     //listar activos e inactivos 
    public function catalogo_cuentas_paginacion($estado,$inicio,$num_por_pagina) {
       $datos = $this->db->query('SELECT idcuenta_contable,cuenta,naturaleza,grupo_cuenta FROM catalogo_cuenta_view WHERE estado='.$estado.' ORDER BY idcuenta_contable LIMIT '.$inicio.','.$num_por_pagina.'');
       return $datos->result_array();
    }
    
    
    // numero de registros activos e inactivos
    public function numero_catalogo_cuentas($estado) {
       $numero_registros = $this->db->query('SELECT idcuenta_contable,cuenta,naturaleza,grupo_cuenta FROM catalogo_cuenta_view WHERE estado='.$estado.'');
        return $numero_registros->num_rows();
    }
    
    
    //lista catalogo de cuentas
    function catalogo_lista() {
        $query_cuentas = $this->db->query('select idcuenta_contable,cuenta_contable from catalogo_cuenta WHERE estado > 0');
        $dropdowns = $query_cuentas->result_array();
        foreach ($dropdowns as $dropdown) {
          $lista[$dropdown['idcuenta_contable']] = $dropdown['cuenta_contable'];
        }
        $option = $lista;
        return $option;
      }
      
      
      //busqueda por ajax
       public function buscar($campo,$valor){
          
          if($valor != NULL && !empty($campo)){
         
        $query = $this->db->query("select idcuenta_contable,cuenta,naturaleza,grupo_cuenta, estado from catalogo_cuenta_view WHERE estado > 0 AND ".$campo." like '".$valor."%'");
       
            
        }
        
        return $query->result_array();
      }
      
      
   
}

/*Fin del archivo my_model.php*/