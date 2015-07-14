<?php

class Asiento_diario_recurrente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('loged_in') != true) {
            exit('<script>alert("no tiene acceso");window.location=("http://localhost/cacao");</script>');
        }
        $data['titulo'] = 'Crear Asiento de Diario Recurrente';
    }

    public function index() {
        $data['titulo'] = 'Crear Asiento de Diario Recurrente';
        $this->load->view('modules/menu/menu_contabilidad', $data);
        $this->load->model('contabilidad/transacciones/asiento_diario_recurrente/Asiento_diario_recurrente_model');
        $vista = $this->Asiento_diario_recurrente_model->ad_recurrente_listar();
        $data['asiento_diario_recurrente'] = $vista;

        $this->load->view('contabilidad/transacciones/asiento_diario_recurrente/ad_recurrente_lista_view', $data);
        $this->load->view('modules/foot/contabilidad/ad_recurrente_foot');
    }

    public function asiento_diario_recurrente_listar($inicio = 0) {
        $data['titulo'] = 'Crear Asiento de Diario Recurrente';
        $this->load->model('contabilidad/transacciones/asiento_diario_recurrente/Asiento_diario_recurrente_model');

        //configuramos la url de la paginacion
        $config['base_url'] = base_url() . 'index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/asiento_diario_recurrente_listar'; 
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['cur_page'] = base_url() . 'index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/asiento_diario_recurrente_listar';
        $config['total_rows'] = $this->Asiento_diario_recurrente_model->ad_recurrente_listar_num();
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
        //cargamos la librería con nuestra configuracion
        $this->jquery_pagination->initialize($config);
        
        //obtemos los valores
        $asiento_diario_query = $this->Asiento_diario_recurrente_model->ad_recurrente_paginacion($inicio, $config['per_page']);

        $paginacion = $this->jquery_pagination->create_links();

        $data['num'] = $inicio;
        $data['consulta_ad_recurrente'] = $asiento_diario_query;
        $data['paginacion'] = $paginacion;
//        //cargamos nuestra vista
        $this->load->view('contabilidad/transacciones/asiento_diario_recurrente/ad_recurrente_lista_ajax_view', $data);
    }

    public function ad_recurrente_crear() {
        $data['titulo'] = 'Crear Asiento de Diario Recurrente';

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
        $this->load->view('contabilidad/transacciones/asiento_diario_recurrente/ad_recurrente_crear_view', $data);
        $this->load->view('modules/pop_up/asiento_diario_cuentas_pop');
        $this->load->view('modules/pop_up/introducir_tasa_cambio_pop');
        $this->load->view('modules/foot/contabilidad/ad_recurrente_crear_foot');
    }

    ////////////////funcion para guardar datos////////////////////

    public function ad_recurrente_guardar() {
        $this->load->model('contabilidad/transacciones/asiento_diario_recurrente/Asiento_diario_recurrente_model');

        $idorigen_asiento_diario = filter_input(INPUT_POST, 'idorigen_asiento_diario');
        $descripcion_asiento_diario = filter_input(INPUT_POST, 'descripcion_asiento_diario');
        $fecha_creacion = filter_input(INPUT_POST, 'fecha_creacion');
        $usuario_creacion = filter_input(INPUT_POST, 'usuario_creacion');
        $idmoneda = filter_input(INPUT_POST, 'idmoneda');
        $balance_debito = filter_input(INPUT_POST, 'balance_debito');
        $balance_credito = filter_input(INPUT_POST, 'balance_credito');
       
//        echo $idorigen_asiento_diario."  ".$descripcion_asiento_diario."  ".$fecha_creacion."  ".$usuario_creacion."  ".$idmoneda."  ".$balance_debito."  ".$balance_credito;

        $this->Asiento_diario_recurrente_model->ad_recurrente_crear( $idorigen_asiento_diario, $descripcion_asiento_diario, $fecha_creacion, $usuario_creacion, $idmoneda, $balance_debito, $balance_credito);

        $dato = $this->Asiento_diario_recurrente_model->volver_id_ad_recurrente();
        $final = end($dato);
        echo $final['idasiento_diario_recurrente'];
    }

