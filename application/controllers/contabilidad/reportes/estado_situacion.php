<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Estado_situacion extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('contabilidad/reportes/Cuentas_contable_model');
        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $this->load->model('contabilidad/catalogo/categoria/Estructura_base_model');
        $this->load->model('contabilidad/reportes/Estado_situacion_model');
        $this->load->model('administracion/Tipo_moneda_model');
        $this->load->model('administracion/Tasa_cambio_model');
    }

    public function index() {
        $data['titulo'] = 'Rep. E.S.';

        $this->load->model('administracion/Tipo_moneda_model');
        $lista_idmoneda = $this->Tipo_moneda_model->lista_moneda();
        $data['idmoneda'] = $lista_idmoneda;

        $this->load->view('modules/menu/menu_contabilidad', $data);
        $this->load->view('contabilidad/reportes/estado_situacion_rep_view', $data);

        foreach ($lista_idmoneda as $idmoneda) {
            $lista_idamoneda_final[$idmoneda['idmoneda']] = $idmoneda['descripcion_moneda'];
        }

        $data['idmoneda'] = $lista_idamoneda_final;

        $lista_idamoneda_para_agregar = $lista_idamoneda_final;
        unset($lista_idamoneda_para_agregar[1]);
        $data['idmoneda_extra'] = $lista_idamoneda_para_agregar;

        $this->load->view('modules/pop_up/introducir_tasa_cambio_pop', $data);
        $this->load->view('modules/foot/contabilidad/es_reporte_foot');
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

    public function generar_pdf($periodo, $anio, $usuario, $moneda) {
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
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

            if ($b_l['idestructura_base'] == 1) {
                $html2 .= '<br><tr><td  class="estructura_base" colspan="5">' . $b_l['descripcion_estructura_base'] . '</td></tr>';
                $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);

                foreach ($c_l_encontrada as $c_l) {
                    $html2 .= '<tr><td  class="categoria" colspan="5">' . $c_l['categoria_cuenta'] . '</td></tr>';
                    $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);

                    //////////////niveles de grupos///////////////////
                    $saldo_grupo_total_final = 0;
                    foreach ($grupos_n1 as $n1) {

                        $grupos = $this->Estado_situacion_model->niveles_grupo(1, $n1['idgrupo_cuenta']);

                        $saldo_grupo_total_cordoba = 0;
                        foreach ($grupos as $g) {
                            $i = 1;
                            do {
                                $i++;
                                $ultimo_grupo = $g['idgrupocuenta' . $i];
                                $e = $i - 1;
                            } while ($ultimo_grupo != NULL);
//                            
//                            echo $e."<br>-------------<br>";
                            if ($e == 1) {
                                $g_padre = $g['idgrupo_cuenta1'];
                            } else {
                                $g_padre = $g['idgrupocuenta' . $e];
                            }
                            $cuentas_hijas = $this->Catalogo_cuentas_model->cuenta_dependencia_grupo('idgrupo_cuenta', $g_padre);
//                          ;
                            foreach ($cuentas_hijas as $c_h) {

                                $saldo = $this->Estado_situacion_model->saldo_cuenta($c_h['idcuenta_contable'], $anio, $periodo);

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
                    $saldo_grupo_total_final_format = number_format($saldo_grupo_total_final, 2, '.', ',');
                    $html2 .= '<tr><td colspan ="3"></td><td class="balance">' . $simbolo . '</td><td  class="balance-categoria">' . $saldo_grupo_total_final_format . '</td></tr>';
                    $html2 .= '<br><br>';
                    $saldo_grupo_total_activos += $saldo_grupo_total_final;
                }
                $saldo_grupo_total_activos_format = number_format($saldo_grupo_total_activos, 2, '.', ',');
                define("t_activo", $saldo_grupo_total_activos_format);
                $html2 .= '<tr><td colspan ="3" style=" text-align:left;"  class="balance-activo">Total Activos</td><td  class="balance-activo">' . $simbolo . '</td><td  class="balance-activo">' . $saldo_grupo_total_activos_format . '</td></tr>';
            }
        }
        $html2 .= "</table>";

        $html3 = "";
        $html3 .= "<style type=text/css>";

        $html3 .= "*{font-size:11px;}";
        $html3 .= "th{color: white ;font-weight: bold; background-color: #7DCA82; text-align:center;}";
        $html3 .= "td.balance{ text-align:right;}";
        $html3 .= "td.balance-categoria{ border-bottom: 1px solid black; border-top: 1px solid black;text-align:right;}";
        $html3 .= "td.balance-activo{background-color:#7DCA82;text-align:right;}";
        $html3 .= ".categoria{background-color: gray; color:white; border-bottom: 1px solid black; text-align:center;}";
        $html3 .= ".estructura_base{background-color: white; text-align:center; border: 1px solid black;font-size:16px;}";
        $html3 .= ".grupo{text-align:left; border-right: 1px solid white;border-bottom: 1px solid white; color:#fff; ;background-color: #7DCA82;}";
        $html3 .= ".line{border-bottom: 1px solid black;}";

        $html3 .= "</style>";

        $html3 .= '<table>';

        foreach ($base_lista as $b_l) {
            $saldo_grupo_total_cat = 0.00;

            if ($b_l['idestructura_base'] != 1 && $b_l['idestructura_base'] < 4) {
                $html3 .= '<br><tr><td  class="estructura_base" colspan="5">' . $b_l['descripcion_estructura_base'] . '</td></tr>';
                $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);

                foreach ($c_l_encontrada as $c_l) {
                    $html3 .= '<tr><td  class="categoria" colspan="5">' . $c_l['categoria_cuenta'] . '</td></tr>';
                    $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);

                    //////////////niveles de grupos///////////////////
                    $saldo_grupo_total_final = 0.00;
                    foreach ($grupos_n1 as $n1) {

                        $grupos = $this->Estado_situacion_model->niveles_grupo(1, $n1['idgrupo_cuenta']);

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
                                $saldo = $this->Estado_situacion_model->saldo_cuenta($c_h['idcuenta_contable'], $anio, $periodo);

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
                    $saldo_grupo_total_final_format = number_format($saldo_grupo_total_final, 2, '.', ','); ////
                    $html3 .= '<tr><td colspan ="3">Total ' . $c_l["categoria_cuenta"] . '</td><td class="balance">' . $simbolo . '</td><td  class="balance-categoria">' . $saldo_grupo_total_final_format . '</td></tr>';
                    $html3 .= '<br><br>';
                    $saldo_grupo_total_cat += $saldo_grupo_total_final;
                }
                $saldo_grupo_total_cat_format = number_format($saldo_grupo_total_cat, 2, '.', ',');
                if ($b_l['idestructura_base'] == 2) {
                    $titulo = "TotalPasivos";
                    define("t_pasivo", $saldo_grupo_total_cat);
                } else {
                    $titulo = "Total Capital";
                    define("t_capital", $saldo_grupo_total_cat);
                }
                $html3 .= '<tr><td colspan ="3" style=" text-align:left;"  class="balance-activo">' . $titulo . '</td><td  class="balance-activo">' . $simbolo . '</td><td  class="balance-activo">' . $saldo_grupo_total_cat_format . '</td></tr>';
            }
        }

        $html3 .= "</table>";

        $html4 = '<br><br>';

        $html4 .= "<style type=text/css>";

        $html4 .= "*{font-size:12px;}";
        $html4 .= "td.balance{ text-align:right;}";
        $html4 .= "td.balance-categoria{ border-bottom: 1px solid black; border-top: 1px solid black;text-align:right;}";
        $html4 .= "td.balance-activo{background-color:#7DCA82;text-align:right;}";

        $html4 .= "</style>";


        $html4 .= '<table>';

        $suma_p_c = number_format(t_pasivo + t_capital, 2, '.', ',');
        $html4 .= '<tr>'
                . '<td colspan ="4" style=" text-align:left;"  class="balance-activo">Total Activos</td><td  class="balance-activo">' . $simbolo . '</td><td  class="balance-activo">' . t_activo . '</td>'
                . '<td colspan ="4" style=" text-align:left;"  class="balance-activo">Total Pasivo + Capital</td><td  class="balance-activo">' . $simbolo . '</td><td  class="balance-activo">' . $suma_p_c . '</td>'
                . '</tr>';

        $html4 .= "</table>";

        $pdf->writeHTMLCell($w = 0, $h = 20, $x = '', $y = '', $html1, $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->writeHTMLCell($w = 132, $h = 0, $x = '', $y = '45', $html2, $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->writeHTMLCell($w = 132, $h = 0, $x = '150', $y = '45', $html3, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

        $pdf->writeHTML($html4, $ln = true, $fill = false, $reseth = false, $cell = false, $align = 'center');

        $nombre_archivo = utf8_decode("Estado_situacion.pdf");
        $pdf->Output($nombre_archivo, "I");
    }

    public function mostrar_reporte() {

        $anio = filter_input(INPUT_POST, 'anio');
        $periodo = filter_input(INPUT_POST, 'periodo');
        $moneda = filter_input(INPUT_POST, 'moneda');
        $cambio = filter_input(INPUT_POST, 'cambio');
        $simbolo = filter_input(INPUT_POST, 'simbolo');


        //-----------------------------------------------------------------------------------------------
        $html2 = "";
        $html2 .= "<style type=text/css>";

        $html2 .= "#activos{width:530px;float:left;margin-right:20px;}";
        $html2 .= "#p_c{width:530px; float:left;}";

        $html2 .= "table{font-size:12px;}";
        $html2 .= "th{color: white ;font-weight: bold; background-color: #7DCA82; text-align:center;}";
        $html2 .= "td.balance{ text-align:right;}";
        $html2 .= "td.balance-categoria{ border-bottom: 1px solid black; border-top: 1px solid black;text-align:right;}";
        $html2 .= "td.balance-activo{background-color:#7DCA82;text-align:right;}";
        $html2 .= ".categoria{background-color: gray; color:white; border-bottom: 1px solid black; text-align:center;}";
        $html2 .= ".estructura_base{background-color: white; text-align:center; border: 1px solid black;font-size:16px;}";
        $html2 .= ".grupo{text-align:left; border-right: 1px solid white;border-bottom: 1px solid white; color:#fff; ;background-color: #7DCA82;}";
        $html2 .= ".line{border-bottom: 1px solid black;}";

        $html2 .= "</style>";

        $html2 .= '<table id="activos">';

        $base_lista = $this->Estructura_base_model->estructura_base();

        foreach ($base_lista as $b_l) {
            $saldo_grupo_total_activos = 0;

            if ($b_l['idestructura_base'] == 1) {
                $html2 .= '<tr><td  class="estructura_base" colspan="5">' . $b_l['descripcion_estructura_base'] . '</td></tr>';
                $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);

                foreach ($c_l_encontrada as $c_l) {
                    $html2 .= '<tr><td  class="categoria" colspan="5">' . $c_l['categoria_cuenta'] . '</td></tr>';
                    $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);

                    //////////////niveles de grupos///////////////////
                    $saldo_grupo_total_final = 0;
                    foreach ($grupos_n1 as $n1) {

                        $grupos = $this->Estado_situacion_model->niveles_grupo(1, $n1['idgrupo_cuenta']);

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

                                $saldo = $this->Estado_situacion_model->saldo_cuenta($c_h['idcuenta_contable'], $anio, $periodo);

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
                    $saldo_grupo_total_final_format = number_format($saldo_grupo_total_final, 2, '.', ',');
                    $html2 .= '<tr><td colspan ="3"></td><td class="balance">' . $simbolo . '</td><td  class="balance-categoria">' . $saldo_grupo_total_final_format . '</td></tr>';
//                    $html2 .= '<br><br>';
                    $saldo_grupo_total_activos += $saldo_grupo_total_final;
                }
                $saldo_grupo_total_activos_format = number_format($saldo_grupo_total_activos, 2, '.', ',');
                define("t_activo", $saldo_grupo_total_activos_format);
                $html2 .= '<tr><td colspan ="3" style=" text-align:left;"  class="balance-activo">Total Activos</td><td  class="balance-activo">' . $simbolo . '</td><td  class="balance-activo">' . $saldo_grupo_total_activos_format . '</td></tr>';
            }
        }
        $html2 .= "</table >";

        $html3 = "";


        $html3 .= '<table id="p_c">';

        foreach ($base_lista as $b_l) {
            $saldo_grupo_total_cat = 0.00;

            if ($b_l['idestructura_base'] != 1 && $b_l['idestructura_base'] < 4) {

                if ($b_l['idestructura_base'] == 3) {
                    $html3 .= '<tr><td  height="20px;"></td></tr>';
                }

                $html3 .= '<tr><td  class="estructura_base" colspan="5">' . $b_l['descripcion_estructura_base'] . '</td></tr>';
                $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);

                foreach ($c_l_encontrada as $c_l) {
                    $html3 .= '<tr><td  class="categoria" colspan="5">' . $c_l['categoria_cuenta'] . '</td></tr>';
                    $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);

                    //////////////niveles de grupos///////////////////
                    $saldo_grupo_total_final = 0.00;
                    foreach ($grupos_n1 as $n1) {

                        $grupos = $this->Estado_situacion_model->niveles_grupo(1, $n1['idgrupo_cuenta']);

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
                                $saldo = $this->Estado_situacion_model->saldo_cuenta($c_h['idcuenta_contable'], $anio, $periodo);

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

                    $saldo_grupo_total_final_format = number_format($saldo_grupo_total_final, 2, '.', ','); ////
                    $html3 .= '<tr><td colspan ="3">Total ' . $c_l["categoria_cuenta"] . '</td><td class="balance">' . $simbolo . '</td><td  class="balance-categoria">' . $saldo_grupo_total_final_format . '</td></tr>';
//                    $html3 .= '<br><br>';
                    $saldo_grupo_total_cat += $saldo_grupo_total_final;
                }
                $saldo_grupo_total_cat_format = number_format($saldo_grupo_total_cat, 2, '.', ',');
                if ($b_l['idestructura_base'] == 2) {
                    $titulo = "TotalPasivos";
                    define("t_pasivo", $saldo_grupo_total_cat);
                } else {
                    $titulo = "Total Capital";
                    define("t_capital", $saldo_grupo_total_cat);
                }
                $html3 .= '<tr><td colspan ="3" style=" text-align:left;"  class="balance-activo">' . $titulo . '</td><td  class="balance-activo">' . $simbolo . '</td><td  class="balance-activo">' . $saldo_grupo_total_cat_format . '</td></tr>';
            }
        }

        $html3 .= "</table>";

        $html4 = "";

        $html4 .= "<style type=text/css>";

        $html4 .= "#comparacion{width:1080px;heigth:100px;border:double; margin-}";
        $html4 .= "*{font-size:12px;}";
        $html4 .= "td.balance{ text-align:right;}";
        $html4 .= "td.balance-categoria{ border-bottom: 1px solid black; border-top: 1px solid black;text-align:right;}";
        $html4 .= "td.balance-activo{background-color:#7DCA82;text-align:right;}";

        $html4 .= "</style>";


        $html4 .= '<table id="comparacion">';

        $suma_p_c = number_format(t_pasivo + t_capital, 2, '.', ',');

        $html4 .= '<tr>'
                . '<td colspan ="4" style=" text-align:left;"  class="balance-activo">Total Activos</td><td  class="balance-activo">' . $simbolo . '</td><td  class="balance-activo">' . t_activo . '</td>'
                . '<td colspan ="4" style=" text-align:left;"  class="balance-activo">Total Pasivo + Capital</td><td  class="balance-activo">' . $simbolo . '</td><td  class="balance-activo">' . $suma_p_c . '</td>'
                . '</tr>';

        $html4 .= "</table>";

        echo $html2 . $html3 . $html4;
    }

    public function generar_excel($periodo, $anio, $usuario, $moneda) {

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
            if ($b_l['idestructura_base'] == 1) {
                $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, $b_l['descripcion_estructura_base']);
                $sheet->getStyle('A' . $eb_fil . ':B' . $eb_fil)->applyFromArray($styleEB);
                $sheet->mergeCells('A' . $eb_fil . ':B' . $eb_fil);
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
//
                    //////////////niveles de grupos///////////////////
                    $saldo_grupo_total_final = 0;
                    $num_grupos_impresos=0;
                    foreach ($grupos_n1 as $n1) {

                        $grupos = $this->Estado_situacion_model->niveles_grupo(1, $n1['idgrupo_cuenta']);

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

                                $saldo = $this->Estado_situacion_model->saldo_cuenta($c_h['idcuenta_contable'], $anio, $periodo);
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
                    
                    $sheet->setCellValue('B'.$eb_fil, '=SUM(B'.($eb_fil-($num_grupos_impresos+1)).':B'.($eb_fil-2).')');
                    $sheet->getStyle('B'.$eb_fil)->getNumberFormat()->setFormatCode('#,##0.00');
                    
                    $categorias.="B".$eb_fil."+";
                    
                    $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, "Total " . $c_l["categoria_cuenta"]);
                    $sheet->getStyle('A' . $eb_fil)->applyFromArray($styleG1);
//                    $sheet->setCellValueByColumnAndRow($eb_col + 1, $eb_fil, $saldo_grupo_total_final_format);
                    $sheet->getStyle('B' . $eb_fil)->applyFromArray($styleB);
                    $eb_fil++;
                    $saldo_grupo_total_cat += $saldo_grupo_total_final;
                    
                }
                $saldo_grupo_total_activos_format = number_format($saldo_grupo_total_cat, 2, '.', ',');
                define("t_activo", $saldo_grupo_total_activos_format);
                $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, "Total Activos");
                $sheet->getStyle('A' . $eb_fil)->applyFromArray($styleG1);
                
                $sheet->setCellValue('B'.$eb_fil, '='.substr($categorias,0,strlen($categorias)-1));
                $sheet->getStyle('B' . $eb_fil)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('B' . $eb_fil)->applyFromArray($styleB);
            }
        }


        $eb_col = 3;
        $eb_fil = 10;

        foreach ($base_lista as $b_l) {
            if ($b_l['idestructura_base'] == 2 ) {

                $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, $b_l['descripcion_estructura_base']);
                $sheet->getStyle('D' . $eb_fil . ':E' . $eb_fil)->applyFromArray($styleEB);
                $sheet->mergeCells('D' . $eb_fil . ':E' . $eb_fil);
                $eb_fil++;
//
                $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);
                
                $categorias = "";
                $saldo_grupo_total_cat = 0;
                foreach ($c_l_encontrada as $c_l) {
                    $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, $c_l['categoria_cuenta']);
                    $sheet->getStyle('D' . $eb_fil . ':E' . $eb_fil)->applyFromArray($styleCat);
                    $sheet->mergeCells('D' . $eb_fil . ':E' . $eb_fil);
                    $eb_fil++;

                    $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);
