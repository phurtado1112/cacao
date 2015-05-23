<div class="container"> </br></br></br>
    <div class="row">
        <div class="form-control">Asiento Recurrente</div>
        <div class="span3 well">

            <div class="row">

                <div class="col-md-4">Origen Asiento Diario</div>

                <div class="col-md-4 col-md-offset-4">Fecha de Creacion</div>
                <input  type="text" id="recoge_fecha"></input>   

            <div class="col-md-4 col-md-offset-4">
                Fecha Fiscal
                <input  type="text" id="fecha_fiscal"></input>
            </div>

        </div>

        <div class="row">
            <div class="col-md-4"><?= form_dropdown('idorigen_asiento_diario', $idorigen_asiento_diario); ?></div>
        </div>

        <div class="row">
            <div class="col-md-4">Moneda de Transacción</div></div>
        <div class="row">
            <div class="col-md-4" id="moneda"><?php echo form_dropdown('idmoneda', $idmoneda); ?></div></div>
        <div class="row">
            <div class="col-md-4">Tipo de Cambio</div></div>
        <div class="row">
            <div class="col-md-4" style="z-index: 1000; position: absolute">
                
                <input type="text" disabled value="1" id="tasa_cambio"  >

                <input type="hidden" id="idtasa_cambio" name="idtasa_cambio" maxlength="4" size="4" value="1"> </input></div>

            <div class="col-md-4 col-md-offset-4">Descripción de Asiento</div>
            <div class="col-md-4 col-md-offset-4"><input  type="text" placeholder="Descripcion AD" id="descripcion_asiento_diario"></input></div>
        </div>
        <!--///////////////////divs desordenados con proposito de insertar en db los datos///////////////////--> 
        <input id="usuario_creacion"  placeholder="usuario" size="4"></input>
        
        <input id="numero_asiento_diario" placeholder="Numero AD" class="col-md-4 col-md-offset-4"></input>

        <!---------------------------------------transacciones de asietos de diario------------------------------------------------>        
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

            <tr id="clone" style="display: none" class="">
                <td><div class="numero_asiento"></div><input type="hidden" class="numero_transaccion" value=""></td>
                <td> 
                    <div class="input-group"style="width: 150px;" >
                        <input type="text" id="idcuenta_contable_" name="idcuenta_contable_" class="form-control buscar idcuenta_contable" readonly="readonly"  style="background:white;">
                        <span class="input-group-btn">
                            <button id="b_" class="btn btn-default buscar_cuenta" type="button"><i class="fa-search fa flg" ></i></button>
                        </span>
                    </div>
                </td>
                <td><input id="descripcion_cuenta_contable_" name='descripcion_cuenta_contable_' style="background:white;" readonly="readonly" maxlength=120 size=50 class='form-control' placeholder='Descripcion Cta. Contable'></td>
                <td><input id="balance_debito_" name ='balance_debito_'  type="text" value="" maxlength='10' size='10' class='form-control campo_debito' placeholder='0.0'></td>
                <td><input id="balance_credito_" name ='balance_credito_'  type="text" value="" maxlength='10' size='10' class='form-control campo_credito' placeholder='0.0'></td>

            </tr> 
            <!--------------------------------------------------------------------------------------------------------->                
            <tbody id="campos_agregados">
                <tr id="1" class="asiento_diario_detalle">
                    <td><div class="numero_asiento">1</div><input type="hidden" class="numero_transaccion" value="1"></td>
                    <td><div class="input-group"style="width: 150px;" >
                            <input type="text" id="idcuenta_contable_1" class="form-control buscar idcuenta_contable" readonly="readonly"  style="background:white;">
                            <span class="input-group-btn">
                                <button id="b_1" class="btn btn-default buscar_cuenta"  type="button"><i class="fa-search fa flg" ></i></button>
                            </span>
                        </div>
                    </td>

                    <td><input id="descripcion_cuenta_contable_1" name ='descripcion_cuenta_contable'  style="background:white;" readonly="readonly" maxlength=120 size=50 class='form-control' placeholder='Descripcion Cta. Contable'></td>
                    <td><input id="balance_debito_1" name ='balance_debito_0' type="text" value="" maxlength=10 size=10 class='form-control campo_debito' placeholder='0.0'></td>
                    <td><input id="balance_credito_1" name ='balance_credito_0' type="text" value="" maxlength=10 size=10 class='form-control campo_credito' placeholder='0.0'></td>
                </tr>
            </tbody>
            <div style="float:right;">
                <td><input id="total_debito" name ='total_debito' value="0.0" type="text" readonly="readonly"  style="background:white;" maxlength=10 size=10 class='form-control' ></td>
                <td><input id="total_credito" name ='total_credito'value="0.0" type="text" readonly="readonly"  style="background:white;" maxlength=10 size=10 class='form-control'></td>
            </div>
        </table>
        <button class="btn btn-primary btn-lg " id="guardar">Guardar</button>
        <a href="<?php echo base_url(); ?>index.php/contabilidad/transacciones/asiento_diario/asiento_diario/index" class="btn btn-default btn-lg " role="button">Cancelar</a>

        <div  style="float:right;" id="add-delete">
            <a class="btn btn-primary" role="button" id="agregar">+</a>
            <a class="btn btn-primary" role="button" id="quitar" style="margin-left:5px;">-</a>
        </div>
    </div>
</div>
</div>