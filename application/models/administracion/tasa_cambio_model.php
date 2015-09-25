<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Tasa_cambio_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function tasa_cambio_agregar($idmoneda, $fecha_tipo_cambio, $tasa_cambio) {
        $this->db->query("INSERT INTO tasa_cambio(idmoneda, fecha_tipo_cambio, tasa_cambio) "
                . "VALUES (" . $idmoneda . ",'" . $fecha_tipo_cambio . "'," . $tasa_cambio . ")");
    }
   
    function lista_tasa_cambio() {
        $lista_tasa_cambio = $this->db->query('SELECT idtasa_cambio, tasa_cambio from tasa_cambio where idtasa_cambio > 0');
        return $lista_tasa_cambio->result_array();
        
    }
    public function tasa_cambio_encontrar_por_fecha($fecha_tipo_cambio,$idmoneda) {
        if ($fecha_tipo_cambio != NULL) {
            $query = $this->db->query("SELECT idtasa_cambio, tasa_cambio, fecha_tipo_cambio  FROM tasa_cambio WHERE fecha_tipo_cambio LIKE '" . $fecha_tipo_cambio . "' AND idmoneda = ".$idmoneda."");
        }
        return $query->result_array();
    }
}