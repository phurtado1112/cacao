<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Jasper_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function generarReportePdf($dirReporte, $nombreReporte, $parametros, $ruta) {

        $cliente = new Jasper();
        $cliente->credenciales('http://localhost:8080/jasperserver/services/repository?wsdl', 'cacaojasperuser', 'Cju2015');
        $resultado = $cliente->printReport($dirReporte, $nombreReporte, 'HTML', $parametros);
        if ($resultado) {
            file_put_contents($ruta, $resultado);

            unset($resultado);
            return true;
        } else {
            unset($resultado);
            return false;
        }
        
    }
}
