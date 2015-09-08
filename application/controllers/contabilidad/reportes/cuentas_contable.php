<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cuentas_contable extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('contabilidad/reportes/cuentas_contable_model');

        $this->load->model('contabilidad/catalogo/grupo/Grupo_cuentas_model');
        $this->load->model('contabilidad/catalogo/cuentas/Catalogo_cuentas_model');
        $this->load->model('contabilidad/catalogo/categoria/Categorias_cuentas_model');
        $this->load->model('contabilidad/catalogo/categoria/Estructura_base_model');
    }

    public function generar_excel() {

        $styleEB = array( 
            'font' => array( 'bold' => true, 'color' => array('argb' => '00000000')),
            'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS, ), 
            'borders' => array( 'outline' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 
                                'color' => array('argb' => '00000000'), ), ),
            'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 
                'argb' => 'FFA0A0A0'
               ), 
            );
        
        $styleCat = array( 
            'font' => array( 'bold' => true, ),
            'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS, ), 
            'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR, 
                'rotation' => 90, 
                'startcolor' => array( 'argb' => 'CBCBCB', ), 
                'endcolor' => array( 'argb' => 'DADADA', ), ), 
            );
        
        $styleCC = array( 
            'font' => array( 'bold' => true, ),
            'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER_CONTINUOUS, ), 
            'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR, 
                'rotation' => 90, 
                'startcolor' => array( 'argb' => '6DDF7C', ), 
                'endcolor' => array( 'argb' => '67F379', ), ), 
            );
        
        $styleG1 = array( 
            'font' => array( 'bold' => true, ),
            'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, ), 
            'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 
                                    'color' => array('argb' => '00000000'), ),
                                'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 
                                    'color' => array('argb' => '00000000'), )
            ),
            'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_SOLID, 
                'argb' => 'F2F2F2'
               ),  
            );
        
        $styleGL = array( 
            'borders' => array( 'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 
                                    'color' => array('argb' => '00000000'), ),
                                'right' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN, 
                                    'color' => array('argb' => 'FFFFFFFF'), )
            )
            );
        
        
        
        $sheet = $this->excel->getActiveSheet();
        
        $eb_col = 0;
        $eb_fil = 1;
        
        $base_lista = $this->Estructura_base_model->estructura_base();

        foreach ($base_lista as $b_l) {
            $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, $b_l['descripcion_estructura_base']);
            $sheet->getStyle('A'.$eb_fil.':E'.$eb_fil)->applyFromArray($styleEB);
            $sheet->mergeCells('A'.$eb_fil.':E'.$eb_fil);
            $eb_fil++;
            
            $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);
            
            foreach ($c_l_encontrada as $c_l) {
                $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, $c_l['categoria_cuenta']);
                $sheet->getStyle('A'.$eb_fil.':E'.$eb_fil)->applyFromArray($styleCat);
                $sheet->mergeCells('A'.$eb_fil.':E'.$eb_fil);
                $eb_fil++;
                
                $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);
//
                //////////////niveles de grupos///////////////////
                foreach ($grupos_n1 as $n1) {
                   $sheet->setCellValueByColumnAndRow($eb_col, $eb_fil, $n1['grupo_cuenta']);
                   $sheet->getStyle('A'.$eb_fil)->applyFromArray($styleG1);
                   $eb_fil++;
                   
                   $grupos_n2 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n1['idgrupo_cuenta'], $n1['nivel'] + 1);
                    
                    if (count($grupos_n2) == 0) {
                        $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n1['idgrupo_cuenta']);
