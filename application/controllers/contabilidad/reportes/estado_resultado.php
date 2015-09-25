<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Estado_resultado extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('contabilidad/reportes/Cuentas_contable_model');
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $this->load->model('contabilidad/catalogo/categoria/Estructura_base_model');
        $this->load->model('contabilidad/reportes/Estado_resultado_model');
        $this->load->model('administracion/Tipo_moneda_model');
        $this->load->model('administracion/Tasa_cambio_model');
    }

    public function index() {
        $data['titulo'] = 'Rep. E.R.';
        $this->load->view('modules/menu/menu_contabilidad', $data);

        $this->load->model('administracion/Tipo_moneda_model');
        $lista_idmoneda = $this->Tipo_moneda_model->lista_moneda();

        $data['idmoneda'] = $lista_idmoneda;

        $this->load->view('contabilidad/reportes/estado_resultado_rep_view', $data);

        foreach ($lista_idmoneda as $idmoneda) {
            $lista_idamoneda_final[$idmoneda['idmoneda']] = $idmoneda['descripcion_moneda'];
        }

        $data['idmoneda'] = $lista_idamoneda_final;

        $lista_idamoneda_para_agregar = $lista_idamoneda_final;
        unset($lista_idamoneda_para_agregar[1]);
        $data['idmoneda_extra'] = $lista_idamoneda_para_agregar;

        $this->load->view('modules/pop_up/introducir_tasa_cambio_pop', $data);
        $this->load->view('modules/foot/contabilidad/er_reporte_foot');
    }

    public function consulta_datos_moneda() {
        $idmoneda = filter_input(INPUT_POST, 'idmoneda');
        $fecha_tipo_cambio = filter_input(INPUT_POST, 'fecha_tipo_cambio');

        $this->load->model('administracion/Tipo_moneda_model');
        $lista_idmoneda = $this->Tipo_moneda_model->lista_moneda_por_id($idmoneda);

        $this->load->model('administracion/Tasa_cambio_model');
        $cambio = $this->Tasa_cambio_model->tasa_cambio_encontrar_por_fecha($fecha_tipo_cambio, $idmoneda);

        if (count($cambio) == 0) {
            echo 'vacio';
        } else {
            echo $lista_idmoneda[0]['simbolo'] . "/" . $cambio[0]['tasa_cambio'];
        }
    }

    public function mostrar_reporte() {
        $presentacion = filter_input(INPUT_POST, 'presentacion');
        $anio = filter_input(INPUT_POST, 'anio');
        $periodo = filter_input(INPUT_POST, 'periodo');
        $moneda = filter_input(INPUT_POST, 'moneda');
        $cambio = filter_input(INPUT_POST, 'cambio');
        $simbolo = filter_input(INPUT_POST, 'simbolo');

        //-----------------------------------------------------------------------------------------------
        $html3 = "";
        $html3 .= "<style type=text/css>";

        $html3 .= "#reporte{margin-left:40px ;width:90%;float:left;margin-top:0px;font-size:12px;}";
        $html3 .= "#p_c{width:530px; float:left;}";

        $html3 .= ".titulos{text-align:right;color: #fff; font-weight: bold; background-color: #222; border-bottom: 1px solid black;}";
        $html3 .= "th{color: white ;font-weight: bold; background-color: #7DCA82; text-align:center;}";
        $html3 .= "td.balance{ text-align:right;}";
        $html3 .= "td.balance-categoria{ border-bottom: 1px solid black; border-top: 1px solid black;text-align:right;}";
        $html3 .= "td.balance-activo{background-color:#7DCA82;text-align:right;}";
        $html3 .= ".categoria{background-color: gray; color:white; border-bottom: 1px solid black; text-align:center;}";
        $html3 .= ".estructura_base{background-color: white; text-align:center; border: 1px solid black;font-size:16px;}";
        $html3 .= ".grupo{text-align:left; border-right: 1px solid white;border-bottom: 1px solid white; color:#fff; ;background-color: #7DCA82;}";
        $html3 .= ".line{border-bottom: 1px solid black;}";

        $html3 .= "</style>";

        $html3 .= '<table id="reporte">';

        if ($presentacion == "general") {
            $html3 .= '<tr><td class="titulos" colspan="2"></td><td class="titulos" colspan="1"></td><td class="titulos" colspan="2">Saldo</td></tr>';
        } else {
            $html3 .= '<tr><td class="titulos" colspan="2"></td><td class="titulos" colspan="1">Movimiento del mes</td><td class="titulos" colspan="2">Saldo</td></tr>';
        }

        $base_lista = $this->Estructura_base_model->estructura_base();
        $resultado_operacion = 0;
        foreach ($base_lista as $b_l) {
            $saldo_grupo_total_cat = 0.00;

            if ($b_l['idestructura_base'] == 4 || $b_l['idestructura_base'] == 5) {

                if ($b_l['idestructura_base'] == 3) {
                    $html3 .= '<tr><td  height="20px;"></td></tr>';
                }

                $html3 .= '<tr><td  class="estructura_base" colspan="5">' . $b_l['descripcion_estructura_base'] . '</td></tr>';
                $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);

                foreach ($c_l_encontrada as $c_l) {
                    $html3 .= '<tr><td  class="categoria" colspan="5">' . $c_l['categoria_cuenta'] . '</td></tr>';
                    $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);

                    if ($presentacion == "general") {
                        //////////////niveles de grupos///////////////////
                        $saldo_grupo_total_final = 0;
                        foreach ($grupos_n1 as $n1) {

                            $grupos = $this->Estado_resultado_model->niveles_grupo(1, $n1['idgrupo_cuenta']);

                            $saldo_grupo_total_cordoba = 0.00;
                            foreach ($grupos as $g) {
                                $i = 1;
                                do {
                                    $i++;
                                    $ultimo_grupo = $g['idgrupocuenta' . $i];
                                    $e = $i - 1;
                                } while ($ultimo_grupo != NULL);
//                            
                                if ($e == 1) {
                                    $g_padre = $g['idgrupo_cuenta1'];
                                } else {
                                    $g_padre = $g['idgrupocuenta' . $e];
                                }
                                $cuentas_hijas = $this->Catalogo_cuentas_model->cuenta_dependencia_grupo('idgrupo_cuenta', $g_padre);
//                          ;
                                foreach ($cuentas_hijas as $c_h) {
                                    $saldo = $this->Estado_resultado_model->saldo_cuenta($c_h['idcuenta_contable'], $anio, $periodo);

                                    if (!empty($saldo)) {
                                        $saldo_grupo_total_cordoba += $saldo[0]['suma_total'];
                                    }
                                }
                            }
                            if ($moneda != 1) {
                                $saldo_grupo_total = $saldo_grupo_total_cordoba / $cambio;
                            } else {
                                $saldo_grupo_total = $saldo_grupo_total_cordoba;
                            }
                            $saldo_grupo_total_fomat = number_format($saldo_grupo_total, 2, '.', ',');
                            $html3 .= '<tr><td class="" colspan ="3">' . $n1['grupo_cuenta'] . '</td><td colspan ="2" class="balance">' . $saldo_grupo_total_fomat . '</td></tr>';
                            $saldo_grupo_total_final += $saldo_grupo_total;
                        }
                    } else if ($presentacion == "detalle") {////////////////////////////////////////////////////////////////
                        $saldo_grupo_total_final = 0;
                        foreach ($grupos_n1 as $n1) {
//                            $html .= '<tr><td class="grupo" >' . $n1['grupo_cuenta'] . '</td><td></td><td></td><td></td><td></td></tr>';
                            $grupos_n2 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n1['idgrupo_cuenta'], $n1['nivel'] + 1);

                            if (count($grupos_n2) == 0) {
                                $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n1['idgrupo_cuenta']);

                                foreach ($cueta_lista as $cueta_lista) {
                                    $saldo = $this->Estado_resultado_model->saldo_cuenta($cueta_lista['idcuenta_contable'], $anio, $periodo);
                                    $saldo_mes = $this->Estado_resultado_model->saldo_cuenta_actual($cueta_lista['idcuenta_contable'], $anio, $periodo);

                                    if (!empty($saldo)) {
                                        $saldo_grupo_total_final+=$saldo[0]['suma_total'];
                                        $saldo = $saldo[0]['suma_total'];
                                        $saldo_mes = $saldo_mes[0]['suma_total'];

                                        if ($moneda != 1) {
                                            $saldo = $saldo / $cambio;
                                            $saldo_mes = $saldo_mes / $cambio;
                                        } else {
                                            $saldo = $saldo;
                                            $saldo_mes = $saldo_mes;
                                        }
                                    } else {
                                        $saldo_grupo_total_final+=0;
                                        $saldo = 0;
                                        $saldo_mes = 0;
                                    }



                                    $html3 .= '<tr><td class="" colspan="2">' . $cueta_lista['cuenta_contable'] . '</td><td class="balance" colspan="1">' . number_format($saldo_mes, 2, '.', ',') . '</td><td class="balance" colspan="2">' . number_format($saldo, 2, '.', ',') . '</td></tr>';
                                }
                            } else {

                                foreach ($grupos_n2 as $n2) {
//                                    $html .= '<tr><td class="line"></td><td class="grupo">' . $n2['grupo_cuenta'] . '</td><td></td><td></td><td></td></tr>';
                                    $grupos_n3 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n2['idgrupo_cuenta'], $n2['nivel'] + 1);

                                    if (count($grupos_n3) == 0) {
                                        $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n2['idgrupo_cuenta']);
                                        foreach ($cueta_lista as $cueta_lista) {
                                            $saldo = $this->Estado_resultado_model->saldo_cuenta($cueta_lista['idcuenta_contable'], $anio, $periodo);
                                            $saldo_mes = $this->Estado_resultado_model->saldo_cuenta_actual($cueta_lista['idcuenta_contable'], $anio, $periodo);


                                            if (!empty($saldo)) {
                                                $saldo_grupo_total_final+=$saldo[0]['suma_total'];
                                                $saldo = $saldo[0]['suma_total'];
                                                $saldo_mes = $saldo_mes[0]['suma_total'];

                                                if ($moneda != 1) {
                                                    $saldo = $saldo / $cambio;
                                                    $saldo_mes = $saldo_mes / $cambio;
                                                } else {
                                                    $saldo = $saldo;
                                                    $saldo_mes = $saldo_mes;
                                                }
                                            } else {
                                                $saldo_grupo_total_final+=0;
                                                $saldo = 0;
                                                $saldo_mes = 0;
                                            }



                                            $html3 .= '<tr><td class="" colspan="2">' . $cueta_lista['cuenta_contable'] . '</td><td class="balance" colspan="1">' . number_format($saldo_mes, 2, '.', ',') . '</td><td class="balance" colspan="2">' . number_format($saldo, 2, '.', ',') . '</td></tr>';
                                        }
                                    } else {
                                        foreach ($grupos_n3 as $n3) {
//                                            $html .= '<tr><td class="line"></td><td class="line"></td><td class="grupo" >' . $n3['grupo_cuenta'] . '</td><td></td><td></td></tr>';
                                            $grupos_n4 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n3['idgrupo_cuenta'], $n3['nivel'] + 1);

                                            if (count($grupos_n4) == 0) {
                                                $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n3['idgrupo_cuenta']);
                                                foreach ($cueta_lista as $cueta_lista) {
                                                    $saldo = $this->Estado_resultado_model->saldo_cuenta($cueta_lista['idcuenta_contable'], $anio, $periodo);
                                                    $saldo_mes = $this->Estado_resultado_model->saldo_cuenta_actual($cueta_lista['idcuenta_contable'], $anio, $periodo);


                                                    if (!empty($saldo)) {
                                                        $saldo_grupo_total_final+=$saldo[0]['suma_total'];
                                                        $saldo = $saldo[0]['suma_total'];
                                                        $saldo_mes = $saldo_mes[0]['suma_total'];

                                                        if ($moneda != 1) {
                                                            $saldo = $saldo / $cambio;
                                                            $saldo_mes = $saldo_mes / $cambio;
                                                        } else {
                                                            $saldo = $saldo;
                                                            $saldo_mes = $saldo_mes;
                                                        }
                                                    } else {
                                                        $saldo_grupo_total_final+=0;
                                                        $saldo = 0;
                                                        $saldo_mes = 0;
                                                    }



                                                    $html3 .= '<tr><td class="" colspan="2">' . $cueta_lista['cuenta_contable'] . '</td><td class="balance" colspan="1">' . number_format($saldo_mes, 2, '.', ',') . '</td><td class="balance" colspan="2">' . number_format($saldo, 2, '.', ',') . '</td></tr>';
                                                }
                                            } else {
//                            
                                                foreach ($grupos_n4 as $n4) {
//                                                    $html .= '<tr><td class="line"></td><td class="line"></td><td class="line"></td><td class="grupo" >' . $n4['grupo_cuenta'] . '</td><td></td></tr>';
                                                    $grupos_n5 = $this->Grupo_cuentas_modelbuscar_grupo_reporte_niveles($n4['idgrupo_cuenta'], $n4['nivel'] + 1);
//
                                                    if (count($grupos_n5) == 0) {
                                                        $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n4['idgrupo_cuenta']);
                                                        foreach ($cueta_lista as $cueta_lista) {
                                                            $saldo = $this->Estado_resultado_model->saldo_cuenta($cueta_lista['idcuenta_contable'], $anio, $periodo);
                                                            $saldo_mes = $this->Estado_resultado_model->saldo_cuenta_actual($cueta_lista['idcuenta_contable'], $anio, $periodo);

                                                            if (!empty($saldo)) {
                                                                $saldo_grupo_total_final+=$saldo[0]['suma_total'];
                                                                $saldo = $saldo[0]['suma_total'];
                                                                $saldo_mes = $saldo_mes[0]['suma_total'];

                                                                if ($moneda != 1) {
                                                                    $saldo = $saldo / $cambio;
                                                                    $saldo_mes = $saldo_mes / $cambio;
                                                                } else {
                                                                    $saldo = $saldo;
                                                                    $saldo_mes = $saldo_mes;
                                                                }
                                                            } else {
                                                                $saldo_grupo_total_final+=0;
                                                                $saldo = 0;
                                                                $saldo_mes = 0;
                                                            }



                                                            $html3 .= '<tr><td class="" colspan="2">' . $cueta_lista['cuenta_contable'] . '</td><td class="balance" colspan="1">' . number_format($saldo_mes, 2, '.', ',') . '</td><td class="balance" colspan="2">' . number_format($saldo, 2, '.', ',') . '</td></tr>';
                                                        }
                                                    } else {
//                                
                                                        foreach ($grupos_n5 as $n5) {
//                                                            $html .= '<tr><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="3">' . $cueta_lista['cuenta_contable'] . '</td><td colspan="1"></td></tr>';

                                                            $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n5['idgrupo_cuenta']);
                                                            foreach ($cueta_lista as $cueta_lista) {
                                                                $saldo = $this->Estado_resultado_model->saldo_cuenta($cueta_lista['idcuenta_contable'], $anio, $periodo);
                                                                $saldo_mes = $this->Estado_resultado_model->saldo_cuenta_actual($cueta_lista['idcuenta_contable'], $anio, $periodo);


                                                                if (!empty($saldo)) {
                                                                    $saldo_grupo_total_final+=$saldo[0]['suma_total'];
                                                                    $saldo = $saldo[0]['suma_total'];
                                                                    $saldo_mes = $saldo_mes[0]['suma_total'];

                                                                    if ($moneda != 1) {
                                                                        $saldo = $saldo / $cambio;
                                                                        $saldo_mes = $saldo_mes / $cambio;
                                                                    } else {
                                                                        $saldo = $saldo;
                                                                        $saldo_mes = $saldo_mes;
                                                                    }
                                                                } else {
                                                                    $saldo_grupo_total_final+=0;
                                                                    $saldo = 0;
                                                                    $saldo_mes = 0;
                                                                }

                                                                $html3 .= '<tr><td class="" colspan="2">' . $cueta_lista['cuenta_contable'] . '</td><td class="balance" colspan="1">' . number_format($saldo_mes, 2, '.', ',') . '</td><td class="balance" colspan="2">' . number_format($saldo, 2, '.', ',') . '</td></tr>';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if ($moneda != 1) {
                        $saldo_grupo_total_final = $saldo_grupo_total_final / $cambio;
                    } else {
                        $saldo_grupo_total_final = $saldo_grupo_total_final;
                    }

                    $saldo_grupo_total_final_format = number_format($saldo_grupo_total_final, 2, '.', ',');
                    $html3 .= '<tr><td colspan ="5" style=" text-align:left; height:10px" ></td></tr>';
                    $html3 .= '<tr><td colspan ="3">Total ' . $c_l["categoria_cuenta"] . '</td><td class="balance">' . $simbolo . '</td><td  class="balance-categoria">' . $saldo_grupo_total_final_format . '</td></tr>';
                    $html3 .= '<tr><td colspan ="5" style=" text-align:left; height:10px" ></td></tr>';
                    $saldo_grupo_total_cat += $saldo_grupo_total_final;
                }
                $saldo_grupo_total_cat_format = number_format($saldo_grupo_total_cat, 2, '.', ',');
                if ($b_l['idestructura_base'] == 4) {
                    $resultado_operacion +=$saldo_grupo_total_cat;
                } else if ($b_l['idestructura_base'] == 5) {
                    $resultado_operacion -=$saldo_grupo_total_cat;
                }
                $html3 .= '<tr><td colspan ="3" style=" text-align:left;"  class="balance-activo">Total ' . $b_l['descripcion_estructura_base'] . '</td><td  class="balance-activo">' . $simbolo . '</td><td  class="balance-activo">' . $saldo_grupo_total_cat_format . '</td></tr>';
            }
            $html3 .= '<tr><td colspan ="5" style=" text-align:left; height:10px" ></td></tr>';
        }

        $html3 .= '<tr><td colspan ="5" style=" text-align:left; height:10px"  ></td></tr>';
        $html3 .= '<tr><td colspan ="3" style=" text-align:left;"  class="balance-activo">Resultado de la operacion</td><td  class="balance-activo">' . $simbolo . '</td><td  class="balance-activo">' . number_format($resultado_operacion, 2, '.', ',') . '</td></tr>';
        $html3 .= "</table >";

        echo $html3;
    }

    public function generar_pdf($periodo, $anio, $usuario, $moneda,$presentacion) {
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($usuario);
        $pdf->SetTitle('REPORTE DE ESTADO SITUACION');
        $pdf->SetSubject('Reporte de estado situacion');

        // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
        //lolgo-ancho loho-encabe-texto-color letras-color marco
        $pdf->SetHeaderData('banner1.png', 150, "", "", array(0, 64, 255), array(0, 97, 6));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderMargin(1);

        $pdf->setFooterData(array(0, 64, 0), array(0, 97, 6));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); //str->nombre de la fuente
        // salto de pagina, si no se define lo hace por defecto
        //PARAMETROS(BOOLEANO,distancia hasta donde se debe hacer el salto)
        $pdf->SetAutoPageBreak(TRUE, 8);

        //relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Añadir una página
        // Este método tiene varias opciones, consulta la documentación para más información.
        $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT); //->debe ir antes de page()
        $pdf->AddPage();
        // Establecer el tipo de letra
        //Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
        // Helvetica para reducir el tamaño del archivo.
        $pdf->SetFont('helvetica', '', 12, '', true);

        $html1 = "";
        $html1 .= "<style type=text/css>";

        $html1 .= "p{text-align:center;display:inline; text-decoration:underline;}";
        $html1 .= ".datos_imprecion{text-align:left;}";

        $html1 .= "</style>";

        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $html1 .= '<p>Reporte Estado Situacion<br> Al mes de ' . $meses[$periodo - 1] . ' del ' . $anio . ' </p>';
        $html1 .= '<h5 class="datos_imprecion">Usuario : ' . $usuario . '<br>';
        setlocale(LC_TIME, 'spanish');
        $html1 .= '' . date("h:i A ") . strftime("del %A, %d de %B de %Y ") . '</h5>';
        //-----------------------------------------------------------------------------------------------
        $html2 = "";
        $html2 .= "<style type=text/css>";

        $html2 .= "table{font-size:11px;}";
        $html2 .= "th{color: white ;font-weight: bold; background-color: #7DCA82; text-align:center;}";
        $html2 .= "td.balance{ text-align:right;}";
        $html2 .= "td.balance-categoria{ border-bottom: 1px solid black; border-top: 1px solid black;text-align:right;}";
        $html2 .= "td.balance-activo{background-color:#7DCA82;text-align:right;}";
        $html2 .= ".categoria{background-color: gray; color:white; border-bottom: 1px solid black; text-align:center;}";
        $html2 .= ".estructura_base{background-color: white; text-align:center; border: 1px solid black;font-size:16px;}";
        $html2 .= ".grupo{text-align:left; border-right: 1px solid white;border-bottom: 1px solid white; color:#fff; ;background-color: #7DCA82;}";
        $html2 .= ".line{border-bottom: 1px solid black;}";

        $html2 .= "</style>";

        $html2 .= '<table>';

        $dato_moneda = $this->Tipo_moneda_model->lista_moneda_por_id($moneda);
        $simbolo = $dato_moneda[0]['simbolo'];

        if ($moneda != 1) {
            $tasa_encontrada = $this->Tasa_cambio_model->tasa_cambio_encontrar_por_fecha(date("Y-m-d"), $moneda);
            $cambio = $tasa_encontrada[0]['tasa_cambio'];
        } else if ($moneda == 1) {
            $cambio = $moneda;
        }
        $base_lista = $this->Estructura_base_model->estructura_base();

        foreach ($base_lista as $b_l) {
            $saldo_grupo_total_activos = 0;

            if ($b_l['idestructura_base'] > 3) {
                $html2 .= '<br><tr><td  class="estructura_base" colspan="5">' . $b_l['descripcion_estructura_base'] . '</td></tr>';
                $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);

                foreach ($c_l_encontrada as $c_l) {
                    $html2 .= '<tr><td  class="categoria" colspan="5">' . $c_l['categoria_cuenta'] . '</td></tr>';
                    $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);
                    
                     if ($presentacion == "general") {
                    //////////////niveles de grupos///////////////////
                    $saldo_grupo_total_final = 0;
                    foreach ($grupos_n1 as $n1) {

                        $grupos = $this->Estado_resultado_model->niveles_grupo(1, $n1['idgrupo_cuenta']);

                        $saldo_grupo_total_cordoba = 0;
                        foreach ($grupos as $g) {
                            $i = 1;
                            do {
                                $i++;
                                $ultimo_grupo = $g['idgrupocuenta' . $i];
                                $e = $i - 1;
                            } while ($ultimo_grupo != NULL);
//                            
                            if ($e == 1) {
                                $g_padre = $g['idgrupo_cuenta1'];
                            } else {
                                $g_padre = $g['idgrupocuenta' . $e];
                            }
                            $cuentas_hijas = $this->Catalogo_cuentas_model->cuenta_dependencia_grupo('idgrupo_cuenta', $g_padre);
//                          ;
                            foreach ($cuentas_hijas as $c_h) {

                                $saldo = $this->Estado_resultado_model->saldo_cuenta($c_h['idcuenta_contable'], $anio, $periodo);

                                if (!empty($saldo)) {
//                              
                                    $saldo_grupo_total_cordoba += $saldo[0]['suma_total'];
                                }
                            }
//                            
                        }
                        if ($moneda != 1) {
                            $saldo_grupo_total = $saldo_grupo_total_cordoba / $cambio;
                        } else {
                            $saldo_grupo_total = $saldo_grupo_total_cordoba;
                        }
                        $saldo_grupo_total_fomat = number_format($saldo_grupo_total, 2, '.', ',');
                        $html2 .= '<tr><td class="" colspan ="3">' . $n1['grupo_cuenta'] . '</td><td colspan ="2" class="balance">' . $saldo_grupo_total_fomat . '</td></tr>';
                        $saldo_grupo_total_final += $saldo_grupo_total;
                    }
                    
                     }else if ($presentacion == "detalle"){/////////////////////////////////////////////////////////////////////////////777
                         
                         $saldo_grupo_total_final = 0;
                        foreach ($grupos_n1 as $n1) {
//                            $html .= '<tr><td class="grupo" >' . $n1['grupo_cuenta'] . '</td><td></td><td></td><td></td><td></td></tr>';
                            $grupos_n2 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n1['idgrupo_cuenta'], $n1['nivel'] + 1);

                            if (count($grupos_n2) == 0) {
                                $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n1['idgrupo_cuenta']);

                                foreach ($cueta_lista as $cueta_lista) {
                                    $saldo = $this->Estado_resultado_model->saldo_cuenta($cueta_lista['idcuenta_contable'], $anio, $periodo);
                                    $saldo_mes = $this->Estado_resultado_model->saldo_cuenta_actual($cueta_lista['idcuenta_contable'], $anio, $periodo);

                                    if (!empty($saldo)) {
                                        $saldo_grupo_total_final+=$saldo[0]['suma_total'];
                                        $saldo = $saldo[0]['suma_total'];
                                        $saldo_mes = $saldo_mes[0]['suma_total'];

                                        if ($moneda != 1) {
                                            $saldo = $saldo / $cambio;
                                            $saldo_mes = $saldo_mes / $cambio;
                                        } else {
                                            $saldo = $saldo;
                                            $saldo_mes = $saldo_mes;
                                        }
                                    } else {
                                        $saldo_grupo_total_final+=0;
                                        $saldo = 0;
                                        $saldo_mes = 0;
                                    }



                                    $html2 .= '<tr><td class="" colspan="2">' . $cueta_lista['cuenta_contable'] . '</td><td class="balance" colspan="1">' . number_format($saldo_mes, 2, '.', ',') . '</td><td class="balance" colspan="2">' . number_format($saldo, 2, '.', ',') . '</td></tr>';
                                }
                            } else {

                                foreach ($grupos_n2 as $n2) {
//                                    $html .= '<tr><td class="line"></td><td class="grupo">' . $n2['grupo_cuenta'] . '</td><td></td><td></td><td></td></tr>';
                                    $grupos_n3 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n2['idgrupo_cuenta'], $n2['nivel'] + 1);

                                    if (count($grupos_n3) == 0) {
                                        $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n2['idgrupo_cuenta']);
                                        foreach ($cueta_lista as $cueta_lista) {
                                            $saldo = $this->Estado_resultado_model->saldo_cuenta($cueta_lista['idcuenta_contable'], $anio, $periodo);
                                            $saldo_mes = $this->Estado_resultado_model->saldo_cuenta_actual($cueta_lista['idcuenta_contable'], $anio, $periodo);


                                            if (!empty($saldo)) {
                                                $saldo_grupo_total_final+=$saldo[0]['suma_total'];
                                                $saldo = $saldo[0]['suma_total'];
                                                $saldo_mes = $saldo_mes[0]['suma_total'];

                                                if ($moneda != 1) {
                                                    $saldo = $saldo / $cambio;
                                                    $saldo_mes = $saldo_mes / $cambio;
                                                } else {
                                                    $saldo = $saldo;
                                                    $saldo_mes = $saldo_mes;
                                                }
                                            } else {
                                                $saldo_grupo_total_final+=0;
                                                $saldo = 0;
                                                $saldo_mes = 0;
                                            }



                                            $html2 .= '<tr><td class="" colspan="2">' . $cueta_lista['cuenta_contable'] . '</td><td class="balance" colspan="1">' . number_format($saldo_mes, 2, '.', ',') . '</td><td class="balance" colspan="2">' . number_format($saldo, 2, '.', ',') . '</td></tr>';
                                        }
                                    } else {
                                        foreach ($grupos_n3 as $n3) {
//                                            $html .= '<tr><td class="line"></td><td class="line"></td><td class="grupo" >' . $n3['grupo_cuenta'] . '</td><td></td><td></td></tr>';
                                            $grupos_n4 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n3['idgrupo_cuenta'], $n3['nivel'] + 1);

                                            if (count($grupos_n4) == 0) {
                                                $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n3['idgrupo_cuenta']);
                                                foreach ($cueta_lista as $cueta_lista) {
                                                    $saldo = $this->Estado_resultado_model->saldo_cuenta($cueta_lista['idcuenta_contable'], $anio, $periodo);
                                                    $saldo_mes = $this->Estado_resultado_model->saldo_cuenta_actual($cueta_lista['idcuenta_contable'], $anio, $periodo);


                                                    if (!empty($saldo)) {
                                                        $saldo_grupo_total_final+=$saldo[0]['suma_total'];
                                                        $saldo = $saldo[0]['suma_total'];
                                                        $saldo_mes = $saldo_mes[0]['suma_total'];

                                                        if ($moneda != 1) {
                                                            $saldo = $saldo / $cambio;
                                                            $saldo_mes = $saldo_mes / $cambio;
                                                        } else {
                                                            $saldo = $saldo;
                                                            $saldo_mes = $saldo_mes;
                                                        }
                                                    } else {
                                                        $saldo_grupo_total_final+=0;
                                                        $saldo = 0;
                                                        $saldo_mes = 0;
                                                    }



                                                    $html2 .= '<tr><td class="" colspan="2">' . $cueta_lista['cuenta_contable'] . '</td><td class="balance" colspan="1">' . number_format($saldo_mes, 2, '.', ',') . '</td><td class="balance" colspan="2">' . number_format($saldo, 2, '.', ',') . '</td></tr>';
                                                }
                                            } else {
//                            
                                                foreach ($grupos_n4 as $n4) {
//                                                    $html .= '<tr><td class="line"></td><td class="line"></td><td class="line"></td><td class="grupo" >' . $n4['grupo_cuenta'] . '</td><td></td></tr>';
                                                    $grupos_n5 = $this->Grupo_cuentas_modelbuscar_grupo_reporte_niveles($n4['idgrupo_cuenta'], $n4['nivel'] + 1);
//
                                                    if (count($grupos_n5) == 0) {
                                                        $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n4['idgrupo_cuenta']);
                                                        foreach ($cueta_lista as $cueta_lista) {
                                                            $saldo = $this->Estado_resultado_model->saldo_cuenta($cueta_lista['idcuenta_contable'], $anio, $periodo);
                                                            $saldo_mes = $this->Estado_resultado_model->saldo_cuenta_actual($cueta_lista['idcuenta_contable'], $anio, $periodo);

                                                            if (!empty($saldo)) {
                                                                $saldo_grupo_total_final+=$saldo[0]['suma_total'];
                                                                $saldo = $saldo[0]['suma_total'];
                                                                $saldo_mes = $saldo_mes[0]['suma_total'];

                                                                if ($moneda != 1) {
                                                                    $saldo = $saldo / $cambio;
                                                                    $saldo_mes = $saldo_mes / $cambio;
                                                                } else {
                                                                    $saldo = $saldo;
                                                                    $saldo_mes = $saldo_mes;
                                                                }
                                                            } else {
                                                                $saldo_grupo_total_final+=0;
                                                                $saldo = 0;
                                                                $saldo_mes = 0;
                                                            }



                                                            $html2 .= '<tr><td class="" colspan="2">' . $cueta_lista['cuenta_contable'] . '</td><td class="balance" colspan="1">' . number_format($saldo_mes, 2, '.', ',') . '</td><td class="balance" colspan="2">' . number_format($saldo, 2, '.', ',') . '</td></tr>';
                                                        }
                                                    } else {
//                                
                                                        foreach ($grupos_n5 as $n5) {
//                                                            $html .= '<tr><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="3">' . $cueta_lista['cuenta_contable'] . '</td><td colspan="1"></td></tr>';

                                                            $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n5['idgrupo_cuenta']);
                                                            foreach ($cueta_lista as $cueta_lista) {
                                                                $saldo = $this->Estado_resultado_model->saldo_cuenta($cueta_lista['idcuenta_contable'], $anio, $periodo);
                                                                $saldo_mes = $this->Estado_resultado_model->saldo_cuenta_actual($cueta_lista['idcuenta_contable'], $anio, $periodo);


                                                                if (!empty($saldo)) {
                                                                    $saldo_grupo_total_final+=$saldo[0]['suma_total'];
                                                                    $saldo = $saldo[0]['suma_total'];
                                                                    $saldo_mes = $saldo_mes[0]['suma_total'];

                                                                    if ($moneda != 1) {
                                                                        $saldo = $saldo / $cambio;
                                                                        $saldo_mes = $saldo_mes / $cambio;
                                                                    } else {
                                                                        $saldo = $saldo;
                                                                        $saldo_mes = $saldo_mes;
                                                                    }
                                                                } else {
                                                                    $saldo_grupo_total_final+=0;
                                                                    $saldo = 0;
                                                                    $saldo_mes = 0;
                                                                }

                                                                $html2 .= '<tr><td class="" colspan="2">' . $cueta_lista['cuenta_contable'] . '</td><td class="balance" colspan="1">' . number_format($saldo_mes, 2, '.', ',') . '</td><td class="balance" colspan="2">' . number_format($saldo, 2, '.', ',') . '</td></tr>';
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                     }
                      if ($moneda != 1) {
                        $saldo_grupo_total_final = $saldo_grupo_total_final / $cambio;
                    } else {
                        $saldo_grupo_total_final = $saldo_grupo_total_final;
                    }
                     
                    $saldo_grupo_total_final_format = number_format($saldo_grupo_total_final, 2, '.', ',');
                    $html2 .= '<tr><td colspan ="3">Total '.$c_l['categoria_cuenta'].'</td><td class="balance">' . $simbolo . '</td><td  class="balance-categoria">' . $saldo_grupo_total_final_format . '</td></tr>';
                    $html2 .= '<br><br>';
                    $saldo_grupo_total_activos += $saldo_grupo_total_final;
                }
                $saldo_grupo_total_activos_format = number_format($saldo_grupo_total_activos, 2, '.', ',');
                
                if ($b_l['idestructura_base'] == 4) {
                    $titulo = "TotalPasivos";
                    define("t_pasivo", $saldo_grupo_total_activos);
                    
                } else if ($b_l['idestructura_base'] == 5){
                    $titulo = "Total Capital";
                    define("t_capital", $saldo_grupo_total_activos);
                }
                $html2 .= '<tr><td colspan ="3" style=" text-align:left;"  class="balance-activo">Total '.$b_l['descripcion_estructura_base'].'</td><td  class="balance-activo">' . $simbolo . '</td><td  class="balance-activo">' . $saldo_grupo_total_activos_format . '</td></tr>';
            }
        }
        $html2 .= "</table>";

        $html2 .= '<br><br>';

        $html2 .= "<style type=text/css>";

        $html2 .= "*{font-size:12px;}";
        $html2 .= "td.balance{ text-align:right;}";
        $html2 .= "td.balance-categoria{ border-bottom: 1px solid black; border-top: 1px solid black;text-align:right;}";
        $html2 .= "td.balance-final-suma{background-color:#7DCA82;text-align:right;border-bottom: 1px solid black; }";
        $html2 .= "td.balance-final{background-color:#7DCA82;text-align:right;}";

        $html2 .= "</style>";


        $html2 .= '<table>';

        $suma_p_c = number_format(t_pasivo - t_capital, 2, '.', ',');
        $html2 .= '<tr>'
                . '<td colspan ="4" style="text-align:left;"  class="balance-final">Resultado de la operacion</td><td  class="balance-final-suma">' . $simbolo . '</td><td  class="balance-final-suma">' . $suma_p_c . '</td>'
                . '</tr>';

        $html2 .= "</table>";

        
        $pdf->writeHTMLCell($w = 0, $h = 20, $x = '', $y = '', $html1, $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '45', $html2, $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = true);
