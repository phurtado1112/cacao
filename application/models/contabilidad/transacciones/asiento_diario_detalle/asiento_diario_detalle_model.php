<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Asiento_diario_detalle_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function asiento_diario_detalle_crear(
            $idasiento_diario,$numero_transacciones,$idcuenta_contable, $tipo_transaccion,$monto_moneda_nacional,
            $monto_moneda_extranjera) {

        $this->db->query("INSERT INTO asiento_diario_detalle
               (idasiento_diario,numero_transacciones,idcuenta_contable, tipo_transaccion,monto_moneda_nacional, monto_moneda_extranjera) 
               VALUES(".$idasiento_diario.",".$numero_transacciones.",'".$idcuenta_contable."','".$tipo_transaccion."',".$monto_moneda_nacional.",".$monto_moneda_extranjera.")");
    }
    
    
    

    public function listar() {
        $this->load->database();
        $query = $this->db->query('select idasiento_diario, numero_asiento_diario, origen, descripcion_asiento_diario, fecha_creacion, balance_debito, balance_credito from asiento_diario_view where idasiento_diario >0');

        return $query->result_array();
    }

    public function encontrar_por_id($idasiento_diario = NULL) {
        if ($idasiento_diario != NULL) {

            $query = $this->db->where('idasiento_diario', $idasiento_diario);
            $query = $this->db->get('asiento_diario_view');
        }
        return $query->result_array();
    }

    public function modificar($idasiento_diario) {
        $form_data = $this->input->post();
        unset($form_data['botonSubmit']);

        $this->db->where('idasiento_diario', $idasiento_diario);
        $this->db->update('idasiento_diario', $form_data);
    }

}
