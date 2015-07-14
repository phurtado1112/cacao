  <?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Asiento_diario_detalle_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function asiento_diario_detalle_crear(
            $idasiento_diario,$numero_transacciones,$idcuenta_contable, $naturaleza_cuenta_contable,$monto_moneda_nacional,
            $monto_moneda_extranjera) {
        $this->db->query("INSERT INTO asiento_diario_detalle
               (idasiento_diario,numero_transaccion,idcuenta_contable, naturaleza_cuenta_contable,monto_moneda_nacional, monto_moneda_extranjera) 
               VALUES('".$idasiento_diario."',".$numero_transacciones.",'".$idcuenta_contable."','".$naturaleza_cuenta_contable."',".$monto_moneda_nacional.",".$monto_moneda_extranjera.")");
    }
    
    public function asiento_diario_detalle_por_id_ad($idasiento_diario ) {
        if ($idasiento_diario != NULL) {
            $query = $this->db->query('SELECT * FROM asiento_diario_detalle WHERE idasiento_diario ="'.$idasiento_diario.'" ORDER BY numero_transaccion');
        }
        return $query->result_array();
    }
    
    public function asiento_diario_detalle_eliminar($numero_transacciones ,$idasiento_diario ) {
        if ($numero_transacciones != NULL) {
            $this->db->query("DELETE FROM asiento_diario_detalle WHERE idasiento_diario = '".$idasiento_diario."' AND numero_transaccion = ".$numero_transacciones."");
        }
    }
    
    public function asiento_diario_detalle_modificar($idasiento_diario,
            $numero_transacciones
            ,$idcuenta_contable, 
            $naturaleza_cuenta_contable,
            $monto_moneda_nacional,
            $monto_moneda_extranjera) {
        $this->db->query("UPDATE asiento_diario_detalle SET
            idcuenta_contable = '".$idcuenta_contable.
                "', naturaleza_cuenta_contable = '".$naturaleza_cuenta_contable.
                "',monto_moneda_nacional = ".$monto_moneda_nacional.
                ", monto_moneda_extranjera = ".$monto_moneda_extranjera."
            WHERE (idasiento_diario = '".$idasiento_diario."') AND (numero_transaccion =".$numero_transacciones.")");
    }
    
     public function cuenta_relacion_adr($campo,$valor) {
            $query = $this->db->query("select * from asiento_diario_detalle WHERE ".$campo."='".$valor."'");
            return $query->result_array(); 
     }
}