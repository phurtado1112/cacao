<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Contabilidad_config_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
         $this->load->database();
    }
    //agregar registros 
    public function agregar_contabilidad_config($anio_fiscal, $decimales_redondeo, $periodo_actual, $patron_cuenta,
            $cuenta_contable, $bancos , $inventarios, $compras, $cuentas_por_pagar, $cuentas_por_cobrar, $facturas){
        
        $this->db->query("INSERT INTO contabilidad_config() values()");
    }
//modificar    
    public function modificar_ontabilidad_config($idcontabilidad_config){
         $form_data = $this->input->post();
         unset($form_data['botonSubmit']);
         
         $this->db->where('idcontabilidad_config',$idcontabilidad_config);
         $this->db->update('contabilidad_config',$form_data);
    }
   
}
