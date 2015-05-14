<?php

class Asiento_diario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $data['titulo'] = 'Crear Asiento de Diario';
        $this->load->view('modules/menu/menu_contabilidad', $data);
    }

    public function index() {

        $this->asiento_diario_listar();
    }

    public function asiento_diario_listar() {
        $this->load->model('contabilidad/transacciones/asiento_diario/Asiento_diario_model');
        $vista = $this->Asiento_diario_model->listar();
        $data['asiento_diario'] = $vista;

        $this->load->view('contabilidad/transacciones/asiento_diario/asiento_diario_lista_view', $data);
    }

    public function asiento_diario_crear() {

        $tipo_de_cambio = array(//idtasa_cambio
            'name' => 'tipo_de_cambio',
            'id' => 'tipo_de_cambio',
            'maxlength' => '10',
            'size' => '15',
            'value' => '',
            'class' => 'form-group',
            'placeholder' => 'Tipo de Cambio',
        );
        $moneda = array(//idtasa_cambio
            'Opcion1' => 'Opcion1',
            'Opcion2' => 'Opcion2',
            'Opcion3' => 'Opcion3',
        );
        $origen = array(//idorigen_asiento_diario   
            'Opcion1' => 'Opcion1',
            'Opcion2' => 'Opcion2',
            'Opcion3' => 'Opcion3',
        );
        $numero_transaccion = array(//numero_transaccion
            'name' => 'numero_transaccion',
            'id' => 'numero_transaccion',
            'maxlength' => '20',
            'size' => '10',
            'value' => '',
            'class' => 'form-group',
            'placeholder' => 'No. Linea',
        );
        $descripcion_asiento_diario = array(//descripcion_asiento_diario
            'name' => 'descripcion_asiento_diario',
            'id' => 'descripcion_asiento_diario',
            'maxlength' => '120',
            'size' => '40',
            'value' => '',
            'class' => 'form-group',
            'placeholder' => 'Descripcion del asiento',
        );
        $no_cuenta_contable = array(//idcuenta_contable
            'name' => 'no_cuenta_contable',
            'id' => 'no_cuenta_contable',
            'maxlength' => '20',
            'size' => '15',
            'value' => '',
            'class' => 'form-group',
            'placeholder' => 'No. Cta Contable',
        );
        $descripcion_cuenta_contable = array(//descripcion_cuenta_contable
            'name' => 'descripcion_cuenta_contable',
            'id' => 'descripcion_cuenta_contable/0',
            'maxlength' => '120',
            'size' => '50',
            'value' => '',
            'class' => 'form-group descripcion',
            'placeholder' => 'Descripcion Cta. Contable',
        );
        $balance_credito = array(//balance_credito
            'name' => 'balance_credito',
            'id' => 'balance_credito/0',
            'maxlength' => '20',
            'size' => '10',
            'value' => '',
            'class' => 'form-group',
            'placeholder' => 'Crédito',
        );

        $balance_debito = array(//balance_debito
            'name' => 'balance_debito',
            'id' => 'balance_debito/0',
            'maxlength' => '20',
            'size' => '10',
            'value' => '',
            'class' => 'form-group',
            'placeholder' => 'Débito',
        );
        $total_credito = array(//total_credito
            'name' => 'total_credito',
            'id' => 'total_credito',
            'maxlength' => '20',
            'size' => '10',
            'value' => '',
            'class' => 'form-group',
            'placeholder' => 'Crédito',
        );
        $total_debito = array(//total_debito
            'name' => 'total_debito',
            'id' => 'total_debito',
            'maxlength' => '20',
            'size' => '10',
            'value' => '',
            'class' => 'form-group',
            'placeholder' => 'Débito',
        );
        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $data['total_debito'] = $total_debito;
        $data['total_credito'] = $total_credito;
        $data['balance_debito'] = $balance_debito;
        $data['balance_credito'] = $balance_credito;
        $data['descripcion_cuenta_contable'] = $descripcion_cuenta_contable;
        $data['no_cuenta_contable'] = $no_cuenta_contable;
        $data['descripcion_asiento_diario'] = $descripcion_asiento_diario;
        $data['numero_transaccion'] = $numero_transaccion;
        $data['$origen'] = $origen;
        $data['moneda'] = $moneda;
        $data['tipo_de_cambio'] = $tipo_de_cambio;

        $data['dias'] = $dias;
        $data['meses'] = $meses;

        $this->load->model('contabilidad/transacciones/asiento_diario/Origen_asiento_diario_model');
        $data['idorigen_asiento_diario'] = $this->Origen_asiento_diario_model->lista_origen_asiento_diario();

        $this->load->model('contabilidad/transacciones/asiento_diario/Tipo_moneda_model');
        $data['idmoneda'] = $this->Tipo_moneda_model->lista_moneda();

        $this->load->model('contabilidad/transacciones/asiento_diario/Tasa_cambio_model');
        $dato = $this->Tasa_cambio_model->lista_tasa_cambio();
        $final = end($dato);
        $data['idtasa_cambio'] = $final;


        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {
                $this->load->model('contabilidad/transacciones/asiento_diario/Origen_asiento_diario_model');
                $this->Origen_asiento_diario_model->crear();

                $this->listar();
            } else {
                $this->load->view('contabilidad/transacciones/asiento_diario/asiento_diario_crear_view', $data);
            }
        } else {
            $this->load->view('contabilidad/transacciones/asiento_diario/asiento_diario_crear_view', $data);
        }

        $this->load->view('modules/pop_up/asiento_diario_cuentas_pop');
        $this->load->view('modules/foot/contabilidad/asiento_diario_foot');
    }

    ////////////////////////////////////////////////////////////////////////////

    public function asiento_diario_cuentas_buscar($inicio = 0) {
        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');

        $campo = filter_input(INPUT_POST, 'campo');
        $valor = filter_input(INPUT_POST, 'valor');

        //configuramos la url de la paginacion
        $config['base_url'] = base_url() . 'index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_cuentas_buscar'; //index?
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['cur_page'] = base_url() . 'index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_cuentas_buscar';
        $config['total_rows'] = $this->Catalogo_cuentas_model->numero_cuentas_buscadas($campo, $valor);
        $config['per_page'] = 10;
        $config['num_links'] = 4;
        $config['additional_param'] = "{'campo': '" . $campo . "','valor': '" . $valor . "'}";
        $config['uri_segment'] = 6;
        //configuracion de estilo de paginacion 
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        //cargamos la librería con nuestra configuracion
        $this->jquery_pagination->initialize($config);


        //obtemos los valores
        $paginacion = $this->jquery_pagination->create_links();

        if (!empty($campo) && !empty($valor)) {
            $cuentas_query = $this->Catalogo_cuentas_model->catalogo_buscar($campo, $valor, $inicio, $config['per_page']);
        } else if (!empty($campo) && empty($valor)) {
            $cuentas_query = $this->Catalogo_cuentas_model->catalogo_cuentas_paginacion(1, $inicio, $config['per_page']);
        }

        $data['num'] = $inicio;
        $data['consulta_cuentas'] = $cuentas_query;
        $data['paginacion'] = $paginacion;

        $this->uri->segment(6);
        //cargamos nuestra vista
        $this->load->view('contabilidad/transacciones/asiento_diario/asiento_diario_cuentas_ajax_view', $data);
    }

    public function asiento_diario_modificar($idasiento_diario) {
        $this->load->view('modules/menu/menu_contabilidad');
        $this->load->helper('form');
        $this->load->library('form_validation');
        //$this->form_validation->set_rules('categoria_cuenta','Categoria','required|min_length[4]');

        $data['$idasiento_diario'] = $idasiento_diario;

        $this->load->model('AD/Origen_asiento_diario');
        $data['idorigen_asiento_diario'] = $this->Origen_asiento_diario->lista_dropdown();

        $this->load->model('AD/Tasa_cambio');
        $data['idtasa_cambio'] = $this->Tasa_cambio->lista_dropdown();

        $this->load->model('AD/Tipo_moneda');
        $data['idmoneda'] = $this->Tipo_moneda->lista_dropdown();

        $this->load->model('AD/Ad');
        $data['lista_por_id'] = $this->Ad->encontrar_por_id($idasiento_diario);


        if ($this->input->post()) {

            if ($this->form_validation->run() == TRUE) {
                $this->load->model('AD/Ad');
                $this->Ad->modificar($idasiento_diario);
                $this->leer(1);
            } else {
                $this->load->view('AD/v_editar_ad', $data);
            }
        } else {
            $this->load->view('AD/v_editar_ad', $data);
        }
    }

}
