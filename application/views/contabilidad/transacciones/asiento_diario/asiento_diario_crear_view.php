<div class="container diario">
    <div class="row">
        <div class="span3 well ">
            <div class="row"> 
                <h4 class="fa fa-align-justify fa-lg col-lg-offset-2"> Asiento de Diario</h4>
                <div class="col-lg-3 dropdown col-lg-push-9" style="opacity: 0.5;"> 
                    <?php echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y'); ?>
                    <input type="hidden" id="recoge_fecha" value="<?php echo date('Y-m-d') ?>"><!--fecha en formato de BD-->
                </div>
            </div>
            <div class="row">
                <form class="form-horizontal">
                    <div class="alert alert-success cacao valor" role="alert" style="width: 98%; height: 150px;; margin-left: 1%;"> 
                        <div class="form-group row">

                            <div class="form-group col-lg-4">                     
                                <label class="col-lg-6">Origen Asiento Diario</label>
                                <div class="col-lg-5"> 
                                    <input type="hidden" id='valor_origen_ad' value='<?php if ($asiento_diario_recurrente != "") {
                        echo $asiento_diario_recurrente[0]['idorigen_asiento_diario'];
                    } ?>'>
                                    <?= form_dropdown($idorigen_asiento_diario, $lista_origen_asiento_diario); ?>
                                </div></div> 

                            <div class="form-group col-lg-3">  
                                <label class="col-lg-6 ">Fecha Fiscal</label>
                                <input class="col-lg-6 form-control fecha" type="text"  id="fecha_fiscal" value="<?php echo date('Y-m-d') ?>">
                            </div>

                            <div class="form-group col-lg-3">  
                                <label class="col-lg-4">Moneda</label>
                                <div id="moneda" class="col-lg-6"> 
                                    <?php echo form_dropdown('idmoneda', $idmoneda, '', 'class="form-control"'); ?></div>
                            </div>

                            <div class="form-group col-lg-3">
                                <label class="col-lg-6">Tipo Cambio</label>
                                <div class="col-lg-6"> 
                                    <input type="text" readonly id="tasa_cambio" value="1" class="form-control">
                                    <input type="hidden" id="idtasa_cambio" name="idtasa_cambio" value="<?php if($asiento_diario_recurrente != ""){echo $asiento_diario_recurrente[0]["idmoneda"]; }else{ echo 1;} ?>" >
                                    <input id="valor_moneda_extranjera" type="hidden" >
                                </div> 
                            </div> 
                        </div>

                        <div class="form-group">
                            <div class="form-group col-lg-12">  
                                <label class="col-lg-3">Descripción de Asiento</label>
                                <div class="form-group col-lg-4"> 
                                    <textarea  placeholder="Descripcion del asiento de diario" id="descripcion_asiento_diario" class="textarea" style="margin-left: -85px;" maxlength="200"><?php if ($asiento_diario_recurrente != "") {
                                     echo $asiento_diario_recurrente[0]['descripcion_asiento_diario_recurrente'];
                                        } ?></textarea>
                                    <input id="numero_asiento_diario" type="hidden">
                                </div>
                                <div class="form-group col-lg-4 col-lg-push-3"> 
                                    <a style="margin-left:28px;" id="listar_adr" class="btn btn-success fa fa-plus-circle fa-lg rec"
                                       href="http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente">
                                        A. Recurrente</a> <a style="margin-left:3px;" class="btn btn-success fa fa-plus fa-lg rec" role="button" id="agregar"> 
                                    </a>
                                    <input id="usuario_creacion" type="hidden" value="<?= $this->session->userdata('user') ?>">
                                </div>
                            </div>
                        </div>
                    </div>        
                </form>                         

                <div><!--boton para agregar AD recurrente--></div>

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
                <div style="overflow:auto;height: 240px; width: 98%; margin-left: 1%;" class="valor">
                    <table class="table table-striped"  id="contenedor_transacciones">
                        <!---------------------------------------elemento a clonar------------------------------------------------>
                        <tr id="clone" style="display: none" class="">
                            <td><div class="numero_asiento"></div><input type="hidden" class="numero_transaccion" value=""></td>
                            <td> 
                                <div class="input-group" style="width: 150px;" >
                                    <input type="text" id="idcuenta_contable_" name="idcuenta_contable_" class="form-control buscar idcuenta_contable" >
                                     <span class="input-group-btn">
                                        <button id="b_" class="btn btn-default buscar_cuenta" type="button"><i class="fa-search fa flg" ></i></button>
                                    </span>
                                </div>
                            </td>
                            <td><input id="descripcion_cuenta_contable_" class='descripcion_cuenta_contable form-control' disabled readonly="readonly" maxlength=120 size=50 placeholder='Descripcion Cta. Contable'></td>
                            <td><input id="balance_debito_" name ='balance_debito_'  type="text" value="" maxlength='14' size='10' class='form-control campo_debito' placeholder='0.0'></td>
                            <td><input id="balance_credito_" name ='balance_credito_'  type="text" value="" maxlength='14' size='10' class='form-control campo_credito' placeholder='0.0'></td>

                            <td><a class="btn btn-primary quitar fa fa-ban fa-sm" role="button" style="margin-left:5px;"></a></td>
                        </tr> 
                        <!--------------------------------------------------------------------------------------------------------->                

                        <tbody id="campos_agregados">
                            <?php
                            $i = 1;
                            if ($ad_detalle_recurrente != "") {
                                foreach ($ad_detalle_recurrente as $ad_detalle) {


                                    echo"<tr id='" . $i . "' class='asiento_diario_detalle agregado'>
                                
                            <td><div class='numero_asiento'>" . $i . "</div>
                                    <input type='hidden' class='numero_transaccion' value='" . $i . "'></td>
                            <td><div class='input-group' style='width: 150px;' >
                                    <input type='text' id='idcuenta_contable_" . $i . "' value='" . $ad_detalle['idcuenta_contable'] . "' class='form-control buscar idcuenta_contable' readonly='readonly'  style='background:white;'>
                                         <span class='input-group-btn'>
                                        <button id='b_" . $i . "' class='btn btn-default buscar_cuenta'  type='button'><i class='fa-search fa flg'></i></button>
                                    </span>
                                 </div>
                            </td>

                            <td><input id='descripcion_cuenta_contable_" . $i . "' value='' class ='descripcion_cuenta_contable form-control' disabled readonly='readonly' maxlength=120 size=50 placeholder='Descripcion Cta. Contable'></td>
                                
                            ";
//                                   
                                    $monto = $ad_detalle['monto_transaccion'];
                                    
                                    if ($ad_detalle['naturaleza_cuenta_contable'] == "D") {
                                        $debito = $monto;
                                        $credito = 0.0;
                                    } else if ($ad_detalle['naturaleza_cuenta_contable'] == "C") {
                                        $debito = 0.0;
                                        $credito = $monto;
                                    }

                                    echo "<td><input id='balance_debito_" . $i . "' name ='balance_debito_" . $i . "' type='text' value='" . $debito . "' maxlength=10 size=10 class='form-control campo_debito' placeholder='0.0'></td>
                                  <td><input id='balance_credito_" . $i . "' name ='balance_credito_" . $i . "' type='text' value='" . $credito . "' maxlength=10 size=10 class='form-control campo_credito' placeholder='0.0'></td>
                                      
                                  <td><a class='btn btn-primary quitar fa fa-ban fa-sm' role='button' style='margin-left:5px;'></a></td>
                        </tr>";


                                    $i++;
                                }
                            } else {
                                echo '<tr id="1" class="asiento_diario_detalle agregado">
                    <td><div class="numero_asiento">1</div><input type="hidden" class="numero_transaccion" value="1"></td>
                    <td><div class="input-group"style="width: 150px;" >
                            <input type="text" id="idcuenta_contable_1" class="form-control buscar idcuenta_contable" style="background:white;">
                            <span class="input-group-btn">
                                <button id="b_1" class="btn btn-default buscar_cuenta"  type="button"><i class="fa-search fa flg" ></i></button>
                            </span>
                        </div>
                    </td>

                    <td><input id="descripcion_cuenta_contable_1" class ="descripcion_cuenta_contable form-control" disabled readonly="readonly" maxlength=120 size=50 placeholder="Descripcion Cta. Contable"></td>
                    <td><input id="balance_debito_1" name ="balance_debito_0" type="text" value="" maxlength=14 size=10 class="form-control campo_debito" placeholder="0.0"></td>
                    <td><input id="balance_credito_1" name ="balance_credito_0" type="text" value="" maxlength=14 size=10 class="form-control campo_credito" placeholder="0.0"></td>
                    
                    <td><a class="btn btn-primary quitar fa fa-ban fa-sm" role="button" style="margin-left:5px;"></a></td>
                </tr>
                <tr id="2" class="asiento_diario_detalle agregado">
                    <td><div class="numero_asiento">2</div><input type="hidden" class="numero_transaccion" value="2"></td>
                    <td><div class="input-group"style="width: 150px;" >
                        <input type="text" id="idcuenta_contable_2" class="form-control buscar idcuenta_contable"  style="background:white;">
                        <span class="input-group-btn">
                                <button id="b_2" class="btn btn-default buscar_cuenta"  type="button"><i class="fa-search fa flg" ></i></button>
                            </span>
                        </div>
                    </td>

                    <td><input id="descripcion_cuenta_contable_2" class ="descripcion_cuenta_contable form-control" disabled readonly="readonly" maxlength=120 size=50 placeholder="Descripcion Cta. Contable"></td>
                    <td><input id="balance_debito_2" name ="balance_debito_1" type="text" value="" maxlength=14 size=10 class="form-control campo_debito" placeholder="0.0"></td>
                    <td><input id="balance_credito_2" name ="balance_credito_1" type="text" value="" maxlength=14 size=10 class="form-control campo_credito" placeholder="0.0"></td>
                   
                    <td><a class="btn btn-primary quitar fa fa-ban fa-sm" role="button" style="margin-left:5px;"></a></td>
                </tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                    <div id="add-delete"></div>
                </div><br> 
                <div class="form-group col-lg-12"> 
                    <div class="form-group col-lg-6"> 
                        <button class="btn btn-success btn-lg fa fa-check fa-lg" id="guardar">Guardar</button>
                        <a href="<?php echo base_url(); ?>index.php/contabilidad/transacciones/asiento_diario/asiento_diario/index" class="btn btn-success btn-lg fa fa-close fa-lg" role="button">Cancelar</a>
                    </div>
                    <div class="form-group col-lg-5 col-lg-push-2">
                        <input id="total_debito" name ='total_debito' value="<?php if ($asiento_diario_recurrente != "") {
                                echo $asiento_diario_recurrente[0]['balance_debito'];
                            } else {
                                echo "0.0";
                            } ?>" type="text" readonly class='col-lg-4 col-lg-pull-1'>
                        <input id="total_credito" name ='total_credito' value="<?php if ($asiento_diario_recurrente != "") {
                                echo $asiento_diario_recurrente[0]['balance_credito'];
                            } else {
                                echo "0.0";
                            } ?>" readonly class='col-lg-4'>
                    </div>
                </div>
            </div>
        </div>
    </div>