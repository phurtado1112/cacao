<?php if (! defined ('BASEPATH')) {exit ('No direct script access allowed');};

class Tasa_cambio_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        
    }
    
    public function tasa_cambio_agregar($idmoneda,$fecha_tipo_cambio,$tasa_cambio){
        $this->db->query("INSERT INTO tasa_cambio(idmoneda, fecha_tipo_cambio, tasa_cambio) "
                . "VALUES (".$idmoneda.",'".$fecha_tipo_cambio."',".$tasa_cambio.")");             
   }
    
}
