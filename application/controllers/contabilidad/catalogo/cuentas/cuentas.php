<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cuentas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->view('modules/foot');
    }

    public function index() {
        $this->leer(1);
    }

    public function leer($estado) {
        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $this->load->library('table');
        $sql = $this->Catalogo_cuentas_model->leer($estado);

        $i = 0;
        if ($estado == 1) {

            $data['link'] = '<a href="' . base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/crear" class="btn btn-success fa fa-file-o fa-lg"> Nueva Cuenta Contable</a></br></br> ' .
                    '<a href="' . base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/leer/0" class="btn btn-success fa fa-list-alt fa-lg"> Cuentas Inactivas</a>' .
                    '<a href="' . base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/leer/1" class="btn btn-success fa fa-refresh fa-lg col-lg-offset-7">Recargar</a></br></br>'
                    . '<input type="text" id="valor" class="col-lg-offset-6">'
                    . '<select id="campo" class="dropdown">'
                    . '<option value="cuenta">Cuentas</option>'
                    . '<option value="naturaleza">Naturaleza de Cuenta</option>'
                    . '<option value="grupo_cuenta">Grupo de cuentas</option>'
                    . '</select>'
                    . '<button id="buscar" class="btn btn-success">Buscar</button>';
            $encabezados = array('No°', 'Cuenta', 'Naturaleza de cuenta', 'Grupo de cuentas', 'Edicion', 'Inactivacion');

            while (count($sql) != $i) {
                $id = $sql[$i]['idcuenta_contable'];
                unset($sql[$i]['idcuenta_contable']);
                array_unshift($sql[$i], $i);
                array_push($sql[$i], '<a href="' . base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/modificar/' . $id . '" class="fa fa-pencil fa-fw">Editar</a>');
                array_push($sql[$i], '<a href="' . base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/cambiar_estado/' . $id . '/0" class="fa fa-ban fa-fw">Inactivar</a>');

                $i++;
            }
        } else

        if ($estado == 0) {
            $data['link'] = '<a href="' . base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/leer/1" class="btn btn-success fa fa-list-alt fa-lg"> Cuentas Activas</a>';
            $encabezados = array('No°', 'Cuenta', 'Naturaleza de cuenta', 'Grupo de cuentas', 'Activacion');

            while (count($sql) != $i) {
                $id = $sql[$i]['idcuenta_contable'];
                unset($sql[$i]['idcuenta_contable']);
                array_unshift($sql[$i], $i);
                array_push($sql[$i], '<a href="' . base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/cambiar_estado/' . $id . '/1" class="fa fa-retweet"> Activar</a>');

                $i++;
            }
        }

        $estilo = array('table_open' => '<table class="table table-striped table-bordered">');
        $this->table->set_template($estilo);
        $this->table->set_heading($encabezados);
        $data['cuentas'] = $sql;

        $this->load->view('contabilidad/catalogo/cuentas/cuentas_lista_view', $data);
    }

    public function buscar() {
        $campo = filter_input(INPUT_POST, 'campo');
        $valor = filter_input(INPUT_POST, 'valor');

        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');

        if (!empty($campo) && !empty($valor)) {
            $sql = $this->Catalogo_cuentas_model->buscar($campo, $valor);
        }if(!empty($campo) && empty($valor)){
            $sql = $this->Catalogo_cuentas_model->leer(1);
        }

        $i = 0;

        if (!empty($sql)) {
            echo"<table class='table table-striped table-bordered'>"
            . " <tr>
                                <th>No°</th>
                                <th>Cuenta</th>
                                <th>Naturaleza de Cuenta</th>
                                <th>Grupo de Cuenta</th>
                                <th>Edicion</th>
                                <th>Inactivacion</th>
                            </tr> ";
            foreach ($sql as $cat) {
                $id = $cat['idcuenta_contable'];
                echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cat['cuenta'] . "</td>
                        <td>" . $cat['naturaleza'] . "</td>
                        <td>" . $cat['grupo_cuenta'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/categoria/cuentas/modificar/' . $id . '"class="fa fa-pencil fa-fw">Editar</a>' . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/categoria/cuentas/cambiar_estado/' . $id . '/0"class="fa fa-ban fa-fw">Inactivar</a>' .
                "</tr>";

                $i++;
            }
            echo "</table>";
        } else {
            ?>

            <?php

            echo '<h4>No se encontraron categorias de cuentas</h4>';
        }
    }

    public function crear() {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cuenta_contable', 'Cuenta contable', 'required|min_length[3]');

        $tipocuenta = array('A' => 'Acreedora', 'D' => 'Deudora');
        $data['tipocuenta'] = $tipocuenta;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $data['idgrupocuenta'] = $this->Grupo_cuentas_model->lista_grupo();


        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {

                $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
                $this->Catalogo_cuentas_model->agregar();

                $this->leer(1);
            } else {
                $this->load->view('contabilidad/catalogo/cuentas/cuentas_crea_view', $data);
            }
        } else {

            $this->load->view('contabilidad/catalogo/cuentas/cuentas_crea_view', $data);
        }
    }

    public function modificar($idcatalogo) {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('cuenta_contable', 'Categoria', 'required|min_length[4]');
        $this->form_validation->set_rules('cuenta_contable', 'Categoria', 'required|min_length[4]');

        $data['idcatalogo'] = $idcatalogo;

        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $data['lista_por_id'] = $this->Catalogo_cuentas_model->encontrar_por_id($idcatalogo);

        $tipocuenta = array('A' => 'Acreedora', 'D' => 'Deudora');
        $data['tipocuenta'] = $tipocuenta;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $data['idgrupocuenta'] = $this->Grupo_cuentas_model->lista_grupo();

        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {
                $this->load->model('contabilidad/catalogo/categoria/Catalogo_cuentas_model');
                $this->Catalogo_cuentas_model->modificar($idcatalogo);
                $this->leer(1);
            } else {
                $this->load->view('contabilidad/catalogo/cuentas/cuentas_edita_view', $data);
            }
        } else {
            $this->load->view('contabilidad/catalogo/cuentas/cuentas_edita_view', $data);
        }
    }

    public function cambiar_estado($idcategorias, $estado) {
        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $this->Catalogo_cuentas_model->cambiar_estado($idcategorias, $estado);

        if ($estado == 1) {
            $this->leer(0);
        } elseif ($estado == 0) {
            $this->leer(1);
        }
    }

}

/*Fin del archivo my_controller.php*/