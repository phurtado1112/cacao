<div class="container">
    <div class="row">
        <div class="form-control">Edicion Asiento de Diario</div>
        <div class="span3 well">

            <div class="row">

                <div class="col-md-4">Origen Asiento Diario</div>

                <div class="col-md-4 col-md-offset-4">Fecha de Edicion</div>
                <div class="col-md-4 col-md-offset-4"  ><?php echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y'); ?></div>
                <input type="hidden" id="fecha_edicion" value="<?php echo date('Y-m-d') ?>"></input> 

                <div class="col-md-4 col-md-offset-4">
                    Fecha Fiscal
                    <input  type="text" id="fecha_fiscal" value="<?php echo $asiento_diario[0]['fecha_fiscal']; ?>"></input>
                    Fecha Creacion
                    <?php echo $asiento_diario[0]['fecha_creacion']; ?>
                </div>

            </div>

            <div class="row">
                <input id="valor_origen_ad" type="hidden" value="<?php echo $asiento_diario[0]['idorigen_asiento_diario']; ?>">
                <div class="col-md-4"><?= form_dropdown($idorigen_asiento_diario, $lista_origen_asiento_diario); ?></div>
            </div>

            <div class="row">
                <div class="col-md-4">Moneda de Transacción</div></div>
            <div class="row">
                <input id="valor_tasa_cambio_ad" type="hidden" value="<?php echo $asiento_diario[0]['idtasa_cambio']; ?>">
                <div class="col-md-4" id="moneda"><?php echo form_dropdown('idmoneda', $idmoneda); ?></div></div>
            <div class="row">
                <div class="col-md-4">Tipo de Cambio</div></div>
            <div class="row">

                <div class="col-md-4" >

                    <input type="text" readonly="reaonly" id="tasa_cambio" value="1" >
                    <input type="hidden" id="idtasa_cambio" name="idtasa_cambio" value="1">

                </div>

                <div class="col-md-4 col-md-offset-4">Descripción de Asiento</div>
                <div class="col-md-4 col-md-offset-4"><textarea  type="text" placeholder="Descripcion del asiento de diario" id="descripcion_asiento_diario" style="width: 300px;height: 80px"><?php echo $asiento_diario[0]['descripcion_asiento_diario']; ?></textarea></div>
            </div>
            <!--///////////////////divs desordenados con proposito de insertar en db los datos///////////////////--> 
            <input id="valor_dolar" type="hidden" ></input>
            Usuario Creacion:
            <input id="usuario_creacion" readonly="readonly" placeholder="usuario" size="4" value="<?php echo $asiento_diario[0]['usuario_creacion']; ?>"></input>

            <input id="usuario_edicion" type="hidden" placeholder="usuario edicion" size="10" value="cacao"></input>
            Numero Asiento diario:
            <input id="numero_asiento_diario" readonly="readonly" type="text" value="<?php echo $asiento_diario[0]['numero_asiento_diario']; ?>"></input>
            <!--/////////////////// id de asiento diario--->

            <input id="idasiento_diario" type="hidden" value="<?php echo $asiento_diario[0]['idasiento_diario']; ?>"></input>
            <!---------------------------------------transacciones de asietos de diario------------------------------------------------>        
            <div style="overflow:auto;height: 300px;">

                <table class="table table-striped" >
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
<!--<input type='hidden' id='idasiento_diario_detalle' value='".$ad_detalle['idasiento_diario_detalle']."'>-->
                    <tbody id="campos_agregados">
                        <?php
                        $i = 1;
                        foreach ($ad_detalle as $ad_detalle) {

                            if ($i > 2) {
                                $clase_extra = 'agregado';
                            } else {
                                $clase_extra = '';
                            }

                            echo"<tr id='" . $i . "' class='ad_detalle_editar " . $clase_extra . " '>
                                
                            <td><div class='numero_asiento'>" . $i . "</div><input type='hidden' class='numero_transaccion_editar' value='" . $i . "'></td>
                            <td><div class='input-group' style='width: 150px;' >
                                    <input type='text' id='idcuenta_contable_" . $i . "' value='" . $ad_detalle['idcuenta_contable'] . "' class='form-control buscar idcuenta_contable' readonly='readonly'  style='background:white;'>
                                    <span class='input-group-btn'>
                                        <button id='b_" . $i . "' class='btn btn-default buscar_cuenta'  type='button'><i class='fa-search fa flg'></i></button>
                                    </span>
                                </div>
                            </td>

                            <td><input id='descripcion_cuenta_contable_" . $i . "' value='' name ='descripcion_cuenta_contable'  style='background:white;' readonly='readonly' maxlength=120 size=50 class='form-control' placeholder='Descripcion Cta. Contable'></td>
                                
                            ";
                            if ($ad_detalle['monto_moneda_nacional'] !== "") {
                                $monto = $ad_detalle['monto_moneda_nacional'];
                            } else if ($ad_detalle['monto_moneda_extranjera'] != "") {
                                $monto = $ad_detalle['tipo_transaccion'];
                            }

                            if ($ad_detalle['tipo_transaccion'] == "d") {
                                $debito = $monto;
                                $credito = 0.0;
                            } else if ($ad_detalle['tipo_transaccion'] == "c") {
                                $debito = 0.0;
                                $credito = $monto;
                            }

                            echo "<td><input id='balance_debito_" . $i . "' name ='balance_debito_" . $i . "' type='text' value='" . $debito . "' maxlength=10 size=10 class='form-control campo_debito' placeholder='0.0'></td>
                                  <td><input id='balance_credito_" . $i . "' name ='balance_credito_" . $i . "' type='text' value='" . $credito . "' maxlength=10 size=10 class='form-control campo_credito' placeholder='0.0'></td>
                        </tr>";


                            $i++;
                        }
                        ?>



                    </tbody>

                </table>

            </div>    

            <button class="btn btn-primary btn-lg " id="editar">Editar</button>
            <a href="<?php echo base_url(); ?>index.php/contabilidad/transacciones/asiento_diario/asiento_diario/index" class="btn btn-default btn-lg " role="button">Cancelar</a>

            <div  style="float:right;" id="add-delete" class="col-md-4">
                <a class="btn btn-primary" role="button" id="agregar">+</a>
                <a class="btn btn-primary" role="button" id="quitar" style="margin-left:5px;">-</a>
            </div>

            <div style="float:right;" class="col-md-4">
                <td><input id="total_debito" name ='total_debito' value="<?php echo $asiento_diario[0]['balance_debito']; ?>" type="text" readonly="readonly"  style="background:white;" maxlength=10 size=10 class='form-control' ></td>

                <td><input id="total_credito" name ='total_credito'value="<?php echo $asiento_diario[0]['balance_credito']; ?>" type="text" readonly="readonly"  style="background:white;" maxlength=10 size=10 class='form-control'></td>
            </div>
        </div>
    </div>
</div>