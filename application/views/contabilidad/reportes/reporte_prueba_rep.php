<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

$reportManager = new ReportManager();

//echo 'Estoy en reporte prueba';
$result = $reportManager->RunToFile('reporte_prueba', 'pdf');

header('Content-type: application/pdf');

//print $result;
