<?php

require './tcpdf/tcpdf.php';

class Pdf extends TCPDF {

    public function __construct() {
        parent::__construct();
    } 
}    