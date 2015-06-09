<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Grupo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
    }

    public function index($var) {
        $data['titulo'] = 'Grupos Cuentas';
        $this->load->view('modules/menu/menu_contabilidad', $data);
        
        if ($var == 1) {
            $this->load->view('contabilidad/catalogo/grupo/grupo_lista_view');
        } else if ($var == 0) {
            $this->load->view('contabilidad/catalogo/grupo/grupo_lista_inactivos_view');
        }
        $this->load->view('modules/foot/contabilidad/grupo_foot');
    }

    public function grupos_listar($inicio = 0) {

        //configuramos la url de la paginacion
        $config['base_url'] = base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/grupos_listar';
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['total_rows'] = $this->Grupo_cuentas_model->numero_grupo_cuentas(1);
        $config['per_page'] = 10;
        $config['num_links'] = 4;
        $config['uri_segment'] = 6;
        //configuracion de estilo de paginacion 
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        //cargamos la librería con nuestra configuracion
        $this->jquery_pagination->initialize($config);

        //obtemos los valores
        $query_grupo = $this->Grupo_cuentas_model->grupo_cuentas_paginacion(1, $inicio, $config['per_page']);
        $paginacion = $this->jquery_pagination->create_links();

        $data['num'] = $inicio;
        $data['consulta_grupo'] = $query_grupo;
        $data['paginacion'] = $paginacion;
        //cargamos nuestra vista
        $this->load->view('contabilidad/catalogo/grupo/grupo_lista_ajax_view', $data);
    }

    public function grupos_listar_inactivas($inicio = 0) {

        //configuramos la url de la paginacion
        $config['base_url'] = base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/grupos_listar_inactivas';
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['total_rows'] = $this->Grupo_cuentas_model->numero_grupo_cuentas(0);
        $config['per_page'] = 10;
        $config['num_links'] = 4;
        $config['uri_segment'] = 6;
        //configuracion de estilo de paginacion 
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        //cargamos la librería con nuestra configuracion
        $this->jquery_pagination->initialize($config);

        //obtemos los valores
        $query_grupo = $this->Grupo_cuentas_model->grupo_cuentas_paginacion(0, $inicio, $config['per_page']);
        $paginacion = $this->jquery_pagination->create_links();

        $data['num'] = $inicio;
        $data['consulta_grupo_inactivos'] = $query_grupo;
        $data['paginacion'] = $paginacion;
        //cargamos nuestra vista
        $this->load->view('contabilidad/catalogo/grupo/grupo_lista_ajax_view', $data);
    }

    public function grupos_buscar($inicio = 0) {

        if ($this->input->is_ajax_request()) {

            $campo = filter_input(INPUT_POST, 'campo');
            $valor = filter_input(INPUT_POST, 'valor');

            //configuramos la url de la paginacion
            $config['base_url'] = base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/grupos_buscar';
            $config['div'] = '#resultado';
            $config['show_count'] = true;
            $config['total_rows'] = $this->Grupo_cuentas_model->numero_grupo_cuentas(1);
            $config['per_page'] = 10;
            $config['num_links'] = 4;
            $config['additional_param'] = "{'campo': '" . $campo . "','valor': '" . $valor . "'}";
            $config['uri_segment'] = 6;
            //configuracion de estilo de paginacion 
            $config['cur_tag_open'] = '<li class="active"><a href="#">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li>';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li>';
            $config['prev_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            //cargamos la librería con nuestra configuracion
            $this->jquery_pagination->initialize($config);

            //obtemos los valores
            $paginacion = $this->jquery_pagination->create_links();

            if (!empty($campo) && !empty($valor)) {
                $categoria_query = $this->Grupo_cuentas_model->grupo_buscar($campo, $valor, $inicio, $config['per_page']);
            } else if (!empty($campo) && empty($valor)) {
                $categoria_query = $this->Grupo_cuentas_model->grupo_cuentas_paginacion(1, $inicio, $config['per_page']);
            }

            $data['titulo'] = 'Lista de categorias';
            $data['num'] = $inicio;
            $data['consulta_grupo'] = $categoria_query;
            $data['paginacion'] = $paginacion;

            //cargamos nuestra vista
            $this->load->view('contabilidad/catalogo/grupo/grupo_lista_ajax_view', $data);
        }
    }

    public function grupo_crear() {
        $data['titulo'] = 'Grupos Cuentas';
        $this->load->view('modules/menu/menu_contabilidad', $data);
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('grupo_cuenta', 'Grupo', 'required|min_length[4]|trim');
        $this->form_validation->set_rules('nivel', 'Nivel', 'required|numeric');
        $this->form_validation->set_rules('nivel_anterior', 'Nivel anterior', 'required|numeric');
        

        $nivel = array('0' => ' ','1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5');
        $data['nivel'] = $nivel;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $data['nivel_anterior'] = $this->Grupo_cuentas_model->lista_grupo();

        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $data['categoria'] = $this->Categorias_cuentas_model->categoria_lista();


        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {

                $this->Grupo_cuentas_model->grupo_agregar();

                header('Location:' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/index/1');
            } else {
                $this->load->view('contabilidad/catalogo/grupo/grupo_crea_view', $data);
            }
        } else {

            $this->load->view('contabilidad/catalogo/grupo/grupo_crea_view', $data);
        }
        $this->load->view('modules/foot/contabilidad/grupo_foot');
    }

    public function grupo_modificar($idgrupo) {
        $data['titulo'] = 'Grupos Cuentas';
        $this->load->view('modules/menu/menu_contabilidad', $data);
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('grupo_cuenta', 'Grupo', 'required|min_length[4]|trim');
        $data['idgrupo'] = $idgrupo;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $data['lista_por_id'] = $this->Grupo_cuentas_model->encontrar_por_id($idgrupo);

        $nivel = array('0'=>' ','1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5');
        $data['nivel'] = $nivel;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $data['titulo_superior'] = $this->Grupo_cuentas_model->lista_grupo();

        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $data['categoria'] = $this->Categorias_cuentas_model->categoria_lista();


        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {
                $this->Grupo_cuentas_model->grupo_modificar($idgrupo);

                header('Location:' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/index/1');
            } else {
                $this->load->view('contabilidad/catalogo/grupo/grupo_edita_view', $data);
            }
        } else {
            $this->load->view('contabilidad/catalogo/grupo/grupo_edita_view', $data);
        }
        $this->load->view('modules/foot/contabilidad/grupo_foot');
    }

    public function grupo_cambiar_estado($idgrupo, $estado) {
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $this->Grupo_cuentas_model->grupo_cambiar_estado($idgrupo, $estado);

        if ($estado == 0) {
            header('Location:' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/index/1');
        } elseif ($estado == 1) {
            header('Location:' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/index/0');
        }
    }

    public function grupo_formulario_select() {
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');

        $nivel = filter_input(INPUT_POST, 'nivel');
        $categoria = filter_input(INPUT_POST, 'idcategoria');
        
        $grupo_nivel = $this->Grupo_cuentas_model->grupo_por_campo_condicion("nivel", $nivel,"idcategoria_cuenta",$categoria);
       
        if($grupo_nivel != 0){
        foreach($grupo_nivel as $grupo_n){
            $cero_option = "<option value=".$grupo_n['nivel']." >".$grupo_n['grupo_cuenta']."</option>";
            $str_option = $str_option.$cero_option;
            
        }}else{
            $str_option="<option value='' ></option>";
        }
            echo $str_option;
    }
    
}

/* Fin del archivo my_controller.php */