<?php

class Asiento_diario extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        if ($this->session->userdata('loged_in') != true) {
//            exit('<script>alert("no tiene acceso");window.location=("http://localhost/cacao");</script>');
//        }
        $data['titulo'] = 'Crear Asiento de Diario';
    }

    public function index() {
        $data['titulo'] = 'Crear Asiento de Diario';
        $this->load->view('modules/menu/menu_contabilidad', $data);
        $this->load->model('contabilidad/transacciones/asiento_diario/Asiento_diario_model');
        $vista = $this->Asiento_diario_model->asiento_diario_listar();
        $data['asiento_diario'] = $vista;

        $this->load->view('contabilidad/transacciones/asiento_diario/asiento_diario_lista_view', $data);
        $this->load->view('modules/foot/contabilidad/asiento_diario_foot');
    }

    public function asiento_diario_listar($inicio = 0) {
        $data['titulo'] = 'Crear Asiento de Diario';
        $this->load->model('contabilidad/transacciones/asiento_diario/Asiento_diario_model');

//        configuramos la url de la paginacion
        $config['base_url'] = base_url() . 'index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_listar'; //index?
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['cur_page'] = base_url() . 'index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_listar';
        $config['total_rows'] = $this->Asiento_diario_model->asiento_diario_listar_num();
        $config['per_page'] = 15;
        $config['num_links'] = 4;
        $config['uri_segment'] = 6;
        //configuracion de estilo de paginacion 
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';

        ////cargamos la librería con nuestra configuracion
        $this->jquery_pagination->initialize($config);

        //obtemos los valores
        $asiento_diario_query = $this->Asiento_diario_model->asiento_diario_paginacion($inicio, $config['per_page']);

        $paginacion = $this->jquery_pagination->create_links();

        $data['num'] = $inicio;
        $data['consulta_asiento_diario'] = $asiento_diario_query;
        $data['paginacion'] = $paginacion;

        //cargamos nuestra vista
        $this->load->view('contabilidad/transacciones/asiento_diario/asiento_diario_lista_ajax_view', $data);
    }

    public function asiento_diario_crear($id_adr = NULL) {
        $data['titulo'] = 'Crear Asiento de Diario';

        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $idorigen_asiento_diario = array(
            'name' => 'idorigen_asiento_diario',
            'id' => 'idorigen_asiento_diario',
            'class' => 'form-grou',
        );
        $data['idorigen_asiento_diario'] = $idorigen_asiento_diario;

        $data['dias'] = $dias;
        $data['meses'] = $meses;

        $this->load->model('administracion/Origen_asiento_diario_model');
        $lista_origen_asiento_diario = $this->Origen_asiento_diario_model->lista_origen_asiento_diario();

        foreach ($lista_origen_asiento_diario as $lista_oad) {
            $lista_oad_final[$lista_oad['idorigen_asiento_diario']] = $lista_oad['descripcion_origen_asiento_diario'];
        }
        $data['lista_origen_asiento_diario'] = $lista_oad_final;

        $this->load->model('administracion/Tipo_moneda_model');
        $lista_idmoneda = $this->Tipo_moneda_model->lista_moneda();

        foreach ($lista_idmoneda as $idmoneda) {
            $lista_idamoneda_final[$idmoneda['idmoneda']] = $idmoneda['descripcion_moneda'];
        }

        $data['idmoneda'] = $lista_idamoneda_final;

        $lista_idamoneda_para_agregar = $lista_idamoneda_final;
        unset($lista_idamoneda_para_agregar[1]);
        $data['idmoneda_extra'] = $lista_idamoneda_para_agregar;

        ////consultas para AD recurrentes

        if ($id_adr) {
            $this->load->model('contabilidad/transacciones/asiento_diario_recurrente/Asiento_diario_recurrente_model');
            $data['asiento_diario_recurrente'] = $this->Asiento_diario_recurrente_model->ad_recurrente_encontrar_por_id($id_adr);

            $this->load->model('contabilidad/transacciones/asiento_diario_detalle_recurrente/Asiento_diario_detalle_recurrente_model');
            $data['ad_detalle_recurrente'] = $this->Asiento_diario_detalle_recurrente_model->ad_detalle_recurrente_por_id_adr($id_adr);
        } else {
            $data['asiento_diario_recurrente'] = "";
            $data['ad_detalle_recurrente'] = "";
        }

        $this->load->view('modules/menu/menu_contabilidad', $data);
        $this->load->view('contabilidad/transacciones/asiento_diario/asiento_diario_crear_view', $data);
        $this->load->view('modules/pop_up/asiento_diario_cuentas_pop');
        $this->load->view('modules/pop_up/introducir_tasa_cambio_pop', $data);
        $this->load->view('modules/foot/contabilidad/asiento_diario_crear_foot');
    }

    ////////////////funcion para guardar datos////////////////////

    public function asiento_diario_guardar() {
        $this->load->model('contabilidad/transacciones/asiento_diario/Asiento_diario_model');

        $idasiento_diario = filter_input(INPUT_POST, 'idasiento_diario');
        $idorigen_asiento_diario = filter_input(INPUT_POST, 'idorigen_asiento_diario');
        $descripcion_asiento_diario = filter_input(INPUT_POST, 'descripcion_asiento_diario');
        $fecha_creacion = filter_input(INPUT_POST, 'fecha_creacion');
        $fecha_fiscal = filter_input(INPUT_POST, 'fecha_fiscal');
        $usuario_creacion = filter_input(INPUT_POST, 'usuario_creacion');
        $idtasa_cambio = filter_input(INPUT_POST, 'idtasa_cambio');
        $balance_debito_nacional = round(filter_input(INPUT_POST, 'balance_debito_nacional'), 4);
        $balance_credito_nacional = round(filter_input(INPUT_POST, 'balance_credito_nacional'), 4);
        $balance_debito_extranjero = round(filter_input(INPUT_POST, 'balance_debito_extranjero'), 4);
        $balance_credito_extranjero = round(filter_input(INPUT_POST, 'balance_credito_extranjero'), 4);

        $this->Asiento_diario_model->asiento_diario_crear($idasiento_diario, $idorigen_asiento_diario, $descripcion_asiento_diario, $fecha_creacion, $fecha_fiscal, $usuario_creacion, $idtasa_cambio, $balance_debito_nacional, $balance_credito_nacional, $balance_debito_extranjero, $balance_credito_extranjero);

//        echo $idasiento_diario."  ";
//                . "".$idorigen_asiento_diario."  "
//                ." ".$descripcion_asiento_diario."  ".$fecha_creacion."  ".$fecha_fiscal." 
//                ".$usuario_creacion."  ".$idtasa_cambio."  ".$balance_debito_nacional."  ".$balance_credito_nacional."  ".$balance_debito_extranjero."  ".$balance_credito_extranjero;
//        
        $this->load->model('administracion/Configuracion_empresa_model');
        $origen_asiento_diario = filter_input(INPUT_POST, 'origen_asiento_diario');

        if ($origen_asiento_diario === "CG") {
            $campo = "numero_ad_cont";
        } else if ($origen_asiento_diario === "BC") {
            $campo = "numero_ad_bco";
        } else if ($origen_asiento_diario === "CP") {
            $campo = "numero_ad_cp";
        }
//////
        $this->Configuracion_empresa_model->configuracion_empresa_actualizar_origen_ad($campo, $idasiento_diario);
//
        echo $idasiento_diario;
    }

