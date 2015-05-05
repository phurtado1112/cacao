<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Categorias_cuentas_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
         $this->load->database();
    }
<<<<<<< HEAD
    
    public function agregar(){
=======
    //listar activos e inactivos
    public function categorias_cuentas_paginacion($estado,$inicio,$num_por_pagina) {
       $datos = $this->db->query('SELECT idcategoria_cuenta,categoria,nombre FROM categoria_cuenta_view WHERE estado='.$estado.' ORDER BY idcategoria_cuenta LIMIT '.$inicio.','.$num_por_pagina.'');
       return $datos->result_array();
    }
    // numero de registros activos e inactivos
    public function numero_categorias_cuentas($estado) {
       $numero_registros = $this->db->query('SELECT idcategoria_cuenta,categoria,nombre FROM categoria_cuenta_view WHERE estado='.$estado.'');
        return $numero_registros->num_rows();
    }
    //agregar registros 
    public function agregar_categoria(){
>>>>>>> c624373c90fda3b99490ea3309c22bd4a749c6ba
        
        $form_data = $this->input->post();
        unset($form_data['botonSubmit']);
        
        $this->db->insert('categoria_cuenta',$form_data);
    }
<<<<<<< HEAD
    
=======
    // activar o inactivar
    public function cambiar_estado_categoria($idcategorias,$estado){
         
        $this->db->query('UPDATE categoria_cuenta SET estado='.$estado.' WHERE idcategoria_cuenta='.$idcategorias );
    }
    
///metodo complementario para editar e inactivar 
>>>>>>> c624373c90fda3b99490ea3309c22bd4a749c6ba
    public function encontrar_por_id($idcategorias = NULL) {
        if($idcategorias != NULL){
            
        $query = $this->db->where('idcategoria_cuenta',$idcategorias);
        $query = $this->db->get('categoria_cuenta_view');
            
        }
        return $query->result_array(); 
<<<<<<< HEAD
        
    }
    
    public function leer($estado){
        
        if($estado== 0 || $estado==1){
        $query = $this->db->query('SELECT idcategoria_cuenta,categoria,nombre FROM categoria_cuenta_view WHERE estado='.$estado.'');
        }
        
        return $query->result_array();
        
    }
    
    public function modificar($idcategoria_cuenta){
=======
    }
//modificar    
    public function modificar_categoria($idcategoria_cuenta){
>>>>>>> c624373c90fda3b99490ea3309c22bd4a749c6ba
         $form_data = $this->input->post();
         unset($form_data['botonSubmit']);
         
         $this->db->where('idcategoria_cuenta',$idcategoria_cuenta);
         $this->db->update('categoria_cuenta',$form_data);
    }
    
<<<<<<< HEAD
    public function cambiar_estado($idcategorias,$estado){
         
        $this->db->query('UPDATE categoria_cuenta SET estado='.$estado.' WHERE idcategoria_cuenta='.$idcategorias );
         
    }
   
    //////////// metodo para listar por nombre
=======
/// metodo para listar por nombre
>>>>>>> c624373c90fda3b99490ea3309c22bd4a749c6ba
    
     function lista_categoria() {
        $query = $this->db->query('select idcategoria_cuenta,categoria_cuenta from categoria_cuenta WHERE estado > 0');
        $dropdowns = $query->result_array();
        foreach ($dropdowns as $dropdown) {
          $lista[$dropdown['idcategoria_cuenta']] = $dropdown['categoria_cuenta'];
        }
        $option = $lista;
        return $option;
      }
      
<<<<<<< HEAD
      public function buscar($campo,$valor){
          
          if($valor !=NULL && !empty($campo)){
         
        $query = $this->db->query("select idcategoria_cuenta,categoria,nombre,estado from categoria_cuenta_view WHERE estado > 0 AND ".$campo." LIKE '".$valor."%'");
        
        }
        
        return $query->result_array();
      }
      
=======
      
      
      
//busqueda por ajax      
      public function buscar_categoria($campo,$valor,$inicio,$num_por_pagina){
          
        if($valor !="" && !empty($campo)){
            $query = $this->db->query("select idcategoria_cuenta,categoria,nombre,estado from categoria_cuenta_view WHERE estado=1 AND ".$campo." LIKE '".$valor."%' ORDER BY idcategoria_cuenta LIMIT ".$inicio.",".$num_por_pagina."");
          
        }
        return $query->result_array();
      }
      
      public function numero_categorias_buscadas($campo,$valor) {
       $numero_registros = $this->db->query("SELECT idcategoria_cuenta,categoria,nombre FROM categoria_cuenta_view WHERE estado=1 AND ".$campo." LIKE '".$valor."%' ORDER BY idcategoria_cuenta");
        return $numero_registros->num_rows();
    }
>>>>>>> c624373c90fda3b99490ea3309c22bd4a749c6ba
   
}

/*Fin del archivo my_model.php*/