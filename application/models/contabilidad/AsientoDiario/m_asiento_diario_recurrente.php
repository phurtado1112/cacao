<?php

class M_Asiento_Diario_Recurrente extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function lista_dropdown() {
        $query = $this->db->query('select idorigen_asiento_diario,descripcion_origen_asiento_diario from origen_asiento_diario');
        $dropdowns = $query->result_array();
        foreach ($dropdowns as $dropdown) {
            $lista[$dropdown['idorigen_asiento_diario']] = $dropdown['descripcion_origen_asiento_diario'];
        }
        $option = $lista;
        return $option;
    }

    function lista_moneda() {
        $query = $this->db->query('select idmoneda,descripcion_moneda from tipo_moneda');
        $dropdowns = $query->result_array();
        foreach ($dropdowns as $dropdown) {
            $lista[$dropdown['idmoneda']] = $dropdown['descripcion_moneda'];
        }
        $option = $lista;
        return $option;
    }

    function lista_cambio() {
        $query = $this->db->query('select idtasa_cambio,tasa_cambio from tasa_cambio');
        $dropdowns = $query->result_array();
        foreach ($dropdowns as $dropdown) {
            $lista[$dropdown['idtasa_cambio']] = $dropdown['tasa_cambio'];
        }
        $option = $lista;
        return $option;
    }
        function lista_cuenta_nivel() {
        $query = $this->db->query('select idgrupo_cuenta,nivel from Grupo_cuenta');
        $dropdowns = $query->result_array();
        foreach ($dropdowns as $dropdown) {
            $lista[$dropdown['idgrupo_cuenta']] = $dropdown['nivel'];
        }
        $option = $lista;
        return $option;

}
        function lista_cuenta_nombre() {
        $query = $this->db->query('select idgrupo_cuenta,grupo_cuenta from Grupo_cuenta');
        $dropdowns = $query->result_array();
        foreach ($dropdowns as $dropdown) {
            $lista[$dropdown['idgrupo_cuenta']] = $dropdown['grupo_cuenta'];
        }
        $option = $lista;
        return $option;
        }
}