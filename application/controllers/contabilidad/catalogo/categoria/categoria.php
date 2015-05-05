<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Categoria extends CI_Controller{
 
    public function __construct() {
        parent::__construct();   
        $this->load->helper('url');
<<<<<<< HEAD

    }
    
    
    public function index() {
         $this->leer(1);          
    }
    
    public function buscar(){
        $campo = filter_input(INPUT_POST,'campo');
        $valor = filter_input(INPUT_POST,'valor');
        
        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        
        if(!empty($campo) && !empty($valor)){
            $sql = $this->Categorias_cuentas_model->buscar($campo,$valor);
        }
        
        $i = 0;
        
         if(!empty($sql)){
                            echo"<table class='table table-striped table-bordered'>"
                            . " <tr>
                                <th>No°</th>
                                <th>Categoría</th>
                                <th>Clasificación Principal</th>
                                <th>Modificar</th>
                                <th>Desactivar</th>
                            </tr> ";
                            foreach ($sql as $cat) {
                                $id = $cat['idcategoria_cuenta'];
                                echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cat['categoria'] . "</td>
                        <td>" . $cat['nombre'] . "</td>
                        <td>" . '<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/c_categoria/modificar/'.$id.'">Editar</a>' . "</td>
                        <td>" . '<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/c_categoria/cambiar_estado/'.$id.'/0">Inactivar</a>'.
                        "</tr>";
                         
                                $i++;
                            }
                            echo "</table>";
                            
                            }else{?>
                               
                     <?php echo '<h4>No se encontraron categorias de cuentas</h4>';
                            }
        
    }


    public function leer($estado){
         
        $this->load->view('modules/menu/menu_contabilidad');
         $this->load->helper('form');
         
        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $this->load->library('table');
        $sql =$this->Categorias_cuentas_model->leer($estado);
         
        $i=0; if($estado==1){
            
                    $data['link']='<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/crear" class="btn btn-success">Crear Nueva Categoría de Cuenta</a> '.
                            '<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/leer/0" class="btn btn-success">Listar Categorias Inactivas</a>'.
                            '<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/leer/1" class="btn btn-success">Cancelar</a>'.
                            '<input type="text" id="valor">'
                            .'<select id="campo">'
                                .'<option value="categoria">Categoria</option>'
                                .'<option value="nombre">Clasificacion Principal</option>'
                            . '</select>'
                            . '<button id="buscar">Buscar</button>';
                    $encabezados = array('No°','Categoria','Clasificación Principal','Edicion','Inactivacion');
                    
                   while(count($sql)!=$i){ 
                       $id = $sql[$i]['idcategoria_cuenta'];
                        unset($sql[$i]['idcategoria_cuenta']);
                       array_unshift($sql[$i],$i);
                       array_push($sql[$i],'<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/modificar/'.$id.'">Editar</a>');
                       array_push($sql[$i],'<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/cambiar_estado/'.$id.'/0">Inactivar</a>');

                       $i++;
                   }
       
        }else 
            
            if($estado==0){
                    $data['link']='<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/leer/1" class="btn btn-success">Listar Cuentas Activas</a>';
                    $encabezados = array('No°','Categoria','Clasificación Principal','Activacion');

                   while(count($sql)!=$i){ 
                       $id = $sql[$i]['idcategoria_cuenta'];
                       unset($sql[$i]['idcategoria_cuenta']);
                       array_unshift($sql[$i],$i);
                       array_push($sql[$i],'<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/cambiar_estado/'.$id.'/1">Activar</a>');

                       $i++;
                    }
            }
       
       $estilo = array( 'table_open' =>'<table class="table table-striped table-bordered">');
       $this->table->set_template($estilo);
       $this->table->set_heading($encabezados);
       $data['categoria_cuenta'] = $sql;
        
      $this->load->view('contabilidad/catalogo/categoria/lista_categoria_view',$data);
        
    }
    
    public function crear() {
        
=======
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
>>>>>>> c624373c90fda3b99490ea3309c22bd4a749c6ba
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('categoria_cuenta','Categoria','required|min_length[4]');
        
        $this->load->model('contabilidad/catalogo/categoria/Estructura_base_model');
        $data['idestructura_base'] = $this->Estructura_base_model->lista_dropdown();
        
       
       if($this->input->post()){
           
           if( $this->form_validation->run()== TRUE){
               
                $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
<<<<<<< HEAD
                $this->Categorias_cuentas_model->agregar();
                 
                 $this->leer(1);
           }else{
               $this->load->view('modules/menu/menu_contabilidad');
             $this->load->view('contabilidad/catalogo/categoria/crea_categoria_view',$data);
           }
           
       }else{
        $this->load->view('modules/menu/menu_contabilidad');
       $this->load->view('contabilidad/catalogo/categoria/crea_categoria_view',$data);
       }
        
    }
 
    public function modificar($idcategorias) {
=======
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
>>>>>>> c624373c90fda3b99490ea3309c22bd4a749c6ba
        
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
<<<<<<< HEAD
                $this->Categorias_cuentas_model->modificar($idcategorias);
                $this->leer(1);
          
            }else{
                $this->load->view('modules/menu/menu_contabilidad');
                $this->load->view('contabilidad/catalogo/categoria/edita_categoria_view',$data);
=======
                $this->Categorias_cuentas_model->modificar_categoria($idcategorias);
                header('Location:'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/index/1');
          
            }else{
                $this->load->view('modules/menu/menu_contabilidad');
                $this->load->view('contabilidad/catalogo/categoria/categorias_edita_view',$data);
>>>>>>> c624373c90fda3b99490ea3309c22bd4a749c6ba
            }
            
        }else{
            $this->load->view('modules/menu/menu_contabilidad');
<<<<<<< HEAD
            $this->load->view('contabilidad/catalogo/categoria/edita_categoria_view',$data);
        }
    }
    
    public function cambiar_estado($idcategorias,$estado) {
        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $this->Categorias_cuentas_model->cambiar_estado($idcategorias,$estado);
        
        if($estado==1){$this->leer(0);}elseif($estado==0) {$this->leer(1);}
        
        
          
          
    }
    
=======
            $this->load->view('contabilidad/catalogo/categoria/categorias_edita_view',$data);
        }
    }
    
>>>>>>> c624373c90fda3b99490ea3309c22bd4a749c6ba
}

/*Fin del archivo my_controller.php*/