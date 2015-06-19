<div class="container">
    <div class="row">
        <div class="span3 well ">
            <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Edición de Asiento de Diario Recurrente</h4><br>
            <div class="row"></br>
                <table class="table asiento">
                    <tr>
                   <td>Origen Asiento Diario 
                    <?= form_dropdown($idorigen_asiento_diario, $lista_origen_asiento_diario); ?></td>
                   <th>Fecha de Creacion</th>
                   <td><?php echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y'); ?></td>
                   <th rowspan="2">Descripción de Asiento
                       <textarea  placeholder="Descripcion del asiento de diario" id="descripcion_asiento_diario" class="textarea" maxlength="200"><?php echo $asiento_diario[0]['descripcion_asiento_diario_recurrente']; ?></textarea></th>
                </tr> 
                <tr>
                    <td>Moneda de Transacción
                        <div id="moneda"> 
                        <?php echo form_dropdown('idmoneda', $idmoneda); ?></div></td>
                    <th>Fecha de Edicion</th>
                    
                    <td>  <?php echo $asiento_diario[0]['fecha_creacion']; ?></td>
                    
                </tr>
                <tr>
                    <td>Tipo de Cambio<input type="text" readonly id="tasa_cambio" value="1" class="tasa_cambio">
                    <input type="hidden" id="idtasa_cambio" name="idtasa_cambio" value="1"></td></td>
                <th>Usuario Creacion:</th>
                <td> <input id="usuario_creacion" readonly="readonly" placeholder="usuario" size="4" value="<?php echo $asiento_diario[0]['usuario_creacion']; ?>"></input>

            <input id="usuario_edicion" type="hidden" placeholder="usuario edicion" size="10" value="cacao"></td>
                <th><div id="add-delete"><a class="btn btn-primary fa fa-plus fa-sm " role="button" id="agregar"></a></div>
                </tr>
            </table>
            <input id="valor_origen_ad" type="hidden" value="<?php echo $asiento_diario[0]['idorigen_asiento_diario']; ?>">

           <input type="hidden" id="recoge_fecha" value="<?php echo date('Y-m-d') ;?>">
            <!--///////////////////divs desordenados con proposito de insertar en db los datos///////////////////--> 
            <input id="valor_dolar" type="hidden" >
            <input id="usuario_creacion" type="hidden" value="cacao">
           <!---------------------------------------transacciones de asietos de diario------------------------------------------------>        
            <table class="table-striped">
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


            <div style="overflow:auto;height: 180px;">
                  <table class=" table table-striped valor" id="contenedor_transacciones">
                    <!---------------------------------------elemento a clonar------------------------------------------------>

                    <tr id="clone" style="display: none" class="">
                        <td><div class="numero_asiento"></div><input type="hidden" class="numero_transaccion" value=""></td>
                        <td> 
                            <div class="input-group"style="width: 150px;" >
                                <span class="input-group-btn">
                                    <button id="b_" class="btn btn-default buscar_cuenta" type="button"><i class="fa-search fa flg" ></i></button>
                                </span>
                                <input type="text" id="idcuenta_contable_" name="idcuenta_contable_" class="form-control buscar idcuenta_contable" readonly="readonly"  style="background:white;">
                              </div>
                        </td>
                        <td><input id="descripcion_cuenta_contable_" name='descripcion_cuenta_contable_' style="background:white;" readonly="readonly" maxlength=120 size=50 class='form-control' placeholder='Descripcion Cta. Contable'></td>
                        <td><input id="balance_debito_" name ='balance_debito_'  type="text" value="" maxlength='10' size='10' class='form-control campo_debito' placeholder='0.0'></td>
                        <td><input id="balance_credito_" name ='balance_credito_'  type="text" value="" maxlength='10' size='10' class='form-control campo_credito' placeholder='0.0'></td>

                        <td><a class="btn btn-primary quitar" role="button" style="margin-left:5px;">-</a></td>
                    </tr> 
                    <!--------------------------------------------------------------------------------------------------------->                

                    <tbody id="campos_agregados">
                        <?php
                        $i = 1;
                        foreach ($ad_detalle as $ad_detalle) {


                            echo"<tr id='" . $i . "' class='ad_detalle_editar agregado'>
                                
                            <td><div class='numero_asiento'>" . $i . "</div>
                                    <input type='hidden' class='numero_transaccion_editar' value='" . $i . "'>
                                    <input type='hidden' id='id_transaccion_editar' value='" .$ad_detalle['idasiento_diario_detalle_recurrente']. "'>
                                        </td>
                            <td><div class='input-group' style='width: 150px;' >
                            <span class='input-group-btn'>
                                        <button id='b_" . $i . "' class='btn btn-default buscar_cuenta'  type='button'><i class='fa-search fa flg'></i></button>
                                    </span>
                                    <input type='text' id='idcuenta_contable_" . $i . "' value='" . $ad_detalle['idcuenta_contable'] . "' class='form-control buscar idcuenta_contable' readonly='readonly'  style='background:white;'>
                                 </div>
                            </td>

                            <td><input id='descripcion_cuenta_contable_" . $i . "' value='' name ='descripcion_cuenta_contable'  style='background:white;' readonly='readonly' maxlength=120 size=50 class='form-control' placeholder='Descripcion Cta. Contable'></td>
                                
                            ";
                            if ($asiento_diario[0]['idtasa_cambio'] == 1) {
                                $monto = $ad_detalle['monto_moneda_nacional'];
                            } else if ($asiento_diario[0]['idtasa_cambio'] > 1) {
                                $monto = $ad_detalle['monto_moneda_extranjera'];
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
                                      
                                  <td><a class='btn btn-primary quitar' role='button' style='margin-left:5px;'>-</a></td>
                        </tr>";


                            $i++;
                        }
                        ?>

                    </tbody>
                </table>
            </div>    

            <button class="btn btn-primary btn-lg " id="editar">Editar</button>
            <a href="<?php echo base_url(); ?>index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/index" class="btn btn-default btn-lg " role="button">Cancelar</a>

            <div  style="float:right;" id="add-delete" class="col-md-4">
                <a class="btn btn-primary" role="button" id="agregar">+</a>
            </div>

            <div style="float:right;" class="col-md-4">
                <td><input id="total_debito" name ='total_debito' value="<?php echo $asiento_diario[0]['balance_debito']; ?>" type="text" readonly="readonly"  style="background:white;" maxlength=10 size=10 class='form-control' ></td>

                <td><input id="total_credito" name ='total_credito'value="<?php echo $asiento_diario[0]['balance_credito']; ?>" type="text" readonly="readonly"  style="background:white;" maxlength=10 size=10 class='form-control'></td>
            </div>
        </div>
    </div>
</div>