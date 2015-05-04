<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Grupo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->view('modules/foot');
    }

    public function index() {
        $this->leer(1);
    }

    public function leer($estado) {
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $this->load->library('table');
        $sql = $this->Grupo_cuentas_model->leer($estado);

        $i = 0;
        if ($estado == 1) {

            $data['link'] = '<a href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/crear" class="btn btn-success fa fa-file-o fa-lg"> Nuevo Grupo de Cuentas</a></br></br> ' .
                    '<a href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/leer/0" class="btn btn-success fa fa-list-alt fa-lg"> Grupos de cuentas Inactivas</a>' .
                    '<a href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/leer/1" class="btn btn-success fa fa-refresh fa-lg col-lg-offset-6">Recargar</a></br></br>'
                    . '<input type="text" id="valor" class="col-lg-offset-6">'
                    . ' <select id="campo" class="dropdown">'
                    . '<option value="grupo_cuenta">Grupo Cuenta</option>'
                    . '<option value="nivel">Nivel de la Cuenta</option>'
                    . '<option value="nivel_anterior">Nivel Anterior</option>'
                    . '<option value="categoria">Categoria</option>'
                    . '</select>'
                    . ' <button id="buscar" class="btn btn-success">Buscar</button>';
            $encabezados = array('No°', 'Grupo', 'Nivel', 'Nivel Anterior', 'Categoria', 'Edicion', 'Inactivacion');

            while (count($sql) != $i) {
                $id = $sql[$i]['idgrupo_cuenta'];
                unset($sql[$i]['idgrupo_cuenta']);
                array_unshift($sql[$i], $i);
                array_push($sql[$i], '<a href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/modificar/' . $id . '" class="fa fa-pencil fa-fw">Editar</a>');
                array_push($sql[$i], '<a href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/cambiar_estado/' . $id . '/0" class="fa fa-ban fa-fw">Inactivar</a>');

                $i++;
            }
        } else

        if ($estado == 0) {
            $data['link'] = '<a href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/leer/1" class="btn btn-success fa fa-reply-all fa-lg"> Grupos Activos</a>';
            $encabezados = array('No°', 'Grupo', 'Nivel', 'Nivel Anterior', 'Categoria', 'Activacion');

            while (count($sql) != $i) {
                $id = $sql[$i]['idgrupo_cuenta'];
                unset($sql[$i]['idgrupo_cuenta']);
                array_unshift($sql[$i], $i);
                array_push($sql[$i], '<a href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/cambiar_estado/' . $id . '/1" class="fa fa-retweet fa-fw">Activar</a>');

                $i++;
            }
        }

        $estilo = array('table_open' => '<table class="table table-striped table-bordered">');
        $this->table->set_template($estilo);
        $this->table->set_heading($encabezados);
        $data['gruposcuentas'] = $sql;

        $this->load->view('contabilidad/catalogo/grupo/grupo_lista_view', $data);
    }

    public function crear() {
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('grupo_cuenta', 'Grupo', 'required|min_length[4]');

        $nivel = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5');
        $data['nivel'] = $nivel;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $data['nivel_anterior'] = $this->Grupo_cuentas_model->lista_grupo();

        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $data['categoria'] = $this->Categorias_cuentas_model->lista_categoria();


        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {

                $this->Grupo_cuentas_model->agregar();

                $this->leer(1);
            } else {
                $this->load->view('contabilidad/catalogo/grupo/grupo_crea_view', $data);
            }
        } else {

            $this->load->view('contabilidad/catalogo/grupo/grupo_crea_view', $data);
        }
    }

    public function modificar($idgrupo) {
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('grupo_cuenta', 'Grupo', 'required|min_length[4]');
        $data['idgrupo'] = $idgrupo;

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $data['lista_por_id'] = $this->Grupo_cuentas_model->encontrar_por_id($idgrupo);

        $nivel = array('1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5');
        $data['nivel'] = $nivel;

        $data['titulo_superior'] = $this->Grupo_cuentas_model->lista_grupo();

        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $data['categoria'] = $this->Categorias_cuentas_model->lista_categoria();


        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {
                $this->Grupo_cuentas_model->modificar($idgrupo);
                $this->leer(1);
            } else {
                $this->load->view('contabilidad/catalogo/grupo/grupo_edita_view', $data);
            }
        } else {
            $this->load->view('contabilidad/catalogo/grupo/grupo_edita_view', $data);
        }
    }

    public function cambiar_estado($idgrupo, $estado) {
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $this->Grupo_cuentas_model->cambiar_estado($idgrupo, $estado);

        if ($estado == 1) {
            $this->leer(0);
        } elseif ($estado == 0) {
            $this->leer(1);
        }
    }

    public function buscar() {
        $campo = filter_input(INPUT_POST, 'campo');
        $valor = filter_input(INPUT_POST, 'valor');

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');

        if (!empty($campo) && !empty($valor)) {
            $sql = $this->Grupo_cuentas_model->buscar($campo, $valor);
        }if(!empty($campo) && empty($valor)){
            $sql = $this->Grupo_cuentas_model->leer(1);
        }

        $i = 0;

        if (!empty($sql)) {
            echo"<table class='table table-striped table-bordered'>"
            . " <tr>
                                <th>No°</th>
                                <th>Grupo Cuenta</th>
                                <th>Nivel de Cuenta</th>
                                <th>Nivel Anterior de Cuenta</th>
                                <th>Categoria</th>
                                <th>Edicion</th>
                                <th>Inactivacion</th>
                            </tr> ";
            foreach ($sql as $cat) {
                $id = $cat['idgrupo_cuenta'];
                echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cat['grupo_cuenta'] . "</td>
                        <td>" . $cat['nivel'] . "</td>
                        <td>" . $cat['nivel_anterior'] . "</td>
                        <td>" . $cat['categoria'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/categoria/grupo/modificar/' . $id . '" class="fa fa-pencel-o fa-fw">Editar</a>' . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/categoria/grupo/cambiar_estado/' . $id . '/0"  class="fa fa-ban fa-fw">Inactivar</a>' .
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

}

/* Fin del archivo my_controller.php */