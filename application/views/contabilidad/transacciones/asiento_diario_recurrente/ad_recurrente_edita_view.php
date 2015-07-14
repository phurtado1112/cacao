<input id="idasiento_diario_recurrente" type="hidden" value="<?php echo $asiento_diario[0]['idasiento_diario_recurrente']; ?>"></input>
<input id="valor_origen_ad" type="hidden" value="<?php echo $asiento_diario[0]['idorigen_asiento_diario']; ?>">
<input id="usuario_edicion" type="hidden" placeholder="usuario edicion" size="10" value="<?= $this->session->userdata('user') ?>">
<input type="hidden" id="recoge_fecha" value="<?php echo date('Y-m-d'); ?>"> 
<input id="valor_dolar" type="hidden" >
<input id="usuario_creacion" type="hidden" value="cacao">

<div class="container">
    <div class="row">
        <div class="span3 well ">
            <h4 class="fa fa-align-justify fa-lg col-lg-offset-4"> Edición de Asiento de Diario Recurrente</h4><br>
            <div class="row"></br>
                <table class="table asiento">
                    <tr>
                        <td>Origen Asiento Diario 
                            <?= form_dropdown($idorigen_asiento_diario, $lista_origen_asiento_diario); ?>
                        </td>
                        <td>Usuario Creacion:
                            <input disabled id="usuario_creacion" readonly="readonly" class="form-control" placeholder="usuario" value="<?php echo $asiento_diario[0]['usuario_creacion']; ?>"  style="width:150px;"></input>
                        </td>
                        <td>Usuario de Ultima Edicion:
                            <input disabled readonly="readonly" class="form-control" value="<?php echo ($asiento_diario[0]['usuario_modificacion']==null)? "ND": $asiento_diario[0]['usuario_modificacion']; ?>"  style="width:150px;"></input>
                        </td>
                        <td rowspan="3">Descripción de Asiento
                            <textarea class="form-control has-error" id="descripcion_asiento_diario" maxlength="200" style="resize: none;width: 280px;height: 110px;" ><?php echo $asiento_diario[0]['descripcion_asiento_diario_recurrente']; ?>
                            </textarea>
                        </td>
                    </tr> 
                    <tr>
                        <td>Moneda de Transacción
                            <div id="moneda"> 
                                <?php echo form_dropdown($tipo_moneda, $idmoneda); ?>
                            </div>
                        </td>
                        <td>Fecha de Creacion
                            <input disabled type="input" class="form-control" readonly="readonly" value="<?php echo $asiento_diario[0]['fecha_creacion']; ?>"  style="width:100px;"></input>
                        </td>
                        <td>Fecha de Ultima Edicion
                            <input disabled type="text" class="form-control" id="fecha_edicion" value="<?php echo($asiento_diario[0]['fecha_modificacion']==null)? "ND": $asiento_diario[0]['fecha_modificacion']; ?>" readonly='readonly' style="width:100px;">
                        </td>
                    </tr>
                </table>

                <!---------------------------------------transacciones de asietos de diario------------------------------------------------>        
                <table class="table-striped">
                    <thead>
                        <tr>
                            <th style="padding:15px 15px 15px 10px;">No.</th>
                            <th style="padding:15px 280px 15px 15px;">Cta Contable</th>
                            <th style="padding:15px 240px 15px 15px;">Descripción</th>
                            <th style="padding:15px 100px 15px 15px;">Débito</th>
                            <th style="padding:15px;">Crédito</th>
                        </tr>
                    </thead>
                </table>

                <div style="overflow:auto;height: 220px;" class="valor">
                    <table class=" table table-striped " id="contenedor_transacciones">
                        <!---------------------------------------elemento a clonar------------------------------------------------>

                        <tr id="clone" style="display: none" class="">
                            <td><div class="numero_asiento"></div><input type="hidden" class="numero_transaccion" value=""></td>
                            <td> 
                                <div class="input-group"style="width: 150px;" >
                                    <span class="input-group-btn">
                                        <button id="b_" class="btn btn-default buscar_cuenta" type="button"><i class="fa-search fa flg" ></i></button>
                                    </span>
                                    <input disabled type="text" id="idcuenta_contable_" name="idcuenta_contable_" class="form-control buscar idcuenta_contable" readonly="readonly"  style="background:white;">
                                </div>
                            </td>
                            <td><input id="descripcion_cuenta_contable_" name='descripcion_cuenta_contable_' style="background:white;" readonly="readonly" maxlength=120 size=50 class='form-control' placeholder='Descripcion Cta. Contable'></td>
                            <td><input id="balance_debito_" name ='balance_debito_'  type="text" value="" maxlength='10' size='10' class='form-control campo_debito' placeholder='0.0'></td>
                            <td><input id="balance_credito_" name ='balance_credito_'  type="text" value="" maxlength='10' size='10' class='form-control campo_credito' placeholder='0.0'></td>

                            <td><a class="btn btn-primary quitar fa fa-ban fa-sm" role="button" style="margin-left:5px;"></a></td>
                        </tr> 
                        <!--------------------------------------------------------------------------------------------------------->                

                        <tbody id="campos_agregados">

                            <?php
