<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Asiento Recurrente  </title>
        <link rel="stylesheet" href="<?= base_url(); ?>bootstrap/css/bootstrap.min.css">    

    </head>
    <body>
        <?php
        $origen = array(//idorigen_asiento_diario   
            'name' => 'origen',
            'id' => 'origen',
            'maxlength' => '20',
            'size' => '10',
            'value' => '',
            'class' => 'form-group',
            'placeholder' => 'Origen',
        );
        $numero_asiento_diario = array(//numero_transaccion
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
        $fecha = array(//fecha
            'name' => 'fecha',
            'id' => 'fecha',
            'maxlength' => '20',
            'size' => '10',
            'value' => '',
            'class' => 'form-group',
            'placeholder' => 'Fecha',
        );
        $monto = array(//monto
            'name' => 'monto',
            'id' => 'monto',
            'maxlength' => '20',
            'size' => '10',
            'value' => '',
            'class' => 'form-group',
            'placeholder' => 'Monto',
        );


        $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        ?>
        <div class="container"> </br></br></br>
            <div class="row">
                <div class="form-control">Asiento Diario</div>
                <div class="span3 well">
                    <a href="<?= base_url();?>index.php/contabilidad/transacciones/asiento_diario/asiento_diario/crear" class="btn btn-primary btn-lg " role="button">Nuevo</a>
                    <a href="" class="btn btn-default btn-lg " role="button">Cancelar</a>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-8"><?php echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y'); ?></div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.AD</th>
                                <th>Origen</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Monto Debito</th>
                                <th>Monto Credito</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php
                            if (!empty($asiento_diario)) {
                               
                                foreach ($asiento_diario as $ad) {
                                   $id = $ad['idasiento_diario'] ;
                                    echo"
                        <tr>
                        
                        <td>" . $ad['numero_asiento_diario'] . "</td>
                        <td>" . $ad['origen'] . "</td>
                        <td>" . $ad['descripcion_asiento_diario'] . "</td>
                        <td>" . $ad['fecha_creacion'] . "</td>
                        <td>" . $ad['balance_debito'] . "</td>
                        <td>" . $ad['balance_credito'] . "</td>
                        <td>" . '<a href="'.base_url(). 'index.php/AD/C_Ad/modificar/' . $id . '">Editar</a> -- '
                              . '<a href="index.php/AD/Ad?idasiento_diario=' . $id . '&operacion=desactivar">Eliminar</a>' . "</td>
                        </tr>";
                                }
                            }
                            
                            
                            ?>
                        </tbody>
                        
                    </table>

                   
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>bootstrap/js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jquery-select.js"></script>
    </body>
</html>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

