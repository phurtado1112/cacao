<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cuentas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('loged_in') != true) {
            exit('<script>alert("no tiene acceso");window.location=("http://localhost/cacao");</script>');
        }
        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
    }

     public function index($var) {
        $data['titulo'] = 'Catalogo Cuentas';
        $this->load->view('modules/menu/menu_contabilidad', $data);
         
        if ($var == 1) {
            $this->load->view('contabilidad/catalogo/cuentas/cuentas_lista_view');
            
        } else if ($var == 0) {
            $this->load->view('contabilidad/catalogo/cuentas/cuentas_lista_inactivos_view');
        }
        $this->load->view('modules/foot/contabilidad/catalogo_foot');
    }
    
    public function cuentas_listar($inicio = 0) {

        //configuramos la url de la paginacion
        $config['base_url'] = base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/cuentas_listar';
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['total_rows'] = $this->Catalogo_cuentas_model->numero_catalogo_cuentas(1);
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
        $query_cuentas = $this->Catalogo_cuentas_model->catalogo_cuentas_paginacion(1, $inicio, $config['per_page']);
        $paginacion = $this->jquery_pagination->create_links();

        $data['num'] = $inicio;
        $data['consulta_cuentas'] = $query_cuentas;
        $data['paginacion'] = $paginacion;
 
 
        //cargamos nuestra vista
        $this->load->view('contabilidad/catalogo/cuentas/cuentas_lista_ajax_view', $data);
    }
    
    
    public function cuentas_listar_inactivas($inicio = 0) {

        //configuracion basica de paginacion 
        $config['base_url'] = base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/cuentas_listar_inactivas';
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['total_rows'] = $this->Catalogo_cuentas_model->numero_catalogo_cuentas(0);
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
        $query_cuentas_inactivas = $this->Catalogo_cuentas_model->catalogo_cuentas_paginacion(0, $inicio, $config['per_page']);
        $paginacion = $this->jquery_pagination->create_links();
        //preparacion de data
        $data['titulo'] = 'Lista de cuentas inactivas';
        $data['num'] = $inicio;
        $data['consulta_cuentas_inactivas'] = $query_cuentas_inactivas;
        $data['paginacion'] = $paginacion;
        //carga de vistas
        $this->load->view('contabilidad/catalogo/cuentas/cuentas_lista_ajax_view', $data);
    }

    
    public function cuentas_buscar($inicio = 0) {

        if ($this->input->is_ajax_request()) {

            $campo = filter_input(INPUT_POST, 'campo');
            $valor = filter_input(INPUT_POST, 'valor');

            //configuramos la url de la paginacion
            $config['base_url'] = base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/cuentas_buscar'; //index?
            $config['div'] = '#resultado';
            $config['show_count'] = true;
            $config['cur_page'] = base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/cuentas_buscar';
            $config['total_rows'] = $this->Catalogo_cuentas_model->numero_cuentas_buscadas($campo, $valor);
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
                $cuentas_query = $this->Catalogo_cuentas_model->catalogo_buscar($campo, $valor, $inicio, $config['per_page']);
            } else if (!empty($campo) && empty($valor)) {
                $cuentas_query = $this->Catalogo_cuentas_model->catalogo_cuentas_paginacion(1, $inicio, $config['per_page']);
            }

            $data['titulo'] = 'Lista de catalogos';
            $data['num'] = $inicio;
            $data['consulta_cuentas'] = $cuentas_query;
            $data['paginacion'] = $paginacion;

            $this->uri->segment(6);
          
            //cargamos nuestra vista
            $this->load->view('contabilidad/catalogo/cuentas/cuentas_lista_ajax_view', $data);
        }
    }
    
    public function not_numeric($var) {
        if(!is_numeric($var)){
            return true;
        }else{
            return false;
        }
    }
    
    public function nombre_valida_cuenta($grupo_cuenta) {
        $coincidencia_encontrado = $this->Catalogo_cuentas_model->cuenta_dependencia_grupo("idgrupo_cuenta", $grupo_cuenta);
        
        if(count($coincidencia_encontrado)>0){
            return false;
            
        }else{
            return true;
            
        }
         
         
    }
    
    public function cuenta_crear() {
        $data['titulo'] = 'Catalogo Cuentas';
        $this->load->view('modules/menu/menu_contabilidad', $data);
        
        $this->form_validation->set_rules('cuenta_contable', 'Cuenta contable', 'callback_not_numeric|required|min_length[2]|trim');
        $this->form_validation->set_rules('idcuenta_contable', 'Numero de Cuenta', 'required|alpha_dash|is_unique[catalogo_cuenta.idcuenta_contable]');
        $this->form_validation->set_rules('idgrupo_cuenta', 'Grupo de Cuenta', 'callback_nombre_valida_cuenta|required|numeric');
        
        $this->form_validation->set_message('nombre_valida_cuenta', 'El campo nombre de cuenta no puede repetirse dentro de un mismo grupo');
        $this->form_validation->set_message('not_numeric', 'El campo nombre de cuenta no puede ser numerico');
        
        $tipocuenta = array('A' => 'Acreedora', 'D' => 'Deudora');
        $data['tipocuenta'] = $tipocuenta;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $grupos = $this->Grupo_cuentas_model->lista_grupo();
        
        if($grupos!=""){
            $data['idgrupo_cuenta'] = $grupos;
            
        }else{
            $data['idgrupo_cuenta'] = array("ND"=>"ND");
        }
        
        $idcuenta_contable = array(
              'name'        => 'idcuenta_contable',
              'id'          => 'idcuenta_contable',
            );
        $data['idcuenta_contable']=$idcuenta_contable;

        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {

                $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
                $this->Catalogo_cuentas_model->agregar_catalogo();
                
                header('Location:' . base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/index/1');
            } else {
                $this->load->view('contabilidad/catalogo/cuentas/cuentas_crea_view', $data);
                $this->load->view('modules/foot/contabilidad/catalogo_foot');
            }
        } else {

            $this->load->view('contabilidad/catalogo/cuentas/cuentas_crea_view', $data);
            $this->load->view('modules/foot/contabilidad/catalogo_foot');
        }
    }

    public function cuenta_modificar($idcatalogo) {
        $data['titulo'] = 'Catalogo Cuentas';
        $this->load->view('modules/menu/menu_contabilidad', $data);
        
        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $data['lista_por_id'] = $this->Catalogo_cuentas_model->encontrar_por_id($idcatalogo);
        
        if ($this->input->post('cuenta_contable') != $data['lista_por_id'][0]['cuenta']) {
            $is_unique = 'is_unique[catalogo_cuenta.cuenta_contable]|';
        } else {
            $is_unique = '';
        }
        
        $this->form_validation->set_rules('cuenta_contable', 'Cuenta contable',  $is_unique .'callback_not_numeric|required|min_length[2]|trim|callback_not_numeric');
        $this->form_validation->set_rules('idcuenta_contable', 'Numero de Cuenta', 'required|alpha_dash');
        $this->form_validation->set_rules('idgrupo_cuenta', 'Grupo de Cuenta', 'required');
        
        $this->form_validation->set_message('is_unique', 'El campo nombre de cuenta no puede repetirce');
        $this->form_validation->set_message('not_numeric', 'El campo nombre de cuenta no puede ser numerico');
        $this->form_validation->set_message('is_unique', 'El nombre de cuenta"' . $this->input->post("cuenta_contable") . '" ya esta en uso');
        
        $data['idcatalogo'] = $idcatalogo;

        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $data['lista_por_id'] = $this->Catalogo_cuentas_model->encontrar_por_id($idcatalogo);

        $tipocuenta = array('A' => 'Acreedora', 'D' => 'Deudora');
        $data['tipocuenta'] = $tipocuenta;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $data['idgrupocuenta'] = $this->Grupo_cuentas_model->lista_grupo();
        
        $idcuenta_contable = array(
              'name'        => 'idcuenta_contable',
              'id'          => 'idcuenta_contable',
            );
        $data['idcuenta_contable']=$idcuenta_contable;

        if($this->input->post()){
            
            if($this->form_validation->run() == TRUE){
                $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
                $this->Catalogo_cuentas_model->modificar_catalogo($idcatalogo);
                header('Location:'.base_url().'index.php/contabilidad/catalogo/cuentas/cuentas/index/1');
          
            }else{
                $this->load->view('contabilidad/catalogo/cuentas/cuentas_edita_view',$data);
            }
            
        }else{
            $this->load->view('contabilidad/catalogo/cuentas/cuentas_edita_view',$data);
        }
        $this->load->view('modules/foot/contabilidad/catalogo_foot');
    }

    
    public function cuenta_cambiar_estado($idcuenta_contable, $estado) {
        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $this->Catalogo_cuentas_model->cambiar_estado_catalogo($idcuenta_contable, $estado);

        if($estado==0){header('Location:'.base_url().'index.php/contabilidad/catalogo/cuentas/cuentas/index/1');}
        elseif($estado==1) {header('Location:'.base_url().'index.php/contabilidad/catalogo/cuentas/cuentas/index/0');}
        
    }
    
    public function cuenta_relacion_adr_adrd() {
        $this->load->model('contabilidad/transacciones/asiento_diario_detalle/Asiento_diario_detalle_model');
        $this->load->model('contabilidad/transacciones/asiento_diario_detalle_recurrente/Asiento_diario_detalle_recurrente_model');

        $idcuenta = filter_input(INPUT_POST, 'idcuenta');
//        
        $cuenta_contable_add = $this->Asiento_diario_detalle_model->cuenta_relacion_adr("idcuenta_contable",$idcuenta);
        $cuenta_contable_addr = $this->Asiento_diario_detalle_recurrente_model->cuenta_relacion_adr_recurrente("idcuenta_contable",$idcuenta);
       
        echo(count($cuenta_contable_add)+ count($cuenta_contable_addr));
    }
    
    public function cuenta_eliminar($idcuenta) {
        $this->Catalogo_cuentas_model->eliminar_cuenta($idcuenta);
        
        header('Location:' . base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/index/0');
    }
     
    public function cuenta_consulta_esturctura_id(){
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        
        $idgrupo = filter_input(INPUT_POST, 'idgrupo');
        
        $grupo = $this->Grupo_cuentas_model->encontrar_por_id_datos($idgrupo);
        $categoria = $this->Categorias_cuentas_model->encontrar_por_id_datos($grupo[0]['idcategoria_cuenta']);
        
        
        echo($categoria[0]['idestructura_base']."|".$grupo[0]['idcategoria_cuenta']."|".$grupo[0]['nivel']."|".$grupo[0]['nivel_anterior']);
    }
    
    
}

/*Fin del archivo my_controller.php*/