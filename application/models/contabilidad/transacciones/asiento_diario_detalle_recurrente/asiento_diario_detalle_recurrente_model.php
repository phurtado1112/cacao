 <?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Asiento_diario_detalle_recurrente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function ad_detalle_recurrente_crear($idasiento_diario_recurrente,$numero_transaccion,$idcuenta_contable, $tipo_transaccion,$monto_transaccion) {

        $this->db->query("INSERT INTO asiento_diario_detalle_recurrente
               (idasiento_diario_recurrente,numero_transaccion,idcuenta_contable, naturaleza_cuenta_contable,monto_transaccion) 
               VALUES(".$idasiento_diario_recurrente.",".$numero_transaccion.",'".$idcuenta_contable."','".$tipo_transaccion."',".$monto_transaccion.")");
    }
    
    public function ad_detalle_recurrente_por_id_adr($idasiento_diario_recurrente = NULL) {
        if ($idasiento_diario_recurrente != NULL) {

            $query = $this->db->query('SELECT * FROM asiento_diario_detalle_recurrente WHERE idasiento_diario_recurrente ='.$idasiento_diario_recurrente.' ORDER BY numero_transaccion');
        }
        return $query->result_array();
    }
    
    public function ad_detalle_recurrente_eliminar($numero_transaccion ,$idasiento_diario_recurrente) {
        
        $this->db->query("DELETE FROM asiento_diario_detalle_recurrente WHERE idasiento_diario_recurrente = ".$idasiento_diario_recurrente." AND numero_transaccion = ".$numero_transaccion."");
        
    }
    
    public function ad_detalle_recurrente_modificar($idasiento_diario_recurrente,$numero_transaccion
            ,$idcuenta_contable, $naturaleza_cuenta_contable,$monto_transaccion) {

        $this->db->query("UPDATE asiento_diario_detalle_recurrente SET
            idcuenta_contable = '".$idcuenta_contable."', 
            naturaleza_cuenta_contable = '".$naturaleza_cuenta_contable."',monto_transaccion = ".$monto_transaccion."
            WHERE (idasiento_diario_recurrente = ".$idasiento_diario_recurrente.") AND (numero_transaccion =".$numero_transaccion.")");
    }
    
    public function cuenta_relacion_adr_recurrente($campo,$valor) {
            $query = $this->db->query("select * from asiento_diario_detalle_recurrente WHERE ".$campo."='".$valor."'");
            return $query->result_array(); 
     }

}