//        $pdf->writeHTMLCell($w = 132, $h = 0, $x = '150', $y = '45', $html3, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
//
//        $pdf->writeHTML($html4, $ln = true, $fill = true, $reseth = false, $cell = true, $align = 'center');

        $nombre_archivo = utf8_decode("E_R_INDEF_".date("d_m_Y").".pdf");
        $pdf->Output($nombre_archivo, "I");
    }
    
    public function generar_excel($periodo, $anio, $usuario, $moneda, $presentacion) {

        $styleEB = array(
            'font' => array('bold' => true, 'color' => array('argb' => '00000000')),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS,),
            'borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'),),),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'argb' => 'FFA0A0A0'
            ),
        );

        $styleCat = array(
            'font' => array('bold' => true,),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS,),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startcolor' => array('argb' => 'CBCBCB',),
                'endcolor' => array('argb' => 'DADADA',),),
        );

        $styleCC = array(
            'font' => array('bold' => true,),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS,),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                'rotation' => 90,
                'startcolor' => array('argb' => '6DDF7C',),
                'endcolor' => array('argb' => '67F379',),),
        );

        $styleG1 = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,),
            'borders' => array(
                    'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'))
            ),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'argb' => 'F2F2F2'
            ),
        );

        $styleB = array(
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,),
            'borders' => array('bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('argb' => '00000000'),),
               
            ),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'argb' => '6DDF7C'
            ),
        );

        $styleT = array(
            'font' => array('bold' => true,'size'=>20),
            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
                'argb' => 'F2F2F2'
            )
        );
        
