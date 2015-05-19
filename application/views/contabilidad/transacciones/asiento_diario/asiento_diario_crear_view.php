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
                <div class="col-md-4" id="tasa_cambio" style="z-index: 1000; position: absolute" ><?php print_r($idtasa_cambio); ?></div>
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
                            <input type="text" id="idcuenta_contable_" name="idcuenta_contable_" class="form-control buscar">
                            <span class="input-group-btn">
                                <button id="b_" class="btn btn-default buscar_cuenta" type="button"><i class="fa-search fa flg" ></i></button>
                            </span>
                        </div>
                    </td>
                    <td><input id="descripcion_cuenta_contable_" name='descripcion_cuenta_contable_' maxlength=120 size=50 class='form-control' placeholder='Descripcion Cta. Contable'></td>
                    <td><input id="balance_debito_" name ='balance_debito_' type="number" value="0" maxlength=10 size=10 class='form-control campo_debito' placeholder='Débito'></td>
                    <td><input id="balance_credito_" name ='balance_credito_' type="number" value="0" maxlength=10 size=10 class='form-control campo_credito' placeholder='Credito'></td>

                </tr> 
                <!--------------------------------------------------------------------------------------------------------->                
                <tbody id="campos_agregados">
                    <tr id="0">
                        <td><div class="numero_asiento">1</div><?php form_hidden("numero_asiento_0", 1) ?></td>
                        <td><div class="input-group"style="width: 150px;" >
                                <input type="text" id="idcuenta_contable_0" class="form-control buscar">
                                <span class="input-group-btn">
                                    <button id="b_0" class="btn btn-default buscar_cuenta"  type="button"><i class="fa-search fa flg" ></i></button>
                                </span>
                            </div>
                        </td>

                        <td><input id="descripcion_cuenta_contable_0" name ='descripcion_cuenta_contable' maxlength=120 size=50 class='form-control' placeholder='Descripcion Cta. Contable'></td>
                        <td><input id="balance_debito_0" name ='balance_debito_0' type="number" value="0" maxlength=10 size=10 class='form-control campo_debito' placeholder='Débito'></td>
                        <td><input id="balance_credito_0" name ='balance_credito_0'type="number" value="0" maxlength=10 size=10 class='form-control campo_credito' placeholder='Credito'></td>
                    </tr>
                </tbody>
                <div style="float:right;">
                    <td><input id="total_debito" name ='total_debito' type="number" maxlength=10 size=10 class='form-control' ></td>
                    <td><input id="total_credito" name ='total_credito'type="text" maxlength=10 size=10 class='form-control'></td>
                </div>
            </table>
            <a href="#" class="btn btn-primary btn-lg " role="button" id="guardar">Guardar</a>
            <a href="<?php echo base_url(); ?>index.php/contabilidad/transacciones/asiento_diario/asiento_diario/index" class="btn btn-default btn-lg " role="button">Cancelar</a>

            <div  style="float:right;" id="add-delete">
                <a class="btn btn-primary" role="button" id="agregar">+</a>
                <a class="btn btn-primary" role="button" id="quitar" style="margin-left:5px;">-</a>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>