//                        
                        foreach ($cueta_lista as $cueta_lista) {
                            $sheet->setCellValue('D'.$eb_fil,$cueta_lista['idcuenta_contable'] );
                            $sheet->setCellValue('E'.$eb_fil,$cueta_lista['cuenta_contable'] );
                            $sheet->getStyle('A'.$eb_fil.":E".$eb_fil)->applyFromArray($styleCC);
                            $eb_fil++;
                        }
                    } else {

                        foreach ($grupos_n2 as $n2) {
                            $sheet->setCellValue("B".$eb_fil, $n2['grupo_cuenta']  );
                            $sheet->getStyle('A'.$eb_fil)->applyFromArray($styleGL);
                            $sheet->getStyle('B'.$eb_fil)->applyFromArray($styleG1);
                            $eb_fil++;
                            
                            $grupos_n3 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n2['idgrupo_cuenta'], $n2['nivel'] + 1);

                            if (count($grupos_n3) == 0) {
                                $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n2['idgrupo_cuenta']);
                                foreach ($cueta_lista as $cueta_lista) {
                                    $sheet->setCellValue('D'.$eb_fil,$cueta_lista['idcuenta_contable'] );
                                    $sheet->setCellValue('E'.$eb_fil,$cueta_lista['cuenta_contable'] );
                                    $sheet->getStyle('A'.$eb_fil.":E".$eb_fil)->applyFromArray($styleCC);
                                    $eb_fil++;
                                }
                            } else {
//                    
                                foreach ($grupos_n3 as $n3) {
                                    $sheet->setCellValue("C".$eb_fil, $n2['grupo_cuenta']  );
                                    $sheet->getStyle('A'.$eb_fil)->applyFromArray($styleGL);
                                    $sheet->getStyle('B'.$eb_fil)->applyFromArray($styleGL);
                                    $sheet->getStyle('C'.$eb_fil)->applyFromArray($styleG1);
                                    $eb_fil++;
                                           
                                    $grupos_n4 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n3['idgrupo_cuenta'], $n3['nivel'] + 1);

                                    if (count($grupos_n4) == 0) {
                                        $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n3['idgrupo_cuenta']);
                                        foreach ($cueta_lista as $cueta_lista) {
                                            $sheet->setCellValue('D'.$eb_fil,$cueta_lista['idcuenta_contable'] );
                                            $sheet->setCellValue('E'.$eb_fil,$cueta_lista['cuenta_contable'] );
                                            $sheet->getStyle('A'.$eb_fil.":E".$eb_fil)->applyFromArray($styleCC);
                                            $eb_fil++;
                                        }
                                    } else {
//                            
                                        foreach ($grupos_n4 as $n4) {
                                            $sheet->setCellValue("D".$eb_fil, $n2['grupo_cuenta']  );
                                            $sheet->getStyle('A'.$eb_fil)->applyFromArray($styleGL);
                                            $sheet->getStyle('B'.$eb_fil)->applyFromArray($styleGL);
                                            $sheet->getStyle('C'.$eb_fil)->applyFromArray($styleGL);
                                            $sheet->getStyle('D'.$eb_fil)->applyFromArray($styleG1);
                                            $eb_fil++;
                                            
                                            $grupos_n5 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n4['idgrupo_cuenta'], $n4['nivel'] + 1);
//
                                            if (count($grupos_n5) == 0) {
                                                $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n4['idgrupo_cuenta']);
                                                foreach ($cueta_lista as $cueta_lista) {
                                                    $sheet->setCellValue('D'.$eb_fil,$cueta_lista['idcuenta_contable'] );
                                                    $sheet->setCellValue('E'.$eb_fil,$cueta_lista['cuenta_contable'] );
                                                    $sheet->getStyle('A'.$eb_fil.":E".$eb_fil)->applyFromArray($styleCC);
                                                    $eb_fil++;
                                                }
                                            } else {
//                                
                                                foreach ($grupos_n5 as $n5) {
                                                    $sheet->setCellValue("E".$eb_fil, $n2['grupo_cuenta']  );
                                                    $sheet->getStyle('A'.$eb_fil)->applyFromArray($styleGL);
                                                    $sheet->getStyle('B'.$eb_fil)->applyFromArray($styleGL);
                                                    $sheet->getStyle('C'.$eb_fil)->applyFromArray($styleGL);
                                                    $sheet->getStyle('E'.$eb_fil)->applyFromArray($styleGL);
                                                    $sheet->getStyle('D'.$eb_fil)->applyFromArray($styleG1);
                                                    $eb_fil++;

                                                    $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n5['idgrupo_cuenta']);
                                                    foreach ($cueta_lista as $cueta_lista) {
                                                        $sheet->setCellValue('D'.$eb_fil,$cueta_lista['idcuenta_contable'] );
                                                        $sheet->setCellValue('E'.$eb_fil,$cueta_lista['cuenta_contable'] );
                                                        $sheet->getStyle('A'.$eb_fil.":E".$eb_fil)->applyFromArray($styleCC);
                                                        $eb_fil++;
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
        }
//        $sheet->getStyle('A1:B100')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000');

////-------------------------------------
//
        $sheet->setTitle("Reporte de Cuentas Contables");
//        
       $sheet->getColumnDimension('A')->setAutoSize(true);
       $sheet->getColumnDimension('B')->setAutoSize(true);
       $sheet->getColumnDimension('C')->setAutoSize(true);
       $sheet->getColumnDimension('D')->setAutoSize(true);
       $sheet->getColumnDimension('E')->setAutoSize(true);
        
        $sheet->getHeaderFooter()->setOddHeader('&C&HReporte de cuentas contables')
        ->setOddFooter('&RPagina &P of &N');

        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $tablename = "desdeCI" . $ext = ".xlsx");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function index() {
        $data['titulo'] = 'Catalogo Cuentas';
        $this->load->view('modules/menu/menu_contabilidad', $data);
        $this->load->view('contabilidad/reportes/cuentas_contables_rep_view');
        $this->load->view('modules/foot/contabilidad/reporte_foot');
    }

    public function cuentas_contables_reporte($inicio = 0) {
        //configuramos la url de la paginacion
        $config['base_url'] = base_url() . 'index.php/contabilidad/reportes/cuentas_contable/cuentas_contables_reporte';
        $config['div'] = '#resultado';
        $config['show_count'] = true;
        $config['total_rows'] = $this->cuentas_contable_model->cantidad_cuentas_contables();
        $config['per_page'] = 15;
        $config['num_links'] = 4;
        $config['uri_segment'] = 5;
        //configuracion de estilo de paginacion 
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';

        //cargamos la librería con nuestra configuracion
        $this->jquery_pagination->initialize($config);

        //obtemos los valores
//        $query_cuentas = $this->Catalogo_cuentas_model->catalogo_cuentas_paginacion(1,$inicio, $config['per_page']);
        $paginacion = $this->jquery_pagination->create_links();
        $data['paginacion'] = $paginacion;

        $html = "";
        $html .= "<style type=text/css>";

        $html .= "th{color: #fff; font-weight: bold; background-color: #222; border-bottom: 1px solid black;}";
        $html .= "td.c{background-color: #7DCA82; color: #fff; border-bottom: 1px solid #fff; }";
        $html .= "td.g{background-color: #7DCA82; color: #fff; border-bottom: 1px solid #fff;text-align:right;}";
        $html .= ".categoria{background-color: gray; color:white; border-bottom: 1px solid black; text-align:center;}";
        $html .= ".estructura_base{background-color: white; text-align:center; border: 1px solid black;}";
        $html .= ".grupo{text-align:right; border-right: 1px solid black;border-bottom: 1px solid black; color:grey}";
        $html .= ".line{border-bottom: 1px solid black;}";
        $html .= "h2{text-align:center}";
        $html .= "table{margin:auto;width:800px;height:100%;}";

        $html .= "</style>";
//      
        $data['tabla_estilos'] = $html;

        $html .= '<table>';
        $html .= '<tr><th colspan="2">Cuenta</th><th colspan="3">Descripcion</th></tr><br>';

        $base_lista = $this->Estructura_base_model->estructura_base();

        foreach ($base_lista as $b_l) {
            $html .= '<tr><td  class="estructura_base" colspan="5">' . $b_l['descripcion_estructura_base'] . '</td></tr>';
            $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);

            foreach ($c_l_encontrada as $c_l) {
                $html .= '<tr><td  class="categoria" colspan="5">' . $c_l['categoria_cuenta'] . '</td></tr>';
                $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);

                //////////////niveles de grupos///////////////////
                foreach ($grupos_n1 as $n1) {
                    $html .= '<tr><td class="grupo" >' . $n1['grupo_cuenta'] . '</td><td></td><td></td><td></td><td></td></tr>';
                    $grupos_n2 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n1['idgrupo_cuenta'], $n1['nivel'] + 1);

                    if (count($grupos_n2) == 0) {
                        $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n1['idgrupo_cuenta']);
                        foreach ($cueta_lista as $cueta_lista) {
                            $html .= '<tr colspan="5"></tr><tr><td class="c" colspan="3"></td><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="1">' . $cueta_lista['cuenta_contable'] . '</td></tr>@@';
                        }
                    } else {

                        foreach ($grupos_n2 as $n2) {
                            $html .= '<tr><td class="line"></td><td class="grupo">' . $n2['grupo_cuenta'] . '</td><td></td><td></td><td></td></tr>';
                            $grupos_n3 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n2['idgrupo_cuenta'], $n2['nivel'] + 1);

                            if (count($grupos_n3) == 0) {
                                $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n2['idgrupo_cuenta']);
                                foreach ($cueta_lista as $cueta_lista) {
                                    $html .= '<tr colspan="5"></tr><tr><td class="c" colspan="3"></td><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="1">' . $cueta_lista['cuenta_contable'] . '</td></tr>@@';
                                }
                            } else {
//                    
                                foreach ($grupos_n3 as $n3) {
                                    $html .= '<tr><td class="line"></td><td class="line"></td><td class="grupo" >' . $n3['grupo_cuenta'] . '</td><td></td><td></td></tr>';
                                    $grupos_n4 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n3['idgrupo_cuenta'], $n3['nivel'] + 1);

                                    if (count($grupos_n4) == 0) {
                                        $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n3['idgrupo_cuenta']);
                                        foreach ($cueta_lista as $cueta_lista) {
                                            $html .= '<tr colspan="5"></tr><tr><td class="c" colspan="3"></td><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="1">' . $cueta_lista['cuenta_contable'] . '</td></tr>@@';
                                        }
                                    } else {
//                            
                                        foreach ($grupos_n4 as $n4) {
                                            $html .= '<tr><td class="line"></td><td class="line"></td><td class="line"></td><td class="grupo" >' . $n4['grupo_cuenta'] . '</td><td></td></tr>';
                                            $grupos_n5 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n4['idgrupo_cuenta'], $n4['nivel'] + 1);
//
                                            if (count($grupos_n5) == 0) {
                                                $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n4['idgrupo_cuenta']);
                                                foreach ($cueta_lista as $cueta_lista) {
                                                    $html .= '<tr colspan="5"></tr><tr><td class="c" colspan="3"></td><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="1">' . $cueta_lista['cuenta_contable'] . '</td></tr>@@';
                                                }
                                            } else {
//                                
                                                foreach ($grupos_n5 as $n5) {
                                                    $html .= '<tr><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="3">' . $cueta_lista['cuenta_contable'] . '</td><td colspan="1"></td></tr>';

                                                    $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n5['idgrupo_cuenta']);
                                                    foreach ($cueta_lista as $cueta_lista) {
                                                        $html .= '<tr colspan="5"></tr><tr><td class="c" colspan="3"></td><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="1">' . $cueta_lista['cuenta_contable'] . '</td></tr>@@';
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
        }

        $html .= "</table>";

        $data["final"] = $config['per_page'];
        $data["inicio"] = $inicio;
        $data["html"] = explode("@@", $html);

        $this->load->view('contabilidad/reportes/cuentas_contables_rep_ajax_view', $data);
    }

    public function generar_pdf() {
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('FernandoJCM');
        $pdf->SetTitle('REPORTE DE CUENTAS CONTABLES');
        $pdf->SetSubject('Reporte de cuentas contables');

        // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
        //lolgo-ancho loho-encabe-texto-color letras-color marco
        $pdf->SetHeaderData('banner1.png', 160, "", "", array(0, 64, 255), array(0, 97, 6));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetHeaderMargin(3);

        $pdf->setFooterData(array(0, 64, 0), array(0, 97, 6));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); //str->nombre de la fuente
        // salto de pagina, si no se define lo hace por defecto
        //PARAMETROS(BOOLEANO,distancia hasta donde se debe hacer el salto)
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // establecer el modo de fuente por defecto
//        $pdf->setFontSubsetting(true);
        // Añadir una página
        // Este método tiene varias opciones, consulta la documentación para más información.
        $pdf->SetMargins(PDF_MARGIN_LEFT, 35, PDF_MARGIN_RIGHT); //->debe ir antes de page()
        $pdf->AddPage();
        // Establecer el tipo de letra
        //Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
        // Helvetica para reducir el tamaño del archivo.
        $pdf->SetFont('helvetica', '', 12, '', true);

        //fijar efecto de sombra en el texto
