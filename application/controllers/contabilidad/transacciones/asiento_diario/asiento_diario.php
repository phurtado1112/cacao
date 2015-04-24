<?php

class Asiento_diario extends CI_Controller 

{
    public function __construct (){
        parent::__construct();
         $this->load->helper('url');
}
public function index() {
    
    $this->listar();
    }
    
     public function listar(){
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->model('contabilidad/transacciones/asiento_diario/Asiento_diario_model');
        $vista = $this->Asiento_diario_model->listar();
        $data['asiento_diario'] = $vista;
              
        $this->load->view('contabilidad/transacciones/asiento_diario/asiento_diario_lista_view',$data);
        
    }
    
     public function crear(){
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->load->model('contabilidad/transacciones/asiento_diario/Origen_asiento_diario_model');
        $data['idorigen_asiento_diario'] = $this->Origen_asiento_diario_model->lista_origen_asiento_diario();
        
        $this->load->model('contabilidad/transacciones/asiento_diario/Tipo_moneda_model');
        $data['idmoneda'] = $this->Tipo_moneda_model->lista_moneda();
         
        $this->load->model('contabilidad/transacciones/asiento_diario/Tasa_cambio_model');
        $data['idtasa_cambio'] = $this->Tasa_cambio_model->lista_tasa_cambio();
        
        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $data['idcuenta_contable'] = $this->Catalogo_cuentas_model->lista_cuentas();
        
        
        
        
          
          
        if($this->input->post()){
            
            if($this->form_validation->run()==TRUE){
                $this->load->model('contabilidad/transacciones/asiento_diario/Origen_asiento_diario_model');
                $this->Origen_asiento_diario_model->crear();
            
                $this->listar();
        } else {
            $this->load->view('contabilidad/transacciones/asiento_diario/asiento_diario_crear_view', $data);
        }
        }
          else{
            $this->load->view('contabilidad/transacciones/asiento_diario/asiento_diario_crear_view', $data);
        }
             
                        
        }
    
    ////////////////////////////////////////////////////////////////////////////
   
    
   
        
    public function modificar($idasiento_diario) {
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->helper('form');
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('categoria_cuenta','Categoria','required|min_length[4]');
         
        $data['$idasiento_diario']=$idasiento_diario;
        
        $this->load->model('AD/Origen_asiento_diario');
        $data['idorigen_asiento_diario'] = $this->Origen_asiento_diario->lista_dropdown();
        
        $this->load->model('AD/Tasa_cambio');
        $data['idtasa_cambio'] = $this->Tasa_cambio->lista_dropdown();
        
        $this->load->model('AD/Tipo_moneda');
        $data['idmoneda'] = $this->Tipo_moneda->lista_dropdown();
        
        $this->load->model('AD/Ad');
        $data['lista_por_id'] = $this->Ad->encontrar_por_id($idasiento_diario);
        
       
        if($this->input->post()){
            
            if($this->form_validation->run() == TRUE){
                $this->load->model('AD/Ad');
                $this->Ad->modificar($idasiento_diario);
                $this->leer(1);
          
            }else{
                $this->load->view('AD/v_editar_ad',$data);
            }
            
        }else{
            $this->load->view('AD/v_editar_ad',$data);
        }
    }
        
        
    
}    