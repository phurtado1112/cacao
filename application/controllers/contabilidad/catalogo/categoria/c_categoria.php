<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class C_Categoria extends CI_Controller{
 
    public function __construct() {
        parent::__construct();   
        $this->load->helper('url');

    }
    
    public function index() {
         $this->load->view('contabilidad/catalogo/index');
    }
    
    public function buscar(){
        $campo = filter_input(INPUT_POST,'campo');
        $valor = filter_input(INPUT_POST,'valor');
        
        $this->load->model('contabilidad/catalogo/categoria/Categoria_cuenta');
        
        if(!empty($campo) && !empty($valor)){
            $sql = $this->Categoria_cuenta->buscar($campo,$valor);
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
         
        $this->load->model('contabilidad/catalogo/categoria/Categoria_cuenta');
        $this->load->library('table');
        $sql =$this->Categoria_cuenta->leer($estado);
         
        $i=0; if($estado==1){
            
                    $data['link']='<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/c_categoria/crear" class="btn btn-success">Crear Nueva Categoría de Cuenta</a> '.
                            '<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/c_categoria/leer/0" class="btn btn-success">Listar Categorias Inactivas</a>'.
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
                       array_push($sql[$i],'<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/c_categoria/modificar/'.$id.'">Editar</a>');
                       array_push($sql[$i],'<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/c_categoria/cambiar_estado/'.$id.'/0">Inactivar</a>');

                       $i++;
                   }
       
        }else 
            
            if($estado==0){
                    $data['link']='<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/c_categoria/leer/1" class="btn btn-success">Listar Cuentas Activas</a>';
                    $encabezados = array('No°','Categoria','Clasificación Principal','Activacion');

                   while(count($sql)!=$i){ 
                       $id = $sql[$i]['idcategoria_cuenta'];
                       unset($sql[$i]['idcategoria_cuenta']);
                       array_unshift($sql[$i],$i);
                       array_push($sql[$i],'<a href="'.base_url().'index.php/contabilidad/catalogo/categoria/c_categoria/cambiar_estado/'.$id.'/1">Activar</a>');

                       $i++;
                    }
            }
       
       $estilo = array( 'table_open' =>'<table class="table table-striped table-bordered">');
       $this->table->set_template($estilo);
       $this->table->set_heading($encabezados);
       $data['categoria_cuenta'] = $sql;
        
      $this->load->view('contabilidad/catalogo/categoria/v_lista_categoria',$data);
        
    }
    
    public function crear() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('categoria_cuenta','Categoria','required|min_length[4]');
        
        $this->load->model('contabilidad/catalogo/categoria/M_Estructura_Base');
        $data['idestructura_base'] = $this->M_Estructura_Base->lista_dropdown();
        
       
       if($this->input->post()){
           
           if( $this->form_validation->run()== TRUE){
               
                $this->load->model('contabilidad/catalogo/categoria/Categoria_cuenta');
                $this->Categoria_cuenta->agregar();
                 
                 $this->leer(1);
           }else{
             $this->load->view('contabilidad/catalogo/categoria/v_crea_categoria',$data);
           }
           
       }else{
        
       $this->load->view('contabilidad/catalogo/categoria/v_crea_categoria',$data);
       }
        
    }
 
    public function modificar($idcategorias) {
        
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('categoria_cuenta','Categoria','required|min_length[4]');
         
        $data['idcategorias']=$idcategorias;
        
        $this->load->model('contabilidad/catalogo/categoria/M_Estructura_Base');
        $data['idestructurabase'] = $this->M_Estructura_Base->lista_dropdown();
        
        $this->load->model('contabilidad/catalogo/categoria/Categoria_cuenta');
        $data['lista_por_id'] = $this->Categoria_cuenta->encontrar_por_id($idcategorias);
       
        if($this->input->post()){
            
            if($this->form_validation->run() == TRUE){
                $this->load->model('contabilidad/catalogo/categoria/Categoria_cuenta');
                $this->Categoria_cuenta->modificar($idcategorias);
                $this->leer(1);
          
            }else{
                $this->load->view('contabilidad/catalogo/categoria/v_edita_categoria',$data);
            }
            
        }else{
            $this->load->view('contabilidad/catalogo/categoria/v_edita_categoria',$data);
        }
    }
    
    public function cambiar_estado($idcategorias,$estado) {
        $this->load->model('contabilidad/catalogo/categoria/Categoria_cuenta');
        $this->Categoria_cuenta->cambiar_estado($idcategorias,$estado);
        
        if($estado==1){$this->leer(0);}elseif($estado==0) {$this->leer(1);}
        
        
          
          
    }
    
}

/*Fin del archivo my_controller.php*/