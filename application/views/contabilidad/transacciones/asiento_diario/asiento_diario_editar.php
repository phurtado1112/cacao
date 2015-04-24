<!DOCTYPE html>

<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Asiento Diario  </title>
        <link rel="stylesheet" href="<?= base_url(); ?>css/bootstrap.min.css">    

    </head>
    <body>
        <?php
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
            'id' => 'descripcion_cuenta_contable',
            'maxlength' => '120',
            'size' => '50',
            'value' => '',
            'class' => 'form-group',
            'placeholder' => 'Descripcion Cta. Contable',
        );
        $balance_credito = array(//balance_credito
            'name' => 'balance_credito',
            'id' => 'balance_credito',
            'maxlength' => '20',
            'size' => '10',
            'value' => '',
            'class' => 'form-group',
            'placeholder' => 'Crédito',
        );
        $balance_debito = array(//balance_debito
            'name' => 'balance_debito',
            'id' => 'balance_debito',
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
        ?>
        <div class="container"> </br></br></br>
            <div class="row">
                <div class="form-control">Asiento Diario</div>
                <div class="span3 well">

                    <?= form_open(); ?> 
                    <div class="row">
                        <div class="col-md-4">Origen Asiento Diario</div>
                        <div class="col-md-4 col-md-offset-4">Fecha de Creacion</div></div>
                    <div class="row">
                        <div class="col-md-4"><?=form_dropdown('origen_asiento_diario',$idorigen_asiento_diario);?></div>
                        <div class="col-md-4 col-md-offset-4"><?php echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y'); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Moneda de Transacción</div></div>
                    <div class="row">
                        <div class="col-md-4"><?php echo form_dropdown('idmoneda', $idmoneda) ?></div></div>
                    <div class="row">
                        <div class="col-md-4">Tipo de Cambio</div></div>
                    <div class="row">
                        <div class="col-md-4"><?php echo form_dropdown('idtasa_cambio',$idtasa_cambio); ?></div>
                        <div class="col-md-4 col-md-offset-4">Descripción de Asiento</div>
                        <div class="col-md-4 col-md-offset-4"><?php echo form_input($descripcion_asiento_diario) ?></div></div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Cta Contable</th>
                                <th>Descripción</th>
                                <th>Débito</th>
                                <th>Crédito</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td><?=  form_dropdown('idcuenta_contable', $idcuenta_contable);?></td>
                                <td><?php echo form_input($descripcion_cuenta_contable); ?></td>
                                <td><?php echo form_input($balance_debito); ?></td>
                                <td><?php echo form_input($balance_credito); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Balance</td>
                                <td><?php echo form_input($total_debito); ?></td>
                                <td><?php echo form_input($total_credito); ?></td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="#" class="btn btn-primary btn-lg " role="button">Guardar</a>
                    <a href="<?php echo base_url();?>index.php/AD/c_ad/listar" class="btn btn-default btn-lg " role="button">Cancelar</a>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>js/ajax-select.js"></script>
    </body>
</html>