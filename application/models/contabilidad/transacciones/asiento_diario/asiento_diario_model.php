<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Asiento_diario_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function asiento_diario_listar() {
        $query = $this->db->query('select idasiento_diario, origen, descripcion_asiento_diario, fecha_creacion,'
                . ' balance_debito_nacional, balance_credito_nacional, balance_debito_extranjero,balance_credito_extranjero '
                . 'from asiento_diario_view ORDER BY idasiento_diario');

        return $query->result_array();
    }

    public function asiento_diario_listar_num() {
        $query = $this->db->query('select idasiento_diario FROM asiento_diario_view');

        return $query->num_rows();
    }

    public function asiento_diario_crear( $idasiento_diario, $idorigen_asiento_diario, $descripcion_asiento_diario, $fecha_creacion, $fecha_fiscal, $usuario_creacion, $idtasa_cambio, $balance_debito_nacional, $balance_credito_nacional, $balance_debito_extranjero, $balance_credito_extranjero
    ) {
//        $this->db->query("INSERT INTO asiento_diario(
//             idasiento_diario, 
//             idorigen_asiento_diario, 
//             descripcion_asiento_diario, 
//             fecha_creacion, 
//             fecha_fiscal, 
//             usuario_creacion,
//             idtasa_cambio,
//             balance_debito_nacional, 
//             balance_credito_nacional,
//             balance_debito_extranjero, 
//             balance_credito_extranjero
//             ) VALUES( '" . $idasiento_diario . "'," . $idorigen_asiento_diario . ",'" . $descripcion_asiento_diario . "',
//                 '" . $fecha_creacion . "','" . $fecha_fiscal . "','" . $usuario_creacion . "'," . $idtasa_cambio . "," .
//                $balance_debito_nacional . "," . $balance_credito_nacional . "," . $balance_debito_extranjero . "," .
//                $balance_credito_extranjero . ")");
        
        $this->db->query("INSERT INTO asiento_diario(
             idasiento_diario, 
             idorigen_asiento_diario, 
             descripcion_asiento_diario, 
             fecha_creacion, 
             fecha_fiscal, 
             usuario_creacion,
             idtasa_cambio,
             balance_debito_nacional, 
             balance_credito_nacional,
             balance_debito_extranjero, 
             balance_credito_extranjero
             ) VALUES( '" . $idasiento_diario . "'," . $idorigen_asiento_diario . ",'" . $descripcion_asiento_diario . "',
                 '" . $fecha_creacion . "','" . $fecha_fiscal . "','" . $usuario_creacion . "'," . $idtasa_cambio . "," .
                $balance_debito_nacional . "," . $balance_credito_nacional . "," . $balance_debito_extranjero . "," .
                $balance_credito_extranjero . ")");
    }

    public function asiento_diario_encontrar_por_id_ad($idasiento_diario = NULL) {
        if ($idasiento_diario != NULL) {

            $query = $this->db->where('idasiento_diario', $idasiento_diario);
            $query = $this->db->get('asiento_diario');
        }
        return $query->result_array();
    }

    ///////////

    public function asiento_diario_modificar(
    $idasiento_diario, $descripcion_asiento_diario, $fecha_modificacion, $fecha_fiscal, $usuario_modificacion, $idtasa_cambio, $balance_debito_nacional, $balance_credito_nacional, $balance_debito_extranjero, $balance_credito_extranjero
    ) {
        $this->db->query("UPDATE asiento_diario SET "
                . "descripcion_asiento_diario = '" . $descripcion_asiento_diario . "', "
                . "fecha_modificacion = '" . $fecha_modificacion . "', "
                . "fecha_fiscal = '" . $fecha_fiscal . "', "
                . "usuario_modificacion = '" . $usuario_modificacion . "', "
                . "idtasa_cambio = " . $idtasa_cambio . ", "
                . "balance_debito_nacional = " . $balance_debito_nacional . ","
                . "balance_credito_nacional =" . $balance_credito_nacional . " , "
                . "balance_debito_extranjero =" . $balance_debito_extranjero . " , "
                . "balance_credito_extranjero = " . $balance_credito_extranjero . " "
                . "WHERE idasiento_diario = '" . $idasiento_diario . "'");
    }

    ////////////////////lista de idasiento_diario///////////////////////////////////
//    public function volver_idasiento_diario() {
//        $query = $this->db->query("select idasiento_diario from asiento_diario");
//
//        return $query->result_array();
//    }
    ////////////////////////////////////////////////////////////////////////////////  

    public function asiento_diario_paginacion($inicio, $num_por_pagina) {
        $datos = $this->db->query('SELECT idasiento_diario,origen, descripcion_asiento_diario, balance_debito_nacional, balance_credito_nacional, balance_debito_extranjero,balance_credito_extranjero, '
                . 'fecha_creacion, fecha_modificacion FROM asiento_diario_view ORDER BY idasiento_diario LIMIT ' . $inicio . ',' . $num_por_pagina . '');
        return $datos->result_array();
    }

    public function asiento_diario_buscar($campo, $valor, $inicio, $num_por_pagina) {
        if ($valor != NULL && !empty($campo)) {
            $query = $this->db->query("SELECT idasiento_diario,origen, descripcion_asiento_diario, balance_debito_nacional, balance_credito_nacional, balance_debito_extranjero,balance_credito_extranjero, "
                    . "fecha_creacion, fecha_edicion FROM asiento_diario_view WHERE " . $campo . " like '" . $valor . "%'ORDER BY idasiento_diario LIMIT " . $inicio . "," . $num_por_pagina . "");
        }
        return $query->result_array();
    }

    public function asiento_diario_eliminar($idasiento_diario) {
        $this->db->query("delete from asiento_diario WHERE idasiento_diario = '" . $idasiento_diario . "'");
    }

}
