<?php

class Origen_asiento_diario_model extends CI_Model {

    public function __construct() {
        parent:: __construct();
    }

    function lista_origen_asiento_diario() {
        $lista_origen_asiento_diario = $this->db->query('select idorigen_asiento_diario, descripcion_origen_asiento_diario from origen_asiento_diario where idorigen_asiento_diario > 0');
        return $lista_origen_asiento_diario->result_array();
    }

}
