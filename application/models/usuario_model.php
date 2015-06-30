<?php if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class Usuario_Model extends CI_Model{
    
    public function login_user($usuario,$contrasenia)
	{
		$this->db->where('usuario',$usuario);
		$this->db->where('contrasenia',$contrasenia);
		$query = $this->db->get('usuarios');
                
		if($query->num_rows() == 1)
		{
			return $query->row();
		}else{
			$this->session->set_flashdata('usuario_incorrecto','Los datos introducidos son incorrectos');
			redirect(base_url().'cacao','refresh');
		}
	}
}





