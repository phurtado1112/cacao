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
        $this->load->model('contabilidad/reportes/Estado_situacion_model');
    }

    public function index() {
        $data['titulo'] = 'Rep. E.S.';
        $this->load->view('modules/menu/menu_contabilidad', $data);
        $this->load->view('contabilidad/reportes/estado_situacion_rep_view');
        $this->load->view('modules/foot/contabilidad/er_reporte_foot');
    }

    public function generar_pdf($periodo, $anio,$usuario) {
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

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        // salto de pagina, si no se define lo hace por defecto
        //PARAMETROS(BOOLEANO,distancia hasta donde se debe hacer el salto)
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

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

        $html1 .= "h2,h4{text-align:center}";

        $html1 .= "</style>";

        $html1 .= '<h2>Reporte Estado Resultado</h2>';
        $html1 .= '<h4>' . date("Y-M-D") . '</h4>';
        $html1 .= '<h4>Usuario : ' .$usuario . '</h4>';
        //-----------------------------------------------------------------------------------------------
        $html2 = "";
        $html2 .= "<style type=text/css>";

        $html2 .= "*{font-size:12px;}";
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

        $base_lista = $this->Estructura_base_model->estructura_base();

        foreach ($base_lista as $b_l) {
            $saldo_grupo_total_activos = 0;
            
            if ($b_l['idestructura_base'] == 4 || $b_l['idestructura_base'] == 5) {
                $html2 .= '<br><tr><td  class="estructura_base" colspan="5">' . $b_l['descripcion_estructura_base'] . '</td></tr>';
                $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);

                foreach ($c_l_encontrada as $c_l) {
                    $html2 .= '<tr><td  class="categoria" colspan="5">' . $c_l['categoria_cuenta'] . '</td></tr>';
                    $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);

                    //////////////niveles de grupos///////////////////
                    $saldo_grupo_total_final = 0;
                    foreach ($grupos_n1 as $n1) {

                        $grupos = $this->Estado_situacion_model->niveles_grupo(1, $n1['idgrupo_cuenta']);

                        $saldo_grupo_total = 0;
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
                                    $saldo_grupo_total += $saldo[0]['suma_total'];
                                }
                            }
//                            
                        }
                        $saldo_grupo_total_fomat = number_format($saldo_grupo_total, 2, '.', ',');
                        $html2 .= '<tr><td class="" colspan ="3">' . $n1['grupo_cuenta'] . '</td><td colspan ="2" class="balance">' . $saldo_grupo_total_fomat . '</td></tr>';
                        $saldo_grupo_total_final += $saldo_grupo_total;
                    }
                    $saldo_grupo_total_final_format = number_format($saldo_grupo_total_final, 2, '.', ',');
                    $html2 .= '<tr><td colspan ="3"></td><td class="balance">$</td><td  class="balance-categoria">' . $saldo_grupo_total_final_format . '</td></tr>';
                    $html2 .= '<br><br>';
                    $saldo_grupo_total_activos += $saldo_grupo_total_final;
                }
                $saldo_grupo_total_activos_format = number_format($saldo_grupo_total_activos, 2, '.', ',');
//                define("t_activo",$saldo_grupo_total_activos_format);
                $html2 .= '<tr><td colspan ="3" style=" text-align:left;"  class="balance-activo">Total Activos</td><td  class="balance-activo">$</td><td  class="balance-activo">' . $saldo_grupo_total_activos_format . '</td></tr>';
            }
        }
        $html2 .= "</table>";

       

        $pdf->writeHTMLCell($w = 0, $h = 20, $x = '', $y = '', $html1, $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $pdf->writeHTMLCell($w = 280, $h = 0, $x = '', $y = '45', $html2, $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = true);
//        $pdf->writeHTMLCell($w = 132, $h = 0, $x = '150', $y = '45', $html3, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
//        $pdf->writeHTMLCell($w = 0, $h = 10, $x = '', $y = '150', $html4, $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        
        $nombre_archivo = utf8_decode("Estado_situacion.pdf");
        $pdf->Output($nombre_archivo, "I");
    }
    
    public function mostrar_reporte() {
        
        $anio= filter_input(INPUT_POST, 'anio');
        $periodo=filter_input(INPUT_POST, 'periodo');
       
       
        //-----------------------------------------------------------------------------------------------
        $html2 = "";
        $html2 .= "<style type=text/css>";
        
        $html2 .= "#activos{width:530px;float:left;margin-right:20px;}";
        $html2 .= "#p_c{width:530px; float:left;}";
        
        $html2 .= "*{font-size:12px;}";
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

                        $saldo_grupo_total = 0;
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
                                    $saldo_grupo_total += $saldo[0]['suma_total'];
                                }
                            }
