<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Categoria extends CI_Controller{
 
    public function __construct() {
        parent::__construct();   
        $this->load->helper('url');
        $this->load->view('modules/foot');

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
        } if(!empty($campo) && empty($valor)){
            $sql = $this->Categorias_cuentas_model->leer(1);
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
                        <td>" . '<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/modificar/'.$id.'">Editar</a>' . "</td>
                        <td>" . '<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/cambiar_estado/'.$id.'/0">Inactivar</a>'.
                        "</tr>";
                         
                                $i++;
                            }
                            echo "</table>";
                            
                            }else {
                                
                                ?>
                               
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
            
                    $data['link']='<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/crear" class="btn btn-success fa fa-file-o fa-lg"> Nueva Categoría de Cuenta</a></br></br> '.
                            '<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/leer/0" class="btn btn-success fa fa-list-alt fa-lg"> Categorias Inactivas</a>'.
                            '<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/leer/1" class="btn btn-success fa fa-refresh fa-lg col-lg-offset-7">Recargar</a></br></br>'.
                            '<input type="text" id="valor" class="col-lg-offset-6">'
                            .' <select id="campo" class="dropdown">'
                                .'<option value="categoria">Categoria</option>'
                                .'<option value="nombre">Clasificacion Principal</option>'
                            . '</select>'
                            . ' <button id="buscar" class="btn btn-success">Buscar</button>';
                    $encabezados = array('No°','Categoria','Clasificación Principal','Edicion','Inactivacion');
                    
                   while(count($sql)!=$i){ 
                       $id = $sql[$i]['idcategoria_cuenta'];
                        unset($sql[$i]['idcategoria_cuenta']);
                       array_unshift($sql[$i],$i);
                       array_push($sql[$i],'<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/modificar/'.$id.'" class="fa fa-pencil fa-fw">Editar</a>');
                       array_push($sql[$i],'<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/cambiar_estado/'.$id.'/0" class="fa fa-ban fa-fw">Inactivar</a>');

                       $i++;
                   }
       
        }else 
            
            if($estado==0){
                    $data['link']='<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/leer/1" class="btn btn-success fa fa-list-alt fa-lg"> Cuentas Activas</a>';
                    $encabezados = array('No°','Categoria','Clasificación Principal','Activacion');

                   while(count($sql)!=$i){ 
                       $id = $sql[$i]['idcategoria_cuenta'];
                       unset($sql[$i]['idcategoria_cuenta']);
                       array_unshift($sql[$i],$i);
                       array_push($sql[$i],'<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/categoria/cambiar_estado/'.$id.'/1" class="fa fa-retweet fa-fw">Activar</a>');

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
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('categoria_cuenta','Categoria','required|min_length[4]');
        
        $this->load->model('contabilidad/catalogo/categoria/Estructura_base_model');
        $data['idestructura_base'] = $this->Estructura_base_model->lista_dropdown();
        
       
       if($this->input->post()){
           
           if( $this->form_validation->run()== TRUE){
               
                $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
                $this->Categorias_cuentas_model->agregar();
                 
                 $this->leer(1);
           }else{
               
             $this->load->view('contabilidad/catalogo/categoria/crea_categoria_view',$data);
           }
           
       }else{
        
       $this->load->view('contabilidad/catalogo/categoria/crea_categoria_view',$data);
       }
        
    }
 
    public function modificar($idcategorias) {
        
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
                $this->Categorias_cuentas_model->modificar($idcategorias);
                $this->leer(1);
          
            }else{
                $this->load->view('modules/menu/menu_contabilidad');
                $this->load->view('contabilidad/catalogo/categoria/edita_categoria_view',$data);
            }
            
        }else{
            $this->load->view('modules/menu/menu_contabilidad');
            $this->load->view('contabilidad/catalogo/categoria/edita_categoria_view',$data);
        }
    }
    
    public function cambiar_estado($idcategorias,$estado) {
        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $this->Categorias_cuentas_model->cambiar_estado($idcategorias,$estado);
        
        if($estado==1){$this->leer(0);}elseif($estado==0) {$this->leer(1);}
        
        
          
          
    }
    
}

/*Fin del archivo my_controller.php*/