//                            print_r($asiento_diario[0]);
                            $i = 1;
                            foreach ($ad_detalle as $ad_detalle) {
                                ?>

                                <tr id="<?php echo $i ?>" class='ad_detalle_editar agregado'>

                                    <td><div class='numero_asiento'><?php echo $i ?></div>
                                        <input type='hidden' class='numero_transaccion_editar' value="<?php echo $i ?>">
                                        <input type='hidden' id='id_transaccion_editar' value="<?php echo $ad_detalle['numero_transaccion'] ?>">
                                    </td>
                                    <td>
                                        <div class='input-group' style='width: 150px;' >
                                            <span class='input-group-btn'>
                                                <button id="b_<?php echo $i ?>" class='btn btn-default buscar_cuenta'  type='button'><i class='fa-search fa flg'></i></button>
                                            </span>
                                            <input disabled type='text' id="idcuenta_contable_<?php echo $i ?>" value="<?php echo $ad_detalle['idcuenta_contable'] ?>" class='form-control buscar idcuenta_contable' readonly='readonly'  style='background:white;'>
                                        </div>
                                    </td>
                                    <td>
                                        <input id="descripcion_cuenta_contable_<?php echo $i ?>" value='' disabled name ='descripcion_cuenta_contable'  style='background:white;' readonly='readonly' maxlength=120 size=50 class='form-control' placeholder='Descripcion Cta. Contable'>
                                    </td>

                                    <?php
                                    $monto = $ad_detalle['monto_transaccion'];

                                    if ($ad_detalle['naturaleza_cuenta_contable'] == "d") {
                                        $debito = $monto;
                                        $credito = 0.0;
                                    } else if ($ad_detalle['naturaleza_cuenta_contable'] == "a") {
                                        $debito = 0.0;
                                        $credito = $monto;
                                    }
                                    ?>

                                    <td><input id="balance_debito_<?php echo $i ?>" name ="balance_debito_<?php echo $i ?>" type='text' value="<?php echo $debito ?>" maxlength=10 size=10 class='form-control campo_debito ' placeholder='0.0'></td>
                                    <td><input id="balance_credito_<?php echo $i ?>" name ="balance_credito_<?php echo $i ?>" type='text' value="<?php echo $credito ?>" maxlength=10 size=10 class='form-control campo_credito' placeholder='0.0'></td>

                                    <td><a class='btn btn-primary quitar fa fa-ban fa-sm' role='button' style='margin-left:5px;'></a></td>
                                </tr>

                                <?php
                                $i++;
                            }
                            ?>

                        </tbody>
                    </table>
                </div> 
                
                <div class="row divboton col-sm-pull-4"> 
                    <div class="row col-md-offset-8 form-inline" >
                        <input disabled id="total_debito" name ='total_debito' value="0.0" type="text" size=15 readonly class='col-lg-4 valorDC form-control in'>
                        <input disabled id="total_credito" name ='total_credito' value="0.0" type="text" size=15 readonly class='col-lg-4  valorDC form-control'>
                            <a class="btn btn-primary fa fa-plus fa-sm" role="button" id="agregar" ></a>
                    </div>
                    <div style="padding-left: 15px;"> 
                        <button class="btn btn-success btn-lg" id="guardar"> Editar</button>
                        <a href="<?php echo base_url(); ?>index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/index" class="btn btn-success btn-lg " role="button">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>