//         $styleT = array(
//            'font' => array('bold' => true,),
//            'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS,),
//            'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
//                'argb' => '4CEE2C'
//            ),
//        );
        
        $sheet = $this->excel->getActiveSheet();
        
        $objD = new PHPExcel_Worksheet_Drawing();
        $objD->setName('Logo');
        $objD->setDescription('');
        $objD->setPath(__DIR__.'\bannerjasperland.png'); 
        $objD->setHeight(100);
        
         for($i=1;$i<10;$i++){
            $sheet->mergeCells('A'.$i.':E'.$i);
            
        }
        
        $objD->setCoordinates('A1');
        
        $objD->setWorksheet($sheet);
        
        $sheet->setCellValueByColumnAndRow( 0, 6, "Reporte de Estado Situacion");
        $sheet->getStyle("A6:E6")->applyFromArray($styleT);
        
        setlocale(LC_TIME, 'spanish');
        $fecha = utf8_encode(strftime("%A, %d de %B de %Y "));
        $sheet->setCellValueByColumnAndRow( 0, 9, $fecha);
//        $sheet->getStyle("A9:E9")->applyFromArray($styleG1);

        if ($moneda != 1) {
            $tasa_encontrada = $this->Tasa_cambio_model->tasa_cambio_encontrar_por_fecha(date("Y-m-d"), $moneda);
            $cambio = $tasa_encontrada[0]['tasa_cambio'];
            
        } else if ($moneda == 1) {
            $cambio = $moneda;
            
        }

        $eb_col = 0;
        $eb_fil = 10;

        $base_lista = $this->Estructura_base_model->estructura_base();

        foreach ($base_lista as $b_l) {
            if ($b_l['idestructura_base'] >3) {
                $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, $b_l['descripcion_estructura_base']);
                $sheet->getStyle('A' . $eb_fil . ':C' . $eb_fil)->applyFromArray($styleEB);
                $sheet->mergeCells('A' . $eb_fil . ':C' . $eb_fil);
                $eb_fil++;

                $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);
                
                $categorias = "";
                $saldo_grupo_total_cat = 0;
                foreach ($c_l_encontrada as $c_l) {
                    $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, $c_l['categoria_cuenta']);
                    $sheet->getStyle('A' . $eb_fil . ':B' . $eb_fil)->applyFromArray($styleCat);
                    $sheet->mergeCells('A' . $eb_fil . ':B' . $eb_fil);
                    $eb_fil++;

                    $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);