//
                    //////////////niveles de grupos///////////////////
                    $saldo_grupo_total_final = 0;
                    $num_grupos_impresos=0;
                    foreach ($grupos_n1 as $n1) {
//
                        $grupos = $this->Estado_situacion_model->niveles_grupo(1, $n1['idgrupo_cuenta']);

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

                                $saldo = $this->Estado_situacion_model->saldo_cuenta($c_h['idcuenta_contable'], $anio, $periodo);
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
                        $sheet->getStyle('D' . $eb_fil)->applyFromArray($styleG1);
                        
                        $sheet->setCellValueByColumnAndRow($eb_col + 1, $eb_fil, $saldo_grupo_total);
                        $sheet->getStyle('E' . $eb_fil)->getNumberFormat()->setFormatCode('#,##0.00');
                        $sheet->getStyle('E' . $eb_fil)->applyFromArray($styleB);
                        
                        $eb_fil++;
                        $num_grupos_impresos++;
                        $saldo_grupo_total_final += $saldo_grupo_total;
                        
                        
                    }
                    $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, "");
                    $sheet->getStyle('D' . $eb_fil . ':E' . $eb_fil)->applyFromArray($styleG1);
                    $sheet->mergeCells('D' . $eb_fil . ':E' . $eb_fil);
                    $eb_fil++;
                    
                    $sheet->setCellValue('E'.$eb_fil, '=SUM(E'.($eb_fil-($num_grupos_impresos+1)).':E'.($eb_fil-2).')');
                    $sheet->getStyle('E'.$eb_fil)->getNumberFormat()->setFormatCode('#,##0.00');