//                            
                        }
                        $saldo_grupo_total_fomat = number_format($saldo_grupo_total, 2, '.', ',');
                        $html2 .= '<tr><td class="" colspan ="3">' . $n1['grupo_cuenta'] . '</td><td colspan ="2" class="balance">' . $saldo_grupo_total_fomat . '</td></tr>';
                        $saldo_grupo_total_final += $saldo_grupo_total;
                    }
                    $saldo_grupo_total_final_format = number_format($saldo_grupo_total_final, 2, '.', ',');
                    $html2 .= '<tr><td colspan ="3"></td><td class="balance">$</td><td  class="balance-categoria">' . $saldo_grupo_total_final_format . '</td></tr>';
//                    $html2 .= '<br><br>';
                    $saldo_grupo_total_activos += $saldo_grupo_total_final;
                }
                $saldo_grupo_total_activos_format = number_format($saldo_grupo_total_activos, 2, '.', ',');
                define("t_activo",$saldo_grupo_total_activos_format);
                $html2 .= '<tr><td colspan ="3" style=" text-align:left;"  class="balance-activo">Total Activos</td><td  class="balance-activo">$</td><td  class="balance-activo">' . $saldo_grupo_total_activos_format . '</td></tr>';
            }
        }
        $html2 .= "</table >";

        $html3 = "";
        

        $html3 .= '<table id="p_c">';

        foreach ($base_lista as $b_l) {
            $saldo_grupo_total_cat = 0.00;

            if ($b_l['idestructura_base'] != 1 && $b_l['idestructura_base'] < 4) {
                $html3 .= '<tr><td  class="estructura_base" colspan="5">' . $b_l['descripcion_estructura_base'] . '</td></tr>';
                $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);

                foreach ($c_l_encontrada as $c_l) {
                    $html3 .= '<tr><td  class="categoria" colspan="5">' . $c_l['categoria_cuenta'] . '</td></tr>';
                    $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);

                    //////////////niveles de grupos///////////////////
                    $saldo_grupo_total_final = 0.00;
                    foreach ($grupos_n1 as $n1) {

                        $grupos = $this->Estado_situacion_model->niveles_grupo(1, $n1['idgrupo_cuenta']);

                        $saldo_grupo_total = 0.00;
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
//                          
                            foreach ($cuentas_hijas as $c_h) {
                                $saldo = $this->Estado_situacion_model->saldo_cuenta($c_h['idcuenta_contable'], $anio, $periodo);

                                if (!empty($saldo)) {
                                    $saldo_grupo_total += $saldo[0]['suma_total'];
                                }
                            }
                        }
                        $saldo_grupo_total_fomat = number_format($saldo_grupo_total, 2, '.', ',');
                        $html3 .= '<tr><td class="" colspan ="3">' . $n1['grupo_cuenta'] . '</td><td colspan ="2" class="balance">' . $saldo_grupo_total_fomat . '</td></tr>';
                        $saldo_grupo_total_final += $saldo_grupo_total;
                    }
                    $saldo_grupo_total_final_format = number_format($saldo_grupo_total_final, 2, '.', ',');
                    $html3 .= '<tr><td colspan ="3"></td><td class="balance">$</td><td  class="balance-categoria">' . $saldo_grupo_total_final_format . '</td></tr>';
 
                    $saldo_grupo_total_cat += $saldo_grupo_total_final;
                }
                $saldo_grupo_total_cat_format = number_format($saldo_grupo_total_cat, 2, '.', ',');
                if ($b_l['idestructura_base'] == 2) {
                    $titulo = "TotalPasivos";
                    define("t_pasivo",$saldo_grupo_total_cat);
                } else {
                    $titulo = "Total Capital";
                    define("t_capital" , $saldo_grupo_total_cat);
                }
                $html3 .= '<tr><td colspan ="3" style=" text-align:left;"  class="balance-activo">' . $titulo . '</td><td  class="balance-activo">$</td><td  class="balance-activo">' . $saldo_grupo_total_cat_format . '</td></tr>';
            }
        }

        $html3 .= "</table>";
        
        $html4 ="";
        
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
                        . '<td colspan ="4" style=" text-align:left;"  class="balance-activo">Total Activos</td><td  class="balance-activo">$</td><td  class="balance-activo">' . t_activo . '</td>'
                        . '<td colspan ="4" style=" text-align:left;"  class="balance-activo">Total Pasivo + Capital</td><td  class="balance-activo">$</td><td  class="balance-activo">' .$suma_p_c. '</td>'
                        . '</tr>';

        $html4 .= "</table>";
        
        
        echo $html2.$html3.$html4;
    }
    
   

}
