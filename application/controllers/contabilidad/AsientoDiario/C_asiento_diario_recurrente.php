<?php

if ( ! defined('BASEPATH')) {exit('No direct script access allowed');}

class C_asiento_diario_recurrente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->view('modules/menu/menu_contabilidad');
    }

    public function index() {
        $this->load->view('contabilidad/AsientoDiario/V_listar_asiento_diario_recurrente');
    }

    public function crear() {
        $this->load->model('contabilidad/AsientoDiario/M_Asiento_Diario_Recurrente');
        $origen['idorigen_asiento_diario'] = $this->M_Asiento_Diario_Recurrente->lista_dropdown();
        $origen['idmoneda'] = $this->M_Asiento_Diario_Recurrente->lista_moneda();
        $origen['idtasa_cambio'] = $this->M_Asiento_Diario_Recurrente->lista_cambio();
        $origen['nivel'] = $this->M_Asiento_Diario_Recurrente->lista_cuenta_nivel();
        $origen['grupo_cuenta'] = $this->M_Asiento_Diario_Recurrente->lista_cuenta_nombre();
        $this->load->view('contabilidad/AsientoDiario/V_crear_asiento_diario_recurrente', $origen);
    }
    
    public function campos_dinamicos() {
        $origen['nivel'] = $this->M_Asiento_Diario_Recurrente->lista_cuenta_nivel();
        $origen['grupo_cuenta'] = $this->M_Asiento_Diario_Recurrente->lista_cuenta_nombre();
        
        echo"<tr>             
                <td><?php echo form_dropdown('nivel',".$origen['nivel']."); ?></td>
                <td><?php echo form_dropdown('grupo_cuenta',".$origen['grupo_cuenta']."); ?></td>
            </tr>";
    }
       

}