//                    
                     $categorias.="E".$eb_fil."+";
//                    
                    $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, "Total " . $c_l["categoria_cuenta"]);
                    $sheet->getStyle('D' . $eb_fil)->applyFromArray($styleG1);
//                    $sheet->setCellValueByColumnAndRow($eb_col + 1, $eb_fil, $saldo_grupo_total_final_format);
                    $sheet->getStyle('E' . $eb_fil)->applyFromArray($styleB);
                    $eb_fil++;
                }
                $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, "Total Pasivos");
                $sheet->getStyle('D' . $eb_fil)->applyFromArray($styleG1);
                
                $sheet->setCellValue('E'.$eb_fil, '='.substr($categorias,0,strlen($categorias)-1));
                $sheet->getStyle('E' . $eb_fil)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('E' . $eb_fil)->applyFromArray($styleB);
            }
        }
        
        
        foreach ($base_lista as $b_l) {
            if ($b_l['idestructura_base'] == 3 ) {

                $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, $b_l['descripcion_estructura_base']);
                $sheet->getStyle('D' . $eb_fil . ':E' . $eb_fil)->applyFromArray($styleEB);
                $sheet->mergeCells('D' . $eb_fil . ':E' . $eb_fil);
                $eb_fil++;
//
                $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);
                
                $categorias = "";
                $saldo_grupo_total_cat = 0;
                foreach ($c_l_encontrada as $c_l) {
                    $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, $c_l['categoria_cuenta']);
                    $sheet->getStyle('D' . $eb_fil . ':E' . $eb_fil)->applyFromArray($styleCat);
                    $sheet->mergeCells('D' . $eb_fil . ':E' . $eb_fil);
                    $eb_fil++;

                    $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);