////
//                    //////////////niveles de grupos///////////////////
                    $saldo_grupo_total_final = 0;
                    $num_grupos_impresos=0;
                    foreach ($grupos_n1 as $n1) {

                        $grupos = $this->Estado_resultado_model->niveles_grupo(1, $n1['idgrupo_cuenta']);

                        $saldo_grupo_total_cordoba = 0;
                        foreach ($grupos as $g) {
                            $i = 1;
                            do {
                                $i++;
                                $ultimo_grupo = $g['idgrupocuenta' . $i];
                                $e = $i - 1;
                            } while ($ultimo_grupo != NULL);
////                            
                            if ($e == 1) {
                                $g_padre = $g['idgrupo_cuenta1'];
                            } else {
                                $g_padre = $g['idgrupocuenta' . $e];
                            }
                            $cuentas_hijas = $this->Catalogo_cuentas_model->cuenta_dependencia_grupo('idgrupo_cuenta', $g_padre);

                            foreach ($cuentas_hijas as $c_h) {

                                $saldo = $this->Estado_resultado_model->saldo_cuenta($c_h['idcuenta_contable'], $anio, $periodo);
//
                                if (!empty($saldo)) {
//                              
                                    $saldo_grupo_total_cordoba += $saldo[0]['suma_total'];
                                }
                            }
////                            
                        }
                        if ($moneda != 1) {
                            $saldo_grupo_total = $saldo_grupo_total_cordoba / $cambio;
                        } else {
                            $saldo_grupo_total = $saldo_grupo_total_cordoba;
                        }
                        $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, $n1['grupo_cuenta']);
                        $sheet->getStyle('A' . $eb_fil)->applyFromArray($styleG1);
                        
                        $sheet->setCellValueByColumnAndRow($eb_col + 1, $eb_fil, $saldo_grupo_total);
                        $sheet->getStyle('B' . $eb_fil)->getNumberFormat()->setFormatCode('#,##0.00');
                        $sheet->getStyle('B' . $eb_fil)->applyFromArray($styleB);
                        
                        $eb_fil++;
                        $num_grupos_impresos++;
                        $saldo_grupo_total_final += $saldo_grupo_total;
                    }
