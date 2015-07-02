<?php

class Login_Model extends CI_Model {

    public function entrar($usuario,$contrasenia){
        $this->db->where('usuario',$usuario);
        $this->db->where('contrasenia',$contrasenia);
        $this->db->where('estado','1');
        $query = $this->db->get('usuarios');
        
        if($query->num_rows() ==0 ){
            return 0;
        }
        else{
            return 1;
        }

    }

}
