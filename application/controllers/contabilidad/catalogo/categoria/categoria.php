<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Categoria extends CI_Controller{
 
    public function __construct() {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->view('modules/foot');
        
    }
    
    
    public function index($var) {
        
        if($var==1){$data['titulo']='Lista de categorias';
        $this->load->view('modules/menu/menu_contabilidad',$data);
        $this->load->view('contabilidad/catalogo/categoria/categorias_lista_view');
        
        }else if($var==0){
        $data['titulo']='Lista de categorias Inactivas';
        $this->load->view('modules/menu/menu_contabilidad',$data);
        $this->load->view('contabilidad/catalogo/categoria/categorias_lista_inactivos_view');
        
        }
        
    }
    
    public function categorias_listar($inicio=0)
    {  $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $this->load->library('Jquery_pagination');
         
        //configuramos la url de la paginacion
        $config['base_url'] =base_url().'index.php/contabilidad/catalogo/categoria/categoria/categorias_listar';
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['total_rows']=$this->Categorias_cuentas_model->numero_categorias_cuentas(1);
        $config['per_page'] = 10;
        $config['num_links'] = 4;
        $config['uri_segment']= 6;
         //configuracion de estilo de paginacion 
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        //cargamos la librería con nuestra configuracion
        $this->jquery_pagination->initialize($config);
         
        //obtemos los valores
        $query_categoria  = $this->Categorias_cuentas_model->categorias_cuentas_paginacion(1,$inicio,$config['per_page']);
        $paginacion = $this->jquery_pagination->create_links();
        
        $data['titulo']='Lista de categorias';
        $data['num'] =$inicio;
        $data['consulta_categorias'] = $query_categoria;
        $data['paginacion'] = $paginacion;
        
        //cargamos nuestra vista
        $this->load->view('contabilidad/catalogo/categoria/categoria_lista_ajax_view',$data);
    
    }
    
    public function categorias_listar_inactivas($inicio=0) {
        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $this->load->library('Jquery_pagination');
         
        //configuracion basica de paginacion 
        $config['base_url'] =base_url().'index.php/contabilidad/catalogo/categoria/categoria/categorias_listar_inactivas';
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['total_rows']=$this->Categorias_cuentas_model->numero_categorias_cuentas(0);
        $config['per_page'] = 10;
        $config['num_links'] = 4;
         $config['uri_segment']= 6;
         //configuracion de estilo de paginacion 
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        //estableciendo la configuracion de paginacion
        $this->jquery_pagination->initialize($config);
        
        //obtenirndo valores
        $query_categoria_inactivas = $this->Categorias_cuentas_model->categorias_cuentas_paginacion(0,$inicio,$config['per_page']);
        $paginacion = $this->jquery_pagination->create_links();
        //preparacion de data
        $data['titulo']='Lista de categorias inactivas';
        $data['num']=$inicio;
        $data['consulta_categorias_inactivas']=$query_categoria_inactivas;
        $data['paginacion']=$paginacion;
        //carga de vistas
        $this->load->view('contabilidad/catalogo/categoria/categoria_lista_ajax_view',$data);
    }
    
    public function categorias_buscar($inicio=0){
        
        $campo = filter_input(INPUT_POST,'campo');
        $valor = filter_input(INPUT_POST,'valor');
        
        if(!empty($campo) && !empty($valor)){
        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $this->load->library('Jquery_pagination');
         
        //configuramos la url de la paginacion
        $config['base_url'] =base_url().'index.php/contabilidad/catalogo/categoria/categoria/categoria_buscar';//index?
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['total_rows']=$this->Categorias_cuentas_model->numero_categorias_buscadas($campo,$valor);
        $config['per_page'] = 10;
        $config['num_links'] = 4;
        $config['additional_param'] = "{'campo' : '".$campo."','valor' : '".$valor."'}";
        $config['uri_segment']= 6;
         //configuracion de estilo de paginacion 
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        //cargamos la librería con nuestra configuracion
        $this->jquery_pagination->initialize($config);
         
        //obtemos los valores
        $query_categoria  = $this->Categorias_cuentas_model->buscar_categoria($campo,$valor,$inicio,$config['per_page']);
        $paginacion = $this->jquery_pagination->create_links();
        
        $data['titulo']='Lista de categorias';
        $data['num'] =$inicio;
        $data['consulta_categorias'] = $query_categoria;
        $data['paginacion'] = $paginacion;
        
        //cargamos nuestra vista
        $this->load->view('contabilidad/catalogo/categoria/categoria_lista_ajax_view',$data);
            
        }else if(!empty($campo) && empty($valor)){
            $this->index(1);
        }
    
        }
    
    public function categoria_crear() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('categoria_cuenta','Categoria','required|min_length[4]');
        
        $this->load->model('contabilidad/catalogo/categoria/Estructura_base_model');
        $data['idestructura_base'] = $this->Estructura_base_model->lista_dropdown();
        
       
       if($this->input->post()){
           
           if( $this->form_validation->run()== TRUE){
               
                $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
                $this->Categorias_cuentas_model->agregar_categoria();
                 
                 header('Location:'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/index/1');
           }else{
             $this->load->view('modules/menu/menu_contabilidad',$data);
             $this->load->view('contabilidad/catalogo/categoria/categorias_crea_view',$data);
           }
           
       }else{
           $this->load->view('modules/menu/menu_contabilidad',$data);
           $this->load->view('contabilidad/catalogo/categoria/categorias_crea_view',$data);
       }
        
    }
    
    public function categoria_cambiar_estado($idcategorias,$estado) {
        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $this->Categorias_cuentas_model->cambiar_estado_categoria($idcategorias,$estado);
        
        if($estado==0){header('Location:'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/index/1');}
        elseif($estado==1) {header('Location:'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/index/0');}
        
    }
    
    public function categoria_modificar($idcategorias) {
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('categoria_cuenta','Categoria','required|min_length[4]');
         
        $data['idcategorias']=$idcategorias;
        
        $this->load->model('contabilidad/catalogo/categoria/Estructura_base_model');
        $data['idestructurabase'] = $this->Estructura_base_model->lista_dropdown();
        
        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $data['lista_por_id'] = $this->Categorias_cuentas_model->encontrar_por_id($idcategorias);
       
        if($this->input->post()){
            
            if($this->form_validation->run() == TRUE){
                $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
                $this->Categorias_cuentas_model->modificar_categoria($idcategorias);
                header('Location:'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/index/1');
          
            }else{
                $this->load->view('modules/menu/menu_contabilidad');
                $this->load->view('contabilidad/catalogo/categoria/categorias_edita_view',$data);
            }
            
        }else{
            $this->load->view('modules/menu/menu_contabilidad');
            $this->load->view('contabilidad/catalogo/categoria/categorias_edita_view',$data);
        }
    }
    
}

/*Fin del archivo my_controller.php*/