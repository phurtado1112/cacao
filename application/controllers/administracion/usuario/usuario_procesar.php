<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Usuario_Procesar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('loged_in') != true) {
            exit('<script>alert("no tiene acceso");window.location=("http://localhost/cacao");</script>');
        }
        $data['titulo'] = 'Usuario';
        $this->load->view('modules/menu/menu_administracion', $data);
        $this->load->model('administracion/usuario/Usuario_Model');
    }

    public function index($var) {
        if ($var == 1) {
            $this->load->view('administracion/usuario/usuario_lista_view');
        } else if ($var == 0) {
            $this->load->view('administracion/usuario/usuario_lista_inactivo_view');
        }
        $this->load->view('modules/foot/administracion/foot_usuario');
    }

    public function usuario_listar($inicio = 0) {

        //configuramos la url de la paginacion
        $config['base_url'] = base_url() . 'index.php/administracion/usuario/usuario/usuario_listar';
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['total_rows'] = $this->Usuario_Model->numero_usuarios(1);
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
        $query_usuario = $this->Usuario_Model->usuario_paginacion(1, $inicio, $config['per_page']);
        $paginacion = $this->jquery_pagination->create_links();

        $data['num'] = $inicio;
        $data['consulta_usuario'] = $query_usuario;
        $data['paginacion'] = $paginacion;

        //cargamos nuestra vista
        $this->load->view('administracion/usuario/usuario_lista_ajax_view', $data);
    }

    public function usuario_listar_inactivos($inicio = 0) {

        //configuracion basica de paginacion 
        $config['base_url'] = base_url() . 'index.php/administracion/usuario/usuario/usuario_listar_inactivos';
        ;
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['total_rows'] = $this->Usuario_Model->numero_usuarios(0);
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
        $query_usuario_inactivos = $this->Usuario_Model->usuario_paginacion(0, $inicio, $config['per_page']);
        $paginacion = $this->jquery_pagination->create_links();
        //preparacion de data
        $data['titulo'] = 'Lista de Usuarios Inactivos';
        $data['num'] = $inicio;
        $data['consulta_usuario_inactivos'] = $query_usuario_inactivos;
        $data['paginacion'] = $paginacion;
        //carga de vistas
        $this->load->view('administracion/usuario/usuario_lista_ajax_view', $data);
    }

    // crear nuevo usuario   
    public function usuario_crear() {
        $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
        $this->form_validation->set_rules('apellido', 'Apellido', 'required|trim');
        $this->form_validation->set_rules('usuario', 'Usuario', 'required|trim');
        $this->form_validation->set_rules('contrasenia', 'Contraseñia', 'required|trim');

        if ($this->form_validation->run() == TRUE) {
            $this->Usuario_Model->usuario_crear();
            header('Location:' . base_url() . 'index.php/administracion/usuario/usuario_procesar/index/1');
        } else {
            $this->load->view('modules/menu/menu_administracion');
            $this->load->view('administracion/usuario/usuario_crea_view');
        }
        $this->load->view('modules/foot/administracion/foot_usuario');
    }

    //modificar usaurio
    public function usuario_editar($idusuario) {
        
        $data['titulo'] = 'Usuario Editar';
        $this->load->view('modules/menu/menu_administracion', $data);

        $data['lista_por_id'] = $this->Usuario_Model->encontrar_por_id($idusuario);


        $this->form_validation->set_rules('nombre', 'Nombre', 'trim');
        $this->form_validation->set_rules('apellido', 'Apellido', 'trim');
        $this->form_validation->set_rules('usuario', 'Usuario', 'trim');

        $data['idusuario'] = $idusuario;


        if ($this->form_validation->run() == TRUE) {
            $this->Usuario_Model->usuario_editar($idusuario);
            header('Location:' . base_url() . 'index.php/administracion/usuario/usuario_procesar/index/1');
        } else {
            $this->load->view('modules/menu/menu_administracion');
            $this->load->view('administracion/usuario/usuario_edita_view', $data);
        }

        $this->load->view('modules/foot/administracion/foot_usuario_edita');
    }

    //procesar contraseña ajax
    public function usuario_editar_procesar_pass(){
         $pass = filter_input(INPUT_POST, 'pass');

        $idusuario = filter_input(INPUT_POST, 'idusuario');
        $nuevo_pass = $pass;

        $this->Usuario_Model->usuario_editar_pass($idusuario, $nuevo_pass);
       
        
    }
    
    
    //cambiar clave de usuario
    public function usuario_editar_pass($idusuario) {
        $data['idusuario'] = $idusuario;
        $data['lista_por_id'] = $this->Usuario_Model->encontrar_por_id($idusuario);
        $this->load->view('modules/menu/menu_administracion');
        $this->load->view('administracion/usuario/usuario_edita_contra_view', $data);
         $this->load->view('modules/foot/administracion/foot_usuario_edita');

       
    }

    public function usuario_cambiar_estado($idusuario, $estado) {
        $this->Usuario_Model->cambiar_estado_usuario($idusuario, $estado);
        if ($estado == 0) {
            header('Location:' . base_url() . 'index.php/administracion/usuario/usuario_procesar/index/1');
        } elseif ($estado == 1) {
            header('Location:' . base_url() . 'index.php/administracion/usuario/usuario_procesar/index/0');
        }
    }

    public function usuario_eliminar($idusuario) {
        $this->Usuario_Model->usuario_eliminar($idusuario);

        header('Location:' . base_url() . 'index.php/administracion/usuario/usuario_procesar/index/0');
    }

    public function usuario_buscar($inicio = 0) {
        if ($this->input->is_ajax_request()) {

            $campo = filter_input(INPUT_POST, 'campo');
            $valor = filter_input(INPUT_POST, 'valor');

            //configuramos la url de la paginacion
            $config['base_url'] = base_url() . 'index.php/administracion/usuario/usuario_procesar/usuario_buscar'; //index?
            $config['div'] = '#resultado';
            $config['show_count'] = true;
            $config['cur_page'] = base_url() . 'index.php/administracion/usuario/usuario_procesar/usuario_buscar';
            $config['total_rows'] = $this->Usuario_Model->numero_usuario_buscados($campo, $valor);
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
                $usuario_query = $this->Usuario_Model->buscar_usuario($campo, $valor, $inicio, $config['per_page']);
            } else if (!empty($campo) && empty($valor)) {
                $usuario_query = $this->Usuario_Model->usuario_paginacion(1, $inicio, $config['per_page']);
            }

            $data['titulo'] = 'Lista de Usuarios';
            $data['num'] = $inicio;
            $data['consulta_usuario'] = $usuario_query;
            $data['paginacion'] = $paginacion;

            $this->uri->segment(6);
            //cargamos nuestra vista
            $this->load->view('administracion/usuario/usuario_lista_ajax_view', $data);
        }
    }

}
