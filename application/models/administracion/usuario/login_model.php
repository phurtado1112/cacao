<?php

class Login_Model extends CI_Model {

    public function entrar($usuario,$contrasenia){
        $this->db->select('usuario,contrasenia');
        $this->db->from('usuarios');
        $this->db->where('usuario', $usuario);
        $this->db->where('contrasenia', md5($contrasenia));
        $this->db->where('estado', '1');
        
        $query = $this->db->get();
        
        if($query->num_rows() ==0 ){
            return 0;
        }
        else{
            return 1;
        }

    }

}
