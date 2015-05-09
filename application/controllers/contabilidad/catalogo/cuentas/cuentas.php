<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cuentas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->view('modules/foot');
    }

    public function index() {
       $this->load->library('pagination');
         $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
         
        //configuracion basica de paginacion 
        $config['base_url']= base_url().'index.php/contabilidad/catalogo/cuentas/cuentas/index'; 
        $config['total_rows']=$this->Catalogo_cuentas_model->numero_catalogo_cuentas(1);
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
        
        $query_catalogo = $this->Catalogo_cuentas_model->catalogo_cuentas_paginacion(1,$inicio,$config['per_page']);
        
        //preparacion de data
        $data['titulo']='Lista de Cuentas';
        $data['num']=$inicio;
        $data['consulta_catalogo']=$query_catalogo;
        $data['paginacion']=$this->pagination->create_links();
        $this->load->view('modules/menu/menu_contabilidad',$data);
        $this->load->view('contabilidad/catalogo/cuentas/cuentas_lista_view',$data);
    }

    public function cuenta_listar_inactivas() {
         $this->load->library('pagination');
         $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
         
        //configuracion basica de paginacion 
        $config['base_url']= base_url().'index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_listar_inactivas'; 
        $config['total_rows']=$this->Catalogo_cuentas_model->numero_catalogo_cuentas(0);
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
        
        $query_catalogo = $this->Catalogo_cuentas_model->catalogo_cuentas_paginacion(0,$inicio,$config['per_page']);
        
        //preparacion de data
        $data['titulo']='Lista de Cuentas';
        $data['num']=$inicio;
        $data['consulta_catalogo']=$query_catalogo;
        $data['paginacion']=$this->pagination->create_links();
        //carga de vistas
        $this->load->view('modules/menu/menu_contabilidad',$data);
        $this->load->view('contabilidad/catalogo/cuentas/cuentas_lista_inactivos_view',$data);
        
    }

    public function cuenta_crear() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cuenta_contable', 'Cuenta contable', 'required|min_length[3]');

        $tipocuenta = array('A' => 'Acreedora', 'D' => 'Deudora');
        $data['tipocuenta'] = $tipocuenta;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $data['idgrupocuenta'] = $this->Grupo_cuentas_model->lista_grupo();


        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {

                $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
                $this->Catalogo_cuentas_model->agregar_catalogo();

                $this->index();
            } else {
                $this->load->view('contabilidad/catalogo/cuentas/cuentas_crea_view', $data);
            }
        } else {

            $this->load->view('contabilidad/catalogo/cuentas/cuentas_crea_view', $data);
        }
    }

    public function cuenta_modificar($idcatalogo) {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cuenta_contable', 'Categoria', 'required|min_length[4]');
        $this->form_validation->set_rules('cuenta_contable', 'Categoria', 'required|min_length[4]');

        $data['idcatalogo'] = $idcatalogo;

        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $data['lista_por_id'] = $this->Catalogo_cuentas_model->encontrar_por_id($idcatalogo);

        $tipocuenta = array('A' => 'Acreedora', 'D' => 'Deudora');
        $data['tipocuenta'] = $tipocuenta;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $data['idgrupocuenta'] = $this->Grupo_cuentas_model->lista_grupo();

        if($this->input->post()){
            
            if($this->form_validation->run() == TRUE){
                $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
                $this->Catalogo_cuentas_model->modificar_catalogo($idcatalogo);
                header('Location:'.base_url().'index.php/contabilidad/catalogo/cuentas/cuentas');
          
            }else{
                $this->load->view('modules/menu/menu_contabilidad');
                $this->load->view('contabilidad/catalogo/cuentas/cuentas_edita_view',$data);
            }
            
        }else{
            $this->load->view('modules/menu/menu_contabilidad');
            $this->load->view('contabilidad/catalogo/cuentas/cuentas_edita_view',$data);
        }
    }

    
    public function cuenta_cambiar_estado($idcuenta_contable, $estado) {
        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $this->Catalogo_cuentas_model->cambiar_estado_catalogo($idcuenta_contable, $estado);

        if($estado==0){header('Location:'.base_url().'index.php/contabilidad/catalogo/cuentas/cuentas');}
        elseif($estado==1) {header('Location:'.base_url().'index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_listar_inactivas');}
        
    }

}

/*Fin del archivo my_controller.php*/