//////////////////////////funcion para cambiar fecha y tasa cambio//////////////////////
    public function buscar_fecha() {

        $fecha_tipo_cambio = filter_input(INPUT_POST, 'fecha_buscada');
        $this->load->model('contabilidad/transacciones/asiento_diario/Tasa_cambio_model');
        $fecha_encontrada = $this->Tasa_cambio_model->tasa_cambio_encontrar_por_fecha($fecha_tipo_cambio);
        if (count($fecha_encontrada) == 0) {
            echo 'vacio';
        } else {

            echo $fecha_encontrada[0]['tasa_cambio'] . "/" . $fecha_encontrada[0]['idtasa_cambio'];
        }
    }

    ////////////////////////////////////////////////////////////////////////////

    public function ad_detalle_recurrente_guardar() {
        $this->load->model('contabilidad/transacciones/asiento_diario_detalle_recurrente/Asiento_diario_detalle_recurrente_model');

        $idasiento_diario_recurrente = filter_input(INPUT_POST, 'idasiento_diario');
        $numero_transaccion = filter_input(INPUT_POST, 'numero_transaccion');
        $idcuenta_contable = filter_input(INPUT_POST, 'idcuenta_contable');
        $tipo_transaccion = filter_input(INPUT_POST, 'tipo_transaccion');
        $monto_transaccion = filter_input(INPUT_POST, 'monto_transaccion');

//        echo $idasiento_diario_recurrente. "  " . $numero_transaccion . "  " .$idcuenta_contable . "  " .$tipo_transaccion . "  " .$monto_transaccion;

        $this->Asiento_diario_detalle_recurrente_model->ad_detalle_recurrente_crear($idasiento_diario_recurrente, $numero_transaccion, $idcuenta_contable, $tipo_transaccion, $monto_transaccion);
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


    ////////////////// modificar//////////////////////////
    public function ad_recurrente_modificar($id_adr) {
        $data['titulo'] = 'Crear Asiento de Diario';

        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $idorigen_asiento_diario = array(
            'name' => 'idorigen_asiento_diario',
            'id' => 'idorigen_asiento_diario',
            'class' => 'form-group form-control"',
            "style" => "width:80px; height:30px;"
        );
        $data['idorigen_asiento_diario'] = $idorigen_asiento_diario;
        
        $tipo_moneda = array(
            'name' => 'idmoneda',
            'id' => 'idmoneda',
            'class' => 'form-group form-control"',
            "style" => "width:110px; height:30px;"
        );
        $data['tipo_moneda'] = $tipo_moneda;

        $data['dias'] = $dias;
        $data['meses'] = $meses;

        $this->load->model('contabilidad/transacciones/asiento_diario_recurrente/Asiento_diario_recurrente_model');
        $data['asiento_diario'] = $this->Asiento_diario_recurrente_model->ad_recurrente_encontrar_por_id($id_adr);
        
        $this->load->model('contabilidad/transacciones/asiento_diario_detalle_recurrente/Asiento_diario_detalle_recurrente_model');
        $data['ad_detalle'] = $this->Asiento_diario_detalle_recurrente_model->ad_detalle_recurrente_por_id_adr($id_adr);

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
        $this->load->view('contabilidad/transacciones/asiento_diario_recurrente/ad_recurrente_edita_view', $data);
        $this->load->view('modules/pop_up/asiento_diario_cuentas_pop');
        $this->load->view('modules/foot/contabilidad/ad_recurrente_editar_foot');
    }

    public function cuenta_por_id() {
        $idcatalogo = filter_input(INPUT_POST, 'idcuenta_contable');

        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $lista_por_id = $this->Catalogo_cuentas_model->encontrar_por_id($idcatalogo);

        print $lista_por_id[0]['cuenta'];
    }

    public function ad_recurrente_editar() {
        $this->load->model('contabilidad/transacciones/asiento_diario_recurrente/Asiento_diario_recurrente_model');

        $id_adr = filter_input(INPUT_POST, 'id_ad_recurrente');
        $descripcion_asiento_diario = filter_input(INPUT_POST, 'descripcion_asiento_diario');
        $fecha_edicion = filter_input(INPUT_POST, 'fecha_edicion');
        $usuario_edicion = filter_input(INPUT_POST, 'usuario_edicion');
        $idtasa_cambio = filter_input(INPUT_POST, 'idtasa_cambio');
        $balance_debito = filter_input(INPUT_POST, 'balance_debito');
        $balance_credito = filter_input(INPUT_POST, 'balance_credito');
        $idorigen_asiento_diario = filter_input(INPUT_POST, 'origen_asiento_diario');
        

//        echo $usuario_edicion." ".$fecha_edicion." ".$idorigen_asiento_diario."  ".$descripcion_asiento_diario."  ".$idtasa_cambio."  ".$balance_debito."  ".$balance_credito;

        $this->Asiento_diario_recurrente_model->ad_recurrente_modificar($id_adr, $descripcion_asiento_diario, $fecha_edicion, $usuario_edicion, $idtasa_cambio, $balance_debito, $balance_credito,$idorigen_asiento_diario);
//        
    }

    public function ad_detalle_recurrente_editar() {
        $this->load->model('contabilidad/transacciones/asiento_diario_detalle_recurrente/Asiento_diario_detalle_recurrente_model');
        
        $idasiento_diario = filter_input(INPUT_POST, 'idasiento_diario');
        $numero_transacciones = filter_input(INPUT_POST, 'numero_transacciones');
        $idcuenta_contable = filter_input(INPUT_POST, 'idcuenta_contable');
        $tipo_transaccion = filter_input(INPUT_POST, 'tipo_transaccion');
        $monto_moneda_nacional = filter_input(INPUT_POST, 'monto_moneda_nacional');
        $monto_moneda_extranjera = filter_input(INPUT_POST, 'monto_moneda_extranjera');


        echo $idasiento_diario."--".$numero_transacciones."--".$idcuenta_contable."--".$tipo_transaccion."--".$monto_moneda_nacional."--". $monto_moneda_extranjera;

        $this->Asiento_diario_detalle_recurrente_model->ad_detalle_recurrente_modificar($idasiento_diario
                , $numero_transacciones, $idcuenta_contable
           , $tipo_transaccion, $monto_moneda_nacional, $monto_moneda_extranjera);
        
    }
    
    public function ad_detalle_recurrente_eliminar() {
        $this->load->model('contabilidad/transacciones/asiento_diario_detalle_recurrente/Asiento_diario_detalle_recurrente_model');
        
        $idasiento_diario = filter_input(INPUT_POST, 'idasiento_diario');
        $numero_transacciones = filter_input(INPUT_POST, 'numero_transacciones');

//        echo $idasiento_diario."  ".$numero_transacciones."lol";

        $this->Asiento_diario_detalle_recurrente_model->ad_detalle_recurrente_eliminar($numero_transacciones ,$idasiento_diario );
    }
    
     public function ad_recurrente_eliminar($id_ad_recurrente,$recarga=1){
         $this->load->model('contabilidad/transacciones/asiento_diario_recurrente/Asiento_diario_recurrente_model');
         $this->Asiento_diario_recurrente_model->ad_recurrente_eliminar($id_ad_recurrente);
         
         if($recarga==1){
         header('Location:'.base_url().'index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/index');
         
         }
    }
    
     public function tasa_cambio_agregar() {
        $this->load->model('administracion/Tasa_cambio_model');

        $idmoneda = filter_input(INPUT_POST, 'idmoneda_agregar');
        $fecha_tipo_cambio = filter_input(INPUT_POST, 'fecha_tipo_cambio');
        $tasa_cambio = filter_input(INPUT_POST, 'tasa_cambio');

      $this->Tasa_cambio_model->tasa_cambio_agregar($idmoneda,$fecha_tipo_cambio,$tasa_cambio);
    }

}
