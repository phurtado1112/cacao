<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Categoria extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('loged_in') != true) {
            exit('<script>alert("no tiene acceso");window.location=("http://localhost/cacao");</script>');
        }
        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
    }

    public function index($var) {
        $data['titulo'] = 'Categorias Cuentas';
        $this->load->view('modules/menu/menu_contabilidad', $data);

        if ($var == 1) {
            $this->load->view('contabilidad/catalogo/categoria/categorias_lista_view');
        } else if ($var == 0) {
            $this->load->view('contabilidad/catalogo/categoria/categorias_lista_inactivos_view');
        }
        $this->load->view('modules/foot/contabilidad/categoria_foot');
    }

    public function categorias_listar($inicio = 0) {

        //configuramos la url de la paginacion
        $config['base_url'] = base_url() . 'index.php/contabilidad/catalogo/categoria/categoria/categorias_listar';
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['total_rows'] = $this->Categorias_cuentas_model->numero_categorias_cuentas(1);
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
        $query_categoria = $this->Categorias_cuentas_model->categorias_cuentas_paginacion(1, $inicio, $config['per_page']);
        $paginacion = $this->jquery_pagination->create_links();

        $data['num'] = $inicio;
        $data['consulta_categorias'] = $query_categoria;
        $data['paginacion'] = $paginacion;

        //cargamos nuestra vista
        $this->load->view('contabilidad/catalogo/categoria/categoria_lista_ajax_view', $data);
    }

    public function categorias_listar_inactivas($inicio = 0) {

        //configuracion basica de paginacion 
        $config['base_url'] = base_url() . 'index.php/contabilidad/catalogo/categoria/categoria/categorias_listar_inactivas';
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['total_rows'] = $this->Categorias_cuentas_model->numero_categorias_cuentas(0);
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
        //estableciendo la configuracion de paginacion
        $this->jquery_pagination->initialize($config);

        //obtenirndo valores
        $query_categoria_inactivas = $this->Categorias_cuentas_model->categorias_cuentas_paginacion(0, $inicio, $config['per_page']);
        $paginacion = $this->jquery_pagination->create_links();
        //preparacion de data
        $data['titulo'] = 'Lista de categorias inactivas';
        $data['num'] = $inicio;
        $data['consulta_categorias_inactivas'] = $query_categoria_inactivas;
        $data['paginacion'] = $paginacion;
        //carga de vistas
        $this->load->view('contabilidad/catalogo/categoria/categoria_lista_ajax_view', $data);
    }

    public function categorias_buscar($inicio = 0) {

        if ($this->input->is_ajax_request()) {

            $campo = filter_input(INPUT_POST, 'campo');
            $valor = filter_input(INPUT_POST, 'valor');

            //configuramos la url de la paginacion
            $config['base_url'] = base_url() . 'index.php/contabilidad/catalogo/categoria/categoria/categorias_buscar'; //index?
            $config['div'] = '#resultado';
            $config['show_count'] = true;
            $config['cur_page'] = base_url() . 'index.php/contabilidad/catalogo/categoria/categoria/categoria_buscar';
            $config['total_rows'] = $this->Categorias_cuentas_model->numero_categorias_buscadas($campo, $valor);
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
                $categoria_query = $this->Categorias_cuentas_model->buscar_categoria($campo, $valor, $inicio, $config['per_page']);
            } else if (!empty($campo) && empty($valor)) {
                $categoria_query = $this->Categorias_cuentas_model->categorias_cuentas_paginacion(1, $inicio, $config['per_page']);
            }

            $data['titulo'] = 'Lista de categorias';
            $data['num'] = $inicio;
            $data['consulta_categorias'] = $categoria_query;
            $data['paginacion'] = $paginacion;

            $this->uri->segment(6);
            //cargamos nuestra vista
            $this->load->view('contabilidad/catalogo/categoria/categoria_lista_ajax_view', $data);
        }
    }

    public function string_not_numeric($var) {
        $var_array = str_split($var);
        $contador = 0;

        foreach ($var_array as $v_c) {
            if (is_numeric($v_c)) {
                $contador++;
            }
        }

        if ($contador == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function repeticion_edicion($var, $idvar) {
        $consulta = $this->Categorias_cuentas_model->encontrar_por_campo($var, $idvar);

        if ((count($consulta) == 1)) {
//            print_r($consulta);
//            echo count($consulta);
            echo TRUE;
        } else {
            return FALSE;
        }
    }

    public function categoria_crear() {
        $data['titulo'] = 'Categorias Cuentas';
        $this->load->view('modules/menu/menu_contabilidad', $data);

        $this->form_validation->set_rules('categoria_cuenta', 'Categoria', 'callback_string_not_numeric|required|min_length[3]|max_length[50]|trim|is_unique[categoria_cuenta.categoria_cuenta]|xss_clean');
        $this->form_validation->set_rules('idestructura_base', 'Tipo', 'required|numeric');

        $this->form_validation->set_message('string_not_numeric', 'El campo Categoria de la cuenta no puede contener valores numericos');
        $this->form_validation->set_message('is_unique', 'El nombre "' . $this->input->post("categoria_cuenta") . '" ya esta en uso');

        $this->load->model('contabilidad/catalogo/categoria/Estructura_base_model');
        $estructura_base_lista = $this->Estructura_base_model->estructura_base();
        
        foreach ($estructura_base_lista as $eb_lista) {
          $dropdownlist[$eb_lista['idestructura_base']] = $eb_lista['descripcion_estructura_base'];
        }
        $eb_lista = $dropdownlist;
        
        $data['idestructura_base'] = $eb_lista;

        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {

                $this->Categorias_cuentas_model->agregar_categoria();

                header('Location:' . base_url() . 'index.php/contabilidad/catalogo/categoria/categoria/index/1');
            } else {
                $this->load->view('modules/menu/menu_contabilidad', $data);
                $this->load->view('contabilidad/catalogo/categoria/categorias_crea_view', $data);
            }
        } else {
            $this->load->view('modules/menu/menu_contabilidad', $data);
            $this->load->view('contabilidad/catalogo/categoria/categorias_crea_view', $data);
        }
        $this->load->view('modules/foot/contabilidad/categoria_foot');
    }

    public function categoria_cambiar_estado($idcategorias, $estado) {
        $this->Categorias_cuentas_model->cambiar_estado_categoria($idcategorias, $estado);

        if ($estado == 0) {
            header('Location:' . base_url() . 'index.php/contabilidad/catalogo/categoria/categoria/index/1');
        } elseif ($estado == 1) {
            header('Location:' . base_url() . 'index.php/contabilidad/catalogo/categoria/categoria/index/0');
        }
    }

    public function categoria_modificar($idcategorias) {
        $data['titulo'] = 'Categorias Cuentas';
        $this->load->view('modules/menu/menu_contabilidad', $data);

        $data['lista_por_id'] = $this->Categorias_cuentas_model->encontrar_por_id($idcategorias);

        if ($this->input->post('categoria_cuenta') != $data['lista_por_id'][0]['categoria']) {
            $is_unique = 'is_unique[categoria_cuenta.categoria_cuenta]|';
        } else {
            $is_unique = '';
        }

        $this->form_validation->set_rules('categoria_cuenta', 'Categoria', $is_unique . 'callback_string_not_numeric|required|min_length[3]|trim|xss_clean');
        $this->form_validation->set_rules('idestructura_base', 'Tipo', 'required|numeric');

        $this->form_validation->set_message('not_numeric', 'El campo Categoria de la cuenta de cuenta no puede ser numerico');
        $this->form_validation->set_message('is_unique', 'El nombre "' . $this->input->post("categoria_cuenta") . '" ya esta en uso');

        $data['idcategorias'] = $idcategorias;

        $this->load->model('contabilidad/catalogo/categoria/Estructura_base_model');
        $estructura_base_lista = $this->Estructura_base_model->estructura_base();
        
        foreach ($estructura_base_lista as $eb_lista) {
          $dropdownlist[$eb_lista['idestructura_base']] = $eb_lista['descripcion_estructura_base'];
        }
        $eb_lista = $dropdownlist;
        
        $data['idestructura_base'] = $eb_lista;


        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {
                $this->Categorias_cuentas_model->modificar_categoria($idcategorias);
                header('Location:' . base_url() . 'index.php/contabilidad/catalogo/categoria/categoria/index/1');
            } else {
                $this->load->view('modules/menu/menu_contabilidad');
                $this->load->view('contabilidad/catalogo/categoria/categorias_edita_view', $data);
            }
        } else {
            $this->load->view('modules/menu/menu_contabilidad');
            $this->load->view('contabilidad/catalogo/categoria/categorias_edita_view', $data);
        }
        $this->load->view('modules/foot/contabilidad/categoria_foot');
    }

    public function categoria_eliminar($idcategorias) {
        $this->Categorias_cuentas_model->eliminar_categoria($idcategorias);

        header('Location:' . base_url() . 'index.php/contabilidad/catalogo/categoria/categoria/index/0');
    }

    public function categoria_relacion_grupo() {
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');

        $categoria = filter_input(INPUT_POST, 'idcategoria_cuenta');

        $grupo_nivel = $this->Grupo_cuentas_model->grupo_dependencia_categoria("idcategoria_cuenta", $categoria);

        echo(count($grupo_nivel));
    }

}

/*Fin del archivo my_controller.php*/