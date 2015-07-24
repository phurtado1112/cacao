<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Asiento_diario_recurrente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function ad_recurrente_listar() {
        $this->load->database();
        $query = $this->db->query('select * from asiento_diario_recurrente_view where idasiento_diario_recurrente >0 ');

        return $query->result_array();
    }

    public function  ad_recurrente_listar_num() {
        $this->load->database();
        $query = $this->db->query('select * from asiento_diario_recurrente_view where idasiento_diario_recurrente >0');

        return $query->num_rows();
    }

    public function ad_recurrente_crear($idorigen_asiento_diario, $descripcion_asiento_diario, $fecha_creacion, $usuario_creacion, $idmoneda, $balance_debito, $balance_credito) {
        $this->db->query("INSERT INTO asiento_diario_recurrente(
             idorigen_asiento_diario, descripcion_asiento_diario_recurrente, fecha_creacion, usuario_creacion, idmoneda, balance_debito, balance_credito
             ) VALUES(" . $idorigen_asiento_diario . ",'" . $descripcion_asiento_diario . "', '" . $fecha_creacion . "','" . $usuario_creacion . "'," . $idmoneda . "," . $balance_debito . "," . $balance_credito . ")");
    }

    public function ad_recurrente_encontrar_por_id($id_ad_recurrente) {
        if ($id_ad_recurrente != NULL) {

            $query = $this->db->where('idasiento_diario_recurrente', $id_ad_recurrente);
            $query = $this->db->get('asiento_diario_recurrente');
        }
        return $query->result_array();
    }

    public function ad_recurrente_modificar($id_ad_recurrente, $descripcion_asiento_diario, $fecha_modificacion, $usuario_modificacion, $idmoneda, $balance_debito, $balance_credito , $idorigen_asiento_diario
    ) {
        $this->db->query("UPDATE asiento_diario_recurrente SET
              descripcion_asiento_diario_recurrente = '" . $descripcion_asiento_diario . "', fecha_modificacion = '" . $fecha_modificacion . "', usuario_modificacion = '" . $usuario_modificacion . "',"
                . " idmoneda = " . $idmoneda . ",
                balance_debito = " . $balance_debito . ", balance_credito = " . $balance_credito . ", idorigen_asiento_diario = ". $idorigen_asiento_diario ."
             WHERE idasiento_diario_recurrente = '" . $id_ad_recurrente . "'");
    }

    ////////////////////lista de idasiento_diario///////////////////////////////////

    public function volver_id_ad_recurrente() {
        $query = $this->db->query("select idasiento_diario_recurrente from asiento_diario_recurrente");

        return $query->result_array();
    }

    ////////////////////////////////////////////////////////////////////////////////  



    public function ad_recurrente_paginacion($inicio, $num_por_pagina) {
        $datos = $this->db->query('SELECT * FROM asiento_diario_recurrente_view WHERE idasiento_diario_recurrente > 0 ORDER BY idasiento_diario_recurrente LIMIT ' . $inicio . ',' . $num_por_pagina . '');
        return $datos->result_array();
    }

//    public function ad_recurrente_buscar($campo, $valor, $inicio, $num_por_pagina) {
//
//        if ($valor != NULL && !empty($campo)) {
//
//            $query = $this->db->query("SELECT numero_asiento_diario,origen,descripcion_asiento_diario, fecha_creacion, balance_debito,balance_credito FROM asiento_diario_view WHERE idasiento_diario > 0 AND " . $campo . " like '" . $valor . "%'ORDER BY idasiento_diario LIMIT " . $inicio . "," . $num_por_pagina . "");
//        }
//
//        return $query->result_array();
//    }

    public function ad_recurrente_eliminar($idasiento_diario_recurrente) {
        $this->db->query("delete from asiento_diario_recurrente WHERE idasiento_diario_recurrente = " . $idasiento_diario_recurrente);
    }

}