//        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $html = "";
        $html .= "<style type=text/css>";

        $html .= "th{color: #fff; font-weight: bold; background-color: #222; border-bottom: 1px solid black;}";
        $html .= "td.c{background-color: #7DCA82; color: #fff; border-bottom: 1px solid #fff;}";
        $html .= "td.g{background-color: #7DCA82; color: #fff; border-bottom: 1px solid #fff;}";
        $html .= ".categoria{background-color: gray; color:white; border-bottom: 1px solid black; text-align:center;}";
        $html .= ".estructura_base{background-color: white; text-align:center; border: 1px solid black;}";
        $html .= ".grupo{text-align:right; border-right: 1px solid black;border-bottom: 1px solid black; color:grey}";
        $html .= ".line{border-bottom: 1px solid black;}";
        $html .= "h2{text-align:center}";

        $html .= "</style>";
        $html .= '<h2>Catalogo de Cuentas</h2><h5>Total de cuentas: ' . "" . '</h5>';
//        
        $html .= '<table>';
        $html .= '<tr><th colspan="2">Cuenta</th><th colspan="3">Descripcion</th></tr><br>';

        $base_lista = $this->Estructura_base_model->estructura_base();

        foreach ($base_lista as $b_l) {
            $html .= '<br><tr><td  class="estructura_base" colspan="5">' . $b_l['descripcion_estructura_base'] . '</td></tr>';
            $c_l_encontrada = $this->Categorias_cuentas_model->encontrar_por_campo_reporte($b_l['idestructura_base'], 1);

            foreach ($c_l_encontrada as $c_l) {
                $html .= '<tr><td  class="categoria" colspan="5">' . $c_l['categoria_cuenta'] . '</td></tr>';
                $grupos_n1 = $this->Grupo_cuentas_model->buscar_grupo_reporte($c_l['idcategoria_cuenta'], 1);

                //////////////niveles de grupos///////////////////
                foreach ($grupos_n1 as $n1) {
                    $html .= '<tr><td class="grupo" >' . $n1['grupo_cuenta'] . '</td><td></td><td></td><td></td><td></td></tr>';
                    $grupos_n2 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n1['idgrupo_cuenta'], $n1['nivel'] + 1);

                    if (count($grupos_n2) == 0) {
                        $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n1['idgrupo_cuenta']);
                        foreach ($cueta_lista as $cueta_lista) {
                            $html .= '<tr><td class="c" colspan="3"></td><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="1">' . $cueta_lista['cuenta_contable'] . '</td></tr>';
                        }
                    } else {

                        foreach ($grupos_n2 as $n2) {
                            $html .= '<tr><td class="line"></td><td class="grupo">' . $n2['grupo_cuenta'] . '</td><td></td><td></td><td></td></tr>';
                            $grupos_n3 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n2['idgrupo_cuenta'], $n2['nivel'] + 1);

                            if (count($grupos_n3) == 0) {
                                $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n2['idgrupo_cuenta']);
                                foreach ($cueta_lista as $cueta_lista) {
                                    $html .= '<tr><td class="c" colspan="3"></td><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="1">' . $cueta_lista['cuenta_contable'] . '</td></tr>';
                                }
                            } else {
//                    
                                foreach ($grupos_n3 as $n3) {
                                    $html .= '<tr><td class="line"></td><td class="line"></td><td class="grupo" >' . $n3['grupo_cuenta'] . '</td><td></td><td></td></tr>';
                                    $grupos_n4 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n3['idgrupo_cuenta'], $n3['nivel'] + 1);

                                    if (count($grupos_n4) == 0) {
                                        $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n3['idgrupo_cuenta']);
                                        foreach ($cueta_lista as $cueta_lista) {
                                            $html .= '<tr><td class="c" colspan="3"></td><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="1">' . $cueta_lista['cuenta_contable'] . '</td></tr>';
                                        }
                                    } else {
//                            
                                        foreach ($grupos_n4 as $n4) {
                                            $html .= '<tr><td class="line"></td><td class="line"></td><td class="line"></td><td class="grupo" >' . $n4['grupo_cuenta'] . '</td><td></td></tr>';
                                            $grupos_n5 = $this->Grupo_cuentas_model->buscar_grupo_reporte_niveles($n4['idgrupo_cuenta'], $n4['nivel'] + 1);
//
                                            if (count($grupos_n5) == 0) {
                                                $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n4['idgrupo_cuenta']);
                                                foreach ($cueta_lista as $cueta_lista) {
                                                    $html .= '<tr><td class="c" colspan="3"></td><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="1">' . $cueta_lista['cuenta_contable'] . '</td></tr>';
                                                }
                                            } else {
//                                
                                                foreach ($grupos_n5 as $n5) {
                                                    $html .= '<tr><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="3">' . $cueta_lista['cuenta_contable'] . '</td><td colspan="1"></td></tr>';

                                                    $cueta_lista = $this->Catalogo_cuentas_model->encontrar_por_idgrupo($n5['idgrupo_cuenta']);
                                                    foreach ($cueta_lista as $cueta_lista) {
                                                        $html .= '<tr><td class="c" colspan="3"></td><td class="c" colspan="1">' . $cueta_lista['idcuenta_contable'] . '</td><td class="g" colspan="1">' . $cueta_lista['cuenta_contable'] . '</td></tr>';
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
        }

        $html .= "</table>";

        $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
//    $pdf->writeHTML($html, true, false, true, false, '');
// Este método tiene varias opciones, consulte la documentación para más información.
        $nombre_archivo = utf8_decode("Catalogo de cuentas.pdf");

        $pdf->Output($nombre_archivo, "I");
    }

}