//////////////////////////obtener id_tasa_cambio y tasa cambio por fecha//////////////////////
    public function buscar_tasa_cambio_por_fecha() {
        $fecha_tipo_cambio = filter_input(INPUT_POST, 'fecha_buscada');
        $idmoneda = filter_input(INPUT_POST, 'idmoneda');

        $this->load->model('administracion/Tasa_cambio_model');

        $tasa_encontrada = $this->Tasa_cambio_model->tasa_cambio_encontrar_por_fecha($fecha_tipo_cambio, $idmoneda);
//
        if (count($tasa_encontrada) == 0) {
            echo 'vacio';
        } else {

            echo $tasa_encontrada[0]['tasa_cambio'] . "/" . $tasa_encontrada[0]['idtasa_cambio'];
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    public function asiento_diario_detalle_guardar() {
        $this->load->model('contabilidad/transacciones/asiento_diario_detalle/Asiento_diario_detalle_model');

        $idasiento_diario = filter_input(INPUT_POST, 'idasiento_diario');
        $numero_transacciones = filter_input(INPUT_POST, 'numero_transacciones');
        $idcuenta_contable = filter_input(INPUT_POST, 'idcuenta_contable');
        $naturaleza_cuenta_contable = filter_input(INPUT_POST, 'naturaleza_cuenta_contable');
        $monto_moneda_nacional = filter_input(INPUT_POST, 'monto_moneda_nacional');
        $monto_moneda_extranjera = filter_input(INPUT_POST, 'monto_moneda_extranjera');

//        echo $idasiento_diario. "  " . $numero_transacciones . "  " .$idcuenta_contable . "  " .$tipo_transaccion . "  " . $monto_moneda_nacional . "  " . $monto_moneda_extranjera;

        $this->Asiento_diario_detalle_model->asiento_diario_detalle_crear($idasiento_diario, $numero_transacciones, $idcuenta_contable, $naturaleza_cuenta_contable, $monto_moneda_nacional, $monto_moneda_extranjera
        );
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

    public function asiento_diario_numero() {
        $origen = filter_input(INPUT_POST, 'origen_asiento_diario');

        $this->load->model('administracion/Configuracion_empresa_model');

        if ($origen === "CG") {
            $num_cg = $this->Configuracion_empresa_model->configuracion_empresa_num_ad_cont();
            $ultimo_num_cg = end($num_cg);
            echo $ultimo_num_cg['numero_ad_cont'];
        } else if ($origen === "BC") {
            $num_bc = $this->Configuracion_empresa_model->configuracion_empresa_num_ad_bco();
            $ultimo_num_bc = end($num_bc);
            echo $ultimo_num_bc['numero_ad_bco'];
        } else if ($origen === "CP") {
            $num_cp = $this->Configuracion_empresa_model->configuracion_empresa_num_ad_cp();
            $ultimo_num_cp = end($num_cp);
            echo $ultimo_num_cp['numero_ad_cp'];
        }
    }

    ////////////////// modificar//////////////////////////
    public function asiento_diario_modificar($id_ad) {
        $data['titulo'] = 'Crear Asiento de Diario';

        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $idorigen_asiento_diario = array(
            'name' => 'idorigen_asiento_diario',
            'id' => 'idorigen_asiento_diario',
            'class' => 'form-group',
        );
        $data['idorigen_asiento_diario'] = $idorigen_asiento_diario;

        $data['dias'] = $dias;
        $data['meses'] = $meses;

        $this->load->model('contabilidad/transacciones/asiento_diario/Asiento_diario_model');
        $data['asiento_diario'] = $this->Asiento_diario_model->asiento_diario_encontrar_por_id_ad($id_ad);

        $this->load->model('contabilidad/transacciones/asiento_diario_detalle/Asiento_diario_detalle_model');
        $data['ad_detalle'] = $this->Asiento_diario_detalle_model->asiento_diario_detalle_por_id_ad($id_ad);

        $this->load->model('administracion/Origen_asiento_diario_model');
        $lista_origen_asiento_diario = $this->Origen_asiento_diario_model->lista_origen_asiento_diario();

        foreach ($lista_origen_asiento_diario as $lista_oad) {
            $lista_oad_final[$lista_oad['idorigen_asiento_diario']] = $lista_oad['descripcion_origen_asiento_diario'];
        }
        $data['lista_origen_asiento_diario'] = $lista_oad_final;

        $this->load->model('administracion/Tipo_moneda_model');
        $lista_idmoneda = $this->Tipo_moneda_model->lista_moneda();

        foreach ($lista_idmoneda as $idmoneda) {
            $lista_idamoneda_final[$idmoneda['idmoneda']] = $idmoneda['descripcion_moneda'];
        }

        $data['idmoneda'] = $lista_idamoneda_final;

        $lista_idamoneda_para_agregar = $lista_idamoneda_final;
        unset($lista_idamoneda_para_agregar[1]);
        $data['idmoneda_extra'] = $lista_idamoneda_para_agregar;

        $this->load->view('modules/menu/menu_contabilidad', $data);
        $this->load->view('contabilidad/transacciones/asiento_diario/asiento_diario_edita_view', $data);
        $this->load->view('modules/pop_up/asiento_diario_cuentas_pop');
        $this->load->view('modules/pop_up/introducir_tasa_cambio_pop', $data);
        $this->load->view('modules/foot/contabilidad/asiento_diario_editar_foot');
    }

    public function cuenta_por_id() {
        $idcatalogo = filter_input(INPUT_POST, 'idcuenta_contable');

        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $lista_por_id = $this->Catalogo_cuentas_model->encontrar_por_id($idcatalogo);

        print $lista_por_id[0]['cuenta'];
    }

    public function asiento_diario_editar() {
        $this->load->model('contabilidad/transacciones/asiento_diario/Asiento_diario_model');

        $idasiento_diario = filter_input(INPUT_POST, 'idasiento_diario');
        $descripcion_asiento_diario = filter_input(INPUT_POST, 'descripcion_asiento_diario');
        $fecha_edicion = filter_input(INPUT_POST, 'fecha_edicion');
        $fecha_fiscal = filter_input(INPUT_POST, 'fecha_fiscal');
        $usuario_edicion = filter_input(INPUT_POST, 'usuario_edicion');
        $idtasa_cambio = filter_input(INPUT_POST, 'idtasa_cambio');
        $balance_debito_nacional = round(filter_input(INPUT_POST, 'balance_debito_nacional'), 4);
        $balance_credito_nacional = round(filter_input(INPUT_POST, 'balance_credito_nacional'), 4);
        $balance_debito_extranjero = round(filter_input(INPUT_POST, 'balance_debito_extranjero'), 4);
        $balance_credito_extranjero = round(filter_input(INPUT_POST, 'balance_credito_extranjero'), 4);

//        echo $idasiento_diario."  ".$descripcion_asiento_diario."  ".$fecha_edicion."  ".$fecha_fiscal."  ".$usuario_edicion."  ".$idtasa_cambio."  ".$balance_debito_nacional."  ".$balance_credito_nacional."  ".$balance_credito_extranjero."  ".$balance_debito_extranjero;

        $this->Asiento_diario_model->asiento_diario_modificar($idasiento_diario, $descripcion_asiento_diario, $fecha_edicion, $fecha_fiscal, $usuario_edicion, $idtasa_cambio, $balance_debito_nacional, $balance_credito_nacional, $balance_debito_extranjero, $balance_credito_extranjero
        );
//        
    }

    public function asiento_diario_detalle_editar() {
        $this->load->model('contabilidad/transacciones/asiento_diario_detalle/Asiento_diario_detalle_model');

        $idasiento_diario = filter_input(INPUT_POST, 'idasiento_diario');
        $numero_transacciones = filter_input(INPUT_POST, 'numero_transacciones');
        $idcuenta_contable = filter_input(INPUT_POST, 'idcuenta_contable');
        $tipo_transaccion = filter_input(INPUT_POST, 'naturaleza_cuenta_contable');
        $monto_moneda_nacional = filter_input(INPUT_POST, 'monto_moneda_nacional');
        $monto_moneda_extranjera = filter_input(INPUT_POST, 'monto_moneda_extranjera');


//        echo $idasiento_diario."--".$numero_transacciones."--".$idcuenta_contable."--".$tipo_transaccion."--".$monto_moneda_nacional."--". $monto_moneda_extranjera;

        $this->Asiento_diario_detalle_model->asiento_diario_detalle_modificar($idasiento_diario, $numero_transacciones, $idcuenta_contable, $tipo_transaccion, $monto_moneda_nacional, $monto_moneda_extranjera);
//        
    }

    public function asiento_diario_detalle_eliminar() {
        $this->load->model('contabilidad/transacciones/asiento_diario_detalle/Asiento_diario_detalle_model');

        $idasiento_diario = filter_input(INPUT_POST, 'idasiento_diario');
        $numero_transacciones = filter_input(INPUT_POST, 'numero_transacciones');

        $this->Asiento_diario_detalle_model->asiento_diario_detalle_eliminar($numero_transacciones, $idasiento_diario);
    }

    public function asiento_diario_eliminar($idasiento_diario) {
        $this->load->model('contabilidad/transacciones/asiento_diario/Asiento_diario_model');
        $this->Asiento_diario_model->asiento_diario_eliminar($idasiento_diario);


        header('Location:' . base_url() . 'index.php/contabilidad/transacciones/asiento_diario/asiento_diario/index');
    }

    public function tasa_cambio_agregar() {
        $this->load->model('administracion/Tasa_cambio_model');

        $idmoneda = filter_input(INPUT_POST, 'idmoneda_agregar');
        $fecha_tipo_cambio = filter_input(INPUT_POST, 'fecha_tipo_cambio');
        $tasa_cambio = filter_input(INPUT_POST, 'tasa_cambio');

        $this->Tasa_cambio_model->tasa_cambio_agregar($idmoneda, $fecha_tipo_cambio, $tasa_cambio);
    }
    
    public function asiento_diario_mayorizar($idasiento_diario) {
        $this->load->model('contabilidad/transacciones/asiento_mayor/Asiento_mayor_model');
        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        
        $this->Asiento_mayor_model->mayorizar_asiento_diario($idasiento_diario);
        $this->Asiento_mayor_model->mayorizar_asiento_diario_detalle($idasiento_diario);
        
        $lista_cuentas_mayor_detalle = $this->Asiento_mayor_model->leer_cuentas_mayor_detalle($idasiento_diario);
        $fecha_asiento_mayor = $this->Asiento_mayor_model->encontrar_fecha_asiento_mayor($idasiento_diario);
        $anio_fiscal = $this->Asiento_mayor_model->encontrar_anio_fiscal_asiento_mayor($fecha_asiento_mayor);
        $lista_cuentas_saldos = $this->Asiento_mayor_model->buscar_cuenta_contable_saldos($anio_fiscal);
        
        foreach ($lista_cuentas_mayor_detalle as $cuenta_mayor_detalle) {
            if(!in_array($cuenta_mayor_detalle,$lista_cuentas_saldos)) {
                $cuenta_mayor_det = $cuenta_mayor_detalle['idcuenta_contable'];
                $this->Asiento_mayor_model->agregar_cuenta_contable($cuenta_mayor_det, $anio_fiscal);
            }
        }
                
        $periodo_cuenta = $this->Asiento_mayor_model->encontrar_periodo_fiscal_asiento_mayor($fecha_asiento_mayor,$anio_fiscal);
        $lista_montos = $this->Asiento_mayor_model->sumar_montos_asiento_mayor_detalle($idasiento_diario);
        
        foreach ($lista_montos as $montos) {
            if($montos['idcuenta_contable']!=null) {
                $monto = $montos['monto_local'];
                $idcuent = $montos['idcuenta_contable'];
                $this->Asiento_mayor_model->mayorizar_saldos($periodo_cuenta,$monto,$idcuent,$anio_fiscal);
            }
        }
        
        $this->Asiento_mayor_model->eliminar_asiento_diario($idasiento_diario);
        
        header('Location:' . base_url() . 'index.php/contabilidad/transacciones/asiento_diario/asiento_diario/index');
    }
}