//
                    //////////////niveles de grupos///////////////////
                    $saldo_grupo_total_final = 0;
                    $num_grupos_impresos=0;
                    foreach ($grupos_n1 as $n1) {
//
                        $grupos = $this->Estado_situacion_model->niveles_grupo(1, $n1['idgrupo_cuenta']);

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

                                $saldo = $this->Estado_situacion_model->saldo_cuenta($c_h['idcuenta_contable'], $anio, $periodo);
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
                        $sheet->getStyle('D' . $eb_fil)->applyFromArray($styleG1);
                        
                        $sheet->setCellValueByColumnAndRow($eb_col + 1, $eb_fil, $saldo_grupo_total);
                        $sheet->getStyle('E' . $eb_fil)->getNumberFormat()->setFormatCode('#,##0.00');
                        $sheet->getStyle('E' . $eb_fil)->applyFromArray($styleB);
                        
                        $eb_fil++;
                        $num_grupos_impresos++;
                        $saldo_grupo_total_final += $saldo_grupo_total;
                        
                        
                    }
                    $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, "");
                    $sheet->getStyle('D' . $eb_fil . ':E' . $eb_fil)->applyFromArray($styleG1);
                    $sheet->mergeCells('D' . $eb_fil . ':E' . $eb_fil);
                    $eb_fil++;
                    
                    $sheet->setCellValue('E'.$eb_fil, '=SUM(E'.($eb_fil-($num_grupos_impresos+1)).':E'.($eb_fil-2).')');
                    $sheet->getStyle('E'.$eb_fil)->getNumberFormat()->setFormatCode('#,##0.00');
//                    
                     $categorias.="E".$eb_fil."+";
//                    
                    $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, "Total " . $c_l["categoria_cuenta"]);
                    $sheet->getStyle('D' . $eb_fil)->applyFromArray($styleG1);
//                    $sheet->setCellValueByColumnAndRow($eb_col + 1, $eb_fil, $saldo_grupo_total_final_format);
                    $sheet->getStyle('E' . $eb_fil)->applyFromArray($styleB);
                    $eb_fil++;
                }
                $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, "Total Pasivos");
                $sheet->getStyle('D' . $eb_fil)->applyFromArray($styleG1);
                
                $sheet->setCellValue('E'.$eb_fil, '='.substr($categorias,0,strlen($categorias)-1));
                $sheet->getStyle('E' . $eb_fil)->getNumberFormat()->setFormatCode('#,##0.00');
                $sheet->getStyle('E' . $eb_fil)->applyFromArray($styleB);
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