//                    $saldo_grupo_total_final_format = number_format($saldo_grupo_total_final, 2, '.', ',');

                    $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, "");
                    $sheet->getStyle('A' . $eb_fil . ':B' . $eb_fil)->applyFromArray($styleG1);
                    $sheet->mergeCells('A' . $eb_fil . ':B' . $eb_fil);
                    $eb_fil++;
                    
//                    $sheet->setCellValue('B'.$eb_fil, '=SUM(B'.($eb_fil-($num_grupos_impresos+1)).':B'.($eb_fil-2).')');
                    $sheet->getStyle('B'.$eb_fil)->getNumberFormat()->setFormatCode('#,##0.00');
                    
                    $categorias.="B".$eb_fil."+";
                    
                    $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, "Total " . $c_l["categoria_cuenta"]);
                    $sheet->getStyle('A' . $eb_fil)->applyFromArray($styleG1);
//                    $sheet->setCellValueByColumnAndRow($eb_col + 1, $eb_fil, $saldo_grupo_total_final_format);//////////////////
                    $sheet->getStyle('B' . $eb_fil)->applyFromArray($styleB);
                    $eb_fil++;
                    $saldo_grupo_total_cat += $saldo_grupo_total_final;
                    
                }
//                $saldo_grupo_total_activos_format = number_format($saldo_grupo_total_cat, 2, '.', ',');
//                define("t_activo", $saldo_grupo_total_activos_format);
//                $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, "Total Activos");
//                $sheet->getStyle('A' . $eb_fil)->applyFromArray($styleG1);
                
                $sheet->setCellValue('C'.$eb_fil, '='.substr($categorias,0,strlen($categorias)-1));
//                $sheet->getStyle('B' . $eb_fil)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('C' . $eb_fil)->applyFromArray($styleB);
            }
        }

        
        $sheet->setTitle("Reporte de Cuentas Contables");
//        
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setWidth(12);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setWidth(12);
        
        $sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
//
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $tablename = "desdeCI" . $ext = ".xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }
    

}
