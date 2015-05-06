<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Grupo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->view('modules/foot');
    }

    public function index() {
        $this->load->library('pagination');
         $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
         
        //configuracion basica de paginacion 
        $config['base_url']= base_url().'index.php/contabilidad/catalogo/grupo/grupo/index'; 
        $config['total_rows']=$this->Grupo_cuentas_model->numero_grupo_cuentas(1);
        $config['per_page']= 10;
        $config['num_links']=5;
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
        $this->pagination->initialize($config);
        
        if($this->uri->segment(6)){
        $inicio = $this->uri->segment(6);
        }else{$inicio = 0;}
        
        $query_grupo = $this->Grupo_cuentas_model->grupo_cuentas_paginacion(1,$inicio,$config['per_page']);
        
        //preparacion de data

        $data['num']=$inicio;
        $data['consulta_grupo']=$query_grupo;
        $data['paginacion']=$this->pagination->create_links();
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->view('contabilidad/catalogo/grupo/grupo_lista_view',$data);
    }


    public function grupo_listar_inactivas() {
         $this->load->library('pagination');
         $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
         
        //configuracion basica de paginacion 
        $config['base_url']= base_url().'index.php/contabilidad/catalogo/grupo/grupo/index'; 
        $config['total_rows']=$this->Grupo_cuentas_model->numero_grupo_cuentas(0);
        $config['per_page']= 10;
        $config['num_links']=5;
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
        $this->pagination->initialize($config);
        
        if($this->uri->segment(6)){
        $inicio = $this->uri->segment(6);
        }else{$inicio = 0;}
        
        $query_grupo = $this->Grupo_cuentas_model->grupo_cuentas_paginacion(0,$inicio,$config['per_page']);
        
        //preparacion de data
        $data['num']=$inicio;
        $data['consulta_grupo']=$query_grupo;
        $data['paginacion']=$this->pagination->create_links();
        //carga de vistas
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->view('contabilidad/catalogo/grupo/grupo_lista_inactivos_view',$data);
        
        
    }
    
    public function grupo_crear() {
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('grupo_cuenta', 'Grupo', 'required|min_length[4]');

        $nivel = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5');
        $data['nivel'] = $nivel;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $data['nivel_anterior'] = $this->Grupo_cuentas_model->lista_grupo();

        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $data['categoria'] = $this->Categorias_cuentas_model->categoria_lista();


        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {

                $this->Grupo_cuentas_model->grupo_agregar();

                $this->index();
            } else {
                $this->load->view('contabilidad/catalogo/grupo/grupo_crea_view', $data);
            }
        } else {

            $this->load->view('contabilidad/catalogo/grupo/grupo_crea_view', $data);
        }
    }

    public function grupo_modificar($idgrupo) {
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('grupo_cuenta', 'Grupo', 'required|min_length[4]');
        $data['idgrupo'] = $idgrupo;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $data['lista_por_id'] = $this->Grupo_cuentas_model->encontrar_por_id($idgrupo);

        $nivel = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5');
        $data['nivel'] = $nivel;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $data['titulo_superior'] = $this->Grupo_cuentas_model->lista_grupo();

        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $data['categoria'] = $this->Categorias_cuentas_model->categoria_lista();


        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {
                $this->Grupo_cuentas_model->grupo_modificar($idgrupo);
                 header('Location:'.base_url().'index.php/contabilidad/catalogo/grupo/grupo');
               $this->index();
            } else {
                $this->load->view('contabilidad/catalogo/grupo/grupo_edita_view', $data);
            }
        } else {
            $this->load->view('contabilidad/catalogo/grupo/grupo_edita_view', $data);
        }
    }

    public function grupo_cambiar_estado($idgrupo, $estado) {
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $this->Grupo_cuentas_model->cambiar_estado($idgrupo, $estado);

        if($estado==0){header('Location:'.base_url().'index.php/contabilidad/catalogo/grupo/grupo');}
        elseif($estado==1) {header('Location:'.base_url().'index.php/contabilidad/catalogo/grupo/grupo/grupo_listar_inactivas');}
        
    }

    public function buscar() {
        $campo = filter_input(INPUT_POST, 'campo');
        $valor = filter_input(INPUT_POST, 'valor');

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');

        if (!empty($campo) && !empty($valor)) {
            $sql = $this->Grupo_cuentas_model->buscar($campo, $valor);
        }if(!empty($campo) && empty($valor)){
            $sql = $this->Grupo_cuentas_model->leer(1);
        }

        $i = 0;

        if (!empty($sql)) {
            echo"<table class='table table-striped table-bordered'>"
            . " <tr>
                                <th>No°</th>
                                <th>Grupo Cuenta</th>
                                <th>Nivel de Cuenta</th>
                                <th>Nivel Anterior de Cuenta</th>
                                <th>Categoria</th>
                                <th>Edicion</th>
                                <th>Inactivacion</th>
                            </tr> ";
            foreach ($sql as $cat) {
                $id = $cat['idgrupo_cuenta'];
                echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cat['grupo_cuenta'] . "</td>
                        <td>" . $cat['nivel'] . "</td>
                        <td>" . $cat['nivel_anterior'] . "</td>
                        <td>" . $cat['categoria'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/categoria/grupo/modificar/' . $id . '" class="fa fa-pencel-o fa-fw">Editar</a>' . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/categoria/grupo/cambiar_estado/' . $id . '/0"  class="fa fa-ban fa-fw">Inactivar</a>' .
                "</tr>";

                $i++;
            }
            echo "</table>";
        } else {
            ?>

            <?php

            echo '<h4>No se encontraron categorias de cuentas</h4>';
        }
    }

}

/* Fin del archivo my_controller.php */