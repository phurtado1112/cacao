<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class C_Grupo extends CI_Controller{
 
    public function __construct() {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->view('modules/menu/menu_contabilidad');

    }
    public function index() {
         $this->load->view('contabilidad/catalogo/grupo/v_lista');
    }
    
     public function leer($estado){
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuenta');
        $this->load->library('table');
        $sql =$this->Grupo_cuenta->leer($estado);
         
        $i=0; if($estado==1){
            
                    $data['link']='<a href="'.base_url().'index.php/contabilidad/catalogo/grupo/c_grupo/crear" class="btn btn-success">Crear Nuevo Grupo de Cuentas</a> '.
                            '<a href="'.base_url().'index.php/contabilidad/catalogo/grupo/c_grupo/leer/0" class="btn btn-success">Listar Grupos de cuentas Inactivas</a>';
                    $encabezados = array('ID','Grupo','Nivel','Nivel Anterior','Categoria','Edicion','Inactivacion');
                    
                   while(count($sql)!=$i){ 
                       $id = $sql[$i]['idgrupo_cuenta'];
                       array_push($sql[$i],'<a href="'.base_url().'index.php/contabilidad/catalogo/grupo/c_grupo/modificar/'.$id.'">Editar</a>');
                       array_push($sql[$i],'<a href="'.base_url().'index.php/contabilidad/catalogo/grupo/c_grupo/cambiar_estado/'.$id.'/0">Inactivar</a>');

                       $i++;
                   }
       
        }else 
            
            if($estado==0){
                    $data['link']='<a href="'.base_url().'index.php/contabilidad/catalogo/grupo/c_grupo/leer/1" class="btn btn-success">Listar Grupos Activos</a>';
                    $encabezados = array('ID','Grupo','Nivel','Nivel Anterior','Categoria','Activacion');

                   while(count($sql)!=$i){ 
                       $id = $sql[$i]['idgrupo_cuenta'];
                       array_push($sql[$i],'<a href="'.base_url().'index.php/contabilidad/catalogo/grupo/c_grupo/cambiar_estado/'.$id.'/1">Activar</a>');

                       $i++;
                    }
            }
       
       $estilo = array( 'table_open' =>'<table class="table table-striped table-bordered">');
       $this->table->set_template($estilo);
       $this->table->set_heading($encabezados);
       $data['gruposcuentas'] = $sql;
        
      $this->load->view('contabilidad/catalogo/grupo/v_lista_grupo',$data);
        
    }
    
    
    
    public function crear() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('grupo_cuenta','Grupo','required|min_length[4]');
        
        $nivel = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
        $data['nivel'] = $nivel; 
        
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuenta');
        $data['nivel_anterior'] = $this->Grupo_cuenta->lista_grupo();
        
        $this->load->model('contabilidad/catalogo/categoria/Categoria_cuenta');
        $data['categoria'] = $this->Categoria_cuenta->lista_categoria();
        
       
       if($this->input->post()){
           
           if( $this->form_validation->run()== TRUE){
               
                $this->Grupo_cuenta->agregar();
                 
                 $this->leer(1);
           }else{
             $this->load->view('contabilidad/catalogo/grupo/v_crea_grupo',$data);
           }
           
       }else{
        
       $this->load->view('contabilidad/catalogo/grupo/v_crea_grupo',$data);
       }
        
    }
 
    public function modificar($idgrupo) {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('grupo_cuenta','Grupo','required|min_length[4]');
        $data['idgrupo']=$idgrupo;
        
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuenta');
        $data['lista_por_id'] = $this->Grupo_cuenta->encontrar_por_id($idgrupo);
        
        $nivel = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
        $data['nivel'] = $nivel; 
        
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuenta');
        $data['titulo_superior'] = $this->Grupo_cuenta->lista_grupo();
        
        $this->load->model('contabilidad/catalogo/categoria/Categoria_cuenta');
        $data['categoria'] = $this->Categoria_cuenta->lista_categoria();
        
       
        if($this->input->post()){
            
            if($this->form_validation->run() == TRUE){
                $this->Grupo_cuenta->modificar($idgrupo);
                $this->leer(1);
          
            }else{
                $this->load->view('contabilidad/catalogo/grupo/v_edita_grupo',$data);
            }
            
        }else{
            $this->load->view('contabilidad/catalogo/grupo/v_edita_grupo',$data);
        }
    }
    
    public function cambiar_estado($idgrupo,$estado) {
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuenta');
        $this->Grupo_cuenta->cambiar_estado($idgrupo,$estado);
        
        if($estado==1){$this->leer(0);}elseif($estado==0) {$this->leer(1);}
        
    }
    
}

/*Fin del archivo my_controller.php*/