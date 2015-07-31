<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Asiento_mayor_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function mayorizar_asiento_diario($idasiento_diario) {
        //Inserta datos en la tabla de asiento_mayor desde la tabla de asiento_diario
        $this->db->query('INSERT INTO asiento_mayor (idasiento_diario, idorigen_asiento_diario, descripcion_asiento_diario,fecha_creacion,
            fecha_fiscal,fecha_modificacion,usuario_creacion, idtasa_cambio,balance_debito_nacional,balance_credito_nacional,
            balance_debito_extranjero,balance_credito_extranjero) 
            SELECT idasiento_diario, idorigen_asiento_diario, descripcion_asiento_diario,fecha_creacion,fecha_fiscal,
            fecha_modificacion,usuario_creacion, idtasa_cambio,balance_debito_nacional,balance_credito_nacional,
            balance_debito_extranjero,balance_credito_extranjero 
            from asiento_diario where idasiento_diario="' . $idasiento_diario . '"');
    }

    public function mayorizar_asiento_diario_detalle($idasiento_diario) {
        //Inserta datos en la tabla de asiento_mayor_detalle desde la tabla de asiento_diario_detalle
        $this->db->query('INSERT INTO asiento_mayor_detalle (idasiento_diario, numero_transaccion,idcuenta_contable,naturaleza_transaccion,monto_moneda_nacional,monto_moneda_extranjera) 
            SELECT idasiento_diario, numero_transaccion, idcuenta_contable, naturaleza_transaccion, monto_moneda_nacional, monto_moneda_extranjera 
            from asiento_diario_detalle where idasiento_diario="' . $idasiento_diario . '"');
    }

    public function leer_cuentas_mayor_detalle($id_asiento_diario) {
        $consulta_cuentas = $this->db->query('select distinct idcuenta_contable from asiento_mayor_detalle where idasiento_diario="' . $id_asiento_diario . '"');
        $consulta_cuentas_mayor_detalle = $consulta_cuentas->result_array();
        return $consulta_cuentas_mayor_detalle;
    }

    public function encontrar_fecha_asiento_mayor($idasiento_diario) {
        $fecha_asiento_mayor = $this->db->query('SELECT fecha_fiscal FROM asiento_mayor where idasiento_diario="' . $idasiento_diario . '"');
        $fecha_mayor = $fecha_asiento_mayor->result_array();
        return $fecha_mayor[0]['fecha_fiscal'];
    }

    public function encontrar_anio_fiscal_asiento_mayor($fecha_asiento_mayor) {
        $anio = $this->db->query('SELECT year("' . $fecha_asiento_mayor . '") as anio FROM asiento_mayor');
        $anio_fis = $anio->result_array();
        return $anio_fis[0]['anio'];
    }

    public function encontrar_periodo_fiscal_asiento_mayor($fecha_asiento_mayor, $anio_fiscal) {
        $periodo = $this->db->query('SELECT periodo_fiscal FROM periodos_fiscales WHERE fecha_inicio <= "' . $fecha_asiento_mayor . '" AND fecha_fin >= "' . $fecha_asiento_mayor . '" AND ejercicio_fiscal ="' . $anio_fiscal . '"');
        $periodo_fis = $periodo->result_array();
        $periodo_fiscal = 'periodo' . $periodo_fis[0]['periodo_fiscal'];
        return $periodo_fiscal;
    }

    public function buscar_cuenta_contable_saldos($anio) {
        $cuentas_saldos = $this->db->query('select idcuenta_contable from saldos where anio="' . $anio . '"');
        $cuetas_en_saldos = $cuentas_saldos->result_array();
        return $cuetas_en_saldos;
    }

    public function agregar_cuenta_contable($idcuenta, $anio_fiscal) {
        $this->db->query('insert into saldos (idcuenta_contable,anio) values("' . $idcuenta . '","' . $anio_fiscal . '")');
    }

    public function sumar_montos_asiento_mayor_detalle($idasiento_diario) {
        //hace la sumatoria de la cuentas
        $montos = $this->db->query("select asiento_diario_detalle.idcuenta_contable, naturaleza_cuenta_contable, naturaleza_transaccion, "
                . "sum(if(naturaleza_cuenta_contable='D',if(naturaleza_transaccion='D', monto_moneda_nacional, -monto_moneda_nacional), "
                . "if(naturaleza_transaccion='C',monto_moneda_nacional,-monto_moneda_nacional))) as monto_local "
                . "from asiento_diario_detalle left join catalogo_cuenta on (asiento_diario_detalle.idcuenta_contable = catalogo_cuenta.idcuenta_contable) "
                . "where idasiento_diario = '" . $idasiento_diario . "' group by idcuenta_contable order by idcuenta_contable");
        return $montos->result_array();
    }

    public function mayorizar_saldos($periodo_fiscal, $monto, $idcuenta_contable, $anio_fiscal) {
        $this->db->query('update saldos set ' . $periodo_fiscal . '=' . $monto . ' where idcuenta_contable="' . $idcuenta_contable . '" and anio="' . $anio_fiscal . '"');
    }
    
    public function eliminar_asiento_diario($idasiento_diario) {
        $this->db->query('delete from asiento_diario_detalle where idasiento_diario="'.$idasiento_diario.'"');
        $this->db->query('delete from asiento_diario where idasiento_diario="'.$idasiento_diario.'"');
    }

}
