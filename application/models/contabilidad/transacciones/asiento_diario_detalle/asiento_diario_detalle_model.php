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
    
    public function asiento_diario_detalle_por_id_ad($idasiento_diario = NULL) {
        if ($idasiento_diario != NULL) {

            $query = $this->db->where('idasiento_diario', $idasiento_diario);
            $query = $this->db->get('asiento_diario_detalle');
        }
        return $query->result_array();
    }
    
    public function asiento_diario_detalle_eliminar($numero_transacciones = NULL,$idasiento_diario = NULL) {
        if ($numero_transacciones != NULL) {

            $query = $this->db->query("DELETE FROM asiento_diario_detalle WHERE idasiento_diario = ".$idasiento_diario." AND numero_transacciones = ".$numero_transacciones."");
        }
        return $query->result_array();
    }
    
    public function asiento_diario_detalle_modificar($idasiento_diario_detalle
            ,$numero_transacciones,$idcuenta_contable, $tipo_transaccion,$monto_moneda_nacional,
            $monto_moneda_extranjera) {

        $this->db->query("UPDATE asiento_diario_detalle SET
            numero_transacciones = ".$numero_transacciones.",idcuenta_contable = '".$idcuenta_contable."', 
            tipo_transaccion = '".$tipo_transaccion."',monto_moneda_nacional = ".$monto_moneda_nacional.", monto_moneda_extranjera = ".$monto_moneda_extranjera."
            WHERE idasiento_diario_detalle = ".$idasiento_diario_detalle."");
    }
    


}
