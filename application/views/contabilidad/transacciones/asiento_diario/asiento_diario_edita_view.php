<div class="container diario">
    <div class="row">
        <div class="span3 well">
            <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Edicion Asiento de Diario</h4>
            <div class="row"></br>
               <table class="table asiento">
                <tr>
                    <td>Origen Asiento Diario
                    <input type="hidden" id='valor_origen_ad' value='<?php if($asiento_diario_recurrente!=""){ echo $asiento_diario_recurrente[0]['idorigen_asiento_diario'];}?>'>
                    <?= form_dropdown($idorigen_asiento_diario, $lista_origen_asiento_diario); ?> </td>
                    <th>Fecha de Creacion</th>
                    <td><?php echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y'); ?>
                     <input type="hidden" id="recoge_fecha" value="<?php echo date('Y-m-d') ?>"><!--fecha en formato de BD--></td>
                    <th rowspan="2">Descripción de Asiento
                    <textarea  placeholder="Descripcion del asiento de diario" id="descripcion_asiento_diario" class="textarea"><?php echo $asiento_diario[0]['descripcion_asiento_diario']; ?></textarea>
                    </th>
                </tr> 
                <tr>
                    <td>Moneda de Transacción
                        <div id="moneda"> 
                        <?php echo form_dropdown('idmoneda', $idmoneda); ?></div></td>
                    <th>Fecha Fiscal</th>
                    <td><input class="col-lg-1 fecha" type="text" id="fecha_fiscal" value="<?php echo $asiento_diario[0]['fecha_fiscal']; ?>"></td>
                </tr>
                 <tr>
                    <td>Tipo de Cambio
                        <input type="text" readonly id="tasa_cambio" value="1" class="tasa_cambio" style="width: 60px;">
                    <input type="hidden" id="idtasa_cambio" name="idtasa_cambio" value="1">
                    <input id="valor_dolar" type="hidden" ></td>
                    <th>Numero Asiento diario:</th><td><input id="numero_asiento_diario" readonly="readonly" type="text" value="<?php echo $asiento_diario[0]['numero_asiento_diario']; ?>"></td>
                    <th><input id="valor_dolar" type="hidden" >
                   Usuario Creacion:
                <input id="usuario_creacion" readonly="readonly" placeholder="usuario" size="4" value="<?php echo $asiento_diario[0]['usuario_creacion']; ?>">
                <input id="usuario_edicion" placeholder="usuario edicion"  value="cacao" hidden>
                    <a style="margin-left:50px;" class="btn btn-success fa fa-plus fa-lg rec" role="button" id="agregar"> Cuenta</a></th>
                </tr>
                <input id="valor_origen_ad" hidden value="<?php echo $asiento_diario[0]['idorigen_asiento_diario']; ?>">
                <input id="valor_tasa_cambio_ad" hidden value="<?php echo $asiento_diario[0]['idtasa_cambio']; ?>">
                <tr>
           <!--/////////////////// id de asiento diario--->
                <input id="idasiento_diario" type="hidden" value="<?php echo $asiento_diario[0]['idasiento_diario']; ?>">
               </table>
                
            <!---------------------------------------transacciones de asietos de diario------------------------------------------------>        
            <table class="table-striped ">
                <thead ><!---style="position: absolute;margin-bottom: 50px;"-->
                    <tr>
                        <th style="padding:15px 15px 15px 10px;">No.</th>
                        <th style="padding:15px 280px 15px 15px;">Cta Contable</th>
                        <th style="padding:15px 240px 15px 15px;">Descripción</th>
                        <th style="padding:15px 100px 15px 15px;">Débito</th>
                        <th style="padding:15px;">Crédito</th>
                    </tr>
                </thead>
            </table>
            <div style="overflow:auto;height:180px;" class="valor">
                <table class=" table table-striped ">
                    <!---------------------------------------elemento a clonar------------------------------------------------>
                    <tr id="clone" style="display: none" class="">
                        <td><div class="numero_asiento"></div><input type="hidden" class="numero_transaccion" value=""></td>
                        <td> 
                            <div class="input-group" style="width: 150px;" >
                                <input type="text" id="idcuenta_contable_" name="idcuenta_contable_" class="form-control buscar idcuenta_contable" readonly="readonly"  style="background:white;">
                                <span class="input-group-btn">
                                    <button id="b_" class="btn btn-default buscar_cuenta" type="button"><i class="fa-search fa flg" ></i></button>
                                </span>
                            </div>
                        </td>
                        <td><input id="descripcion_cuenta_contable_" name='descripcion_cuenta_contable_' style="background:white;" readonly="readonly" maxlength=120 size=50 class='form-control' placeholder='Descripcion Cta. Contable'></td>
                        <td><input id="balance_debito_" name ='balance_debito_'  type="text" value="" maxlength='10' size='10' class='form-control campo_debito' placeholder='0.0'></td>
                        <td><input id="balance_credito_" name ='balance_credito_'  type="text" value="" maxlength='10' size='10' class='form-control campo_credito' placeholder='0.0'></td>
                        <td><a class="btn btn-primary quitar fa fa-ban fa-sm" role="button" style="margin-left:5px;"></a></td>
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
                            echo"<tr id='" . $i . "' class='ad_detalle_editar agregado" . $clase_extra . " '>                               
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
                                      
                                  <td><a class='btn btn-primary quitar fa fa-ban fa-sm' role='button' style='margin-left:5px;'></a></td>
                        </tr>";
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>    
            <div class="row divboton col-sm-pull-4"> 
                <div class="row col-md-offset-8">
                    <input id="total_debito" name ='total_debito' value="<?php echo $asiento_diario[0]['balance_debito']; ?>" type="text" readonly class='col-lg-4 valorDC'>
                    <input id="total_credito" name ='total_credito' value="<?php echo $asiento_diario[0]['balance_credito']; ?>" readonly class='col-lg-4  col-xs-push-1 valorDC'>
                </div>
                <div style="padding-left: 15px;"> 
                    <button class="btn btn-success btn-lg fa fa-save fa-lg" id="editar">Guardar</button>
                    <a href="<?php echo base_url(); ?>index.php/contabilidad/transacciones/asiento_diario/asiento_diario/index" class="btn btn-success btn-lg fa fa-close fa-lg" role="button">Cancelar</a>
                </div>
            </div>     
        </div>
    </div>
</div>

