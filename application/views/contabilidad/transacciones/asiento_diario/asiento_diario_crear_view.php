<div class="container"> </br></br></br>
    <div class="row">
        <div class="form-control">Asiento Recurrente</div>
        <div class="span3 well">


            <?= form_open(); ?> 
            <div class="row">
                <div class="col-md-4">Origen Asiento Diario</div>
                <div class="col-md-4 col-md-offset-4">Fecha de Creacion</div></div>
            <div class="row">
                <div class="col-md-4"><?= form_dropdown('idorigen_asiento_diario', $idorigen_asiento_diario); ?></div>
                <?php echo form_hidden('fecha_creacion', date('Y-m-d')); ?>

                <div class="col-md-4 col-md-offset-4"><?php echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y'); ?></div>
            </div>
            <div class="row">
                <div class="col-md-4">Moneda de Transacción</div></div>
            <div class="row">
                <div class="col-md-4" id="moneda"><?php echo form_dropdown('idmoneda', $idmoneda) ?></div></div>
            <div class="row">
                <div class="col-md-4">Tipo de Cambio</div></div>
            <div class="row">
                <div class="col-md-4" id="tasa_cambio" style="z-index: 1000; position: absolute" ><?php print_r($idtasa_cambio);?></div>
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
                
<!---------------------------------------elemento a clonar------------------------------------------------>
                
                    <tr id="clone" style="display: none">
                        <td><div class="numero_asiento"></div></td>
                        <td> 
                            <div class="input-group"style="width: 150px;" >
                                <input type="text"   class="form-control buscar">
                                <span class="input-group-btn">
                                    <button class="btn btn-default buscar_cuenta"   type="button"><i class="fa-search fa flg" ></i></button>
                                </span>
                            </div>
                        </td>
                        <td><?php echo form_input($descripcion_cuenta_contable); ?></td>
                        <td><?php echo form_input($balance_debito); ?></td>
                        <td><?php echo form_input($balance_credito); ?></td>
                    </tr> 
<!--------------------------------------------------------------------------------------------------------->                
                <tbody id="campos_agregados">
                    <tr id="jojo">
                        <td><div class="numero_asiento"></div></td>
                        <td><div class="input-group"style="width: 150px;" >
                                <input type="text" id="idcuenta_contable1" class="form-control buscar">
                                <span class="input-group-btn">
                                    <button id="b/0" class="btn btn-default buscar_cuenta"  type="button"><i class="fa-search fa flg" ></i></button>
                                </span>
                            </div>
                        </td>

                        <td><?php echo form_input($descripcion_cuenta_contable); ?></td>
                        <td><?php echo form_input($balance_debito); ?></td>
                        <td><?php echo form_input($balance_credito); ?></td>
                    </tr>
                </tbody>
            </table>
            <a href="#" class="btn btn-primary btn-lg " role="button" id="guardar">Guardar</a>
            <a href="<?php echo base_url(); ?>index.php/contabilidad/transacciones/asiento_diario/asiento_diario/index" class="btn btn-default btn-lg " role="button">Cancelar</a>

            <div  style="float:right;" id="add-delete">
                <a href="#" class="btn btn-primary" role="button" id="agregar">+</a>
                <a href="#" class="btn btn-primary" role="button" id="quitar" style="margin-left:5px;">-</a>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>