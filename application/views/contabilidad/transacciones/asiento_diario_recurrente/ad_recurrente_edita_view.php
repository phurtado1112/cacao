<input id="idasiento_diario_recurrente" type="hidden" value="<?php echo $asiento_diario[0]['idasiento_diario_recurrente']; ?>"></input>
<input id="valor_origen_ad" type="hidden" value="<?php echo $asiento_diario[0]['idorigen_asiento_diario']; ?>">
<input id="usuario_edicion_nuevo" type="hidden" value="<?= $this->session->userdata('user') ?>">
<input type="hidden" id="fecha_edicion_nueva" value="<?php echo date('Y-m-d'); ?>"> 
<input id="valor_dolar" type="hidden" >
<input id="usuario_creacion" type="hidden" value="cacao">

<div class="container">
    <div class="row">
        <div class="span3 well ">
            <h4 class="fa fa-align-justify fa-lg col-lg-offset-1"> Edición de Asiento de Diario Recurrente</h4>
            <div class="col-lg-3 dropdown col-lg-push-9" style="opacity: 0.5;"> 
                <?php echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y'); ?><!--fecha en formato de BD-->
            </div>
            <div class="row">
                <form class="form-horizontal">
                    <div class="alert alert-success cacao valor" role="alert" style="width: 98%; height: 190px; margin-left: 1%;"> 
                        <div class="row">

                            <div class="form-group col-lg-4">                     
                                <label class="col-lg-7">Origen Asiento Diario</label>
                                <div class="col-lg-4"> 
                                    <?= form_dropdown($idorigen_asiento_diario, $lista_origen_asiento_diario); ?>
                                </div></div>                 

                            <div class="form-group col-lg-4">  
                                <label class="col-lg-6">Usuario Creacion</label>
                                <div class="col-lg-6"> 
                                    <input disabled id="usuario_creacion" readonly="readonly" class="form-control" placeholder="usuario" value="<?php echo $asiento_diario[0]['usuario_creacion']; ?>"></input></div>
                            </div> 
                            <div class="form-group col-lg-4">  
                                <label class="col-lg-6">Usuario de ultima edicion</label>
                                <div class="col-lg-6"> 
                                    <input style="margin-left: -2px;" disabled readonly="readonly" class="form-control" value="<?php echo ($asiento_diario[0]['usuario_modificacion'] == null) ? "ND" : $asiento_diario[0]['usuario_modificacion']; ?> "></input>
                                </div> </div>
                        </div>
                        <div class="row">   
                            <div class="form-group col-lg-4">  
                                <label class="col-lg-7">Moneda de transaccion</label>
                                <div id="moneda" class="col-lg-5" style="margin-left: -15px;">
                                    <input id="idmoneda_actual" type="hidden" value="<?php echo $asiento_diario[0]['idmoneda']; ?>">
                                    <?php echo form_dropdown('idmoneda', $idmoneda, '', 'class="form-control"'); ?></div>
                            </div> 
                            <div class="form-group col-lg-4">  
                                <label class="col-lg-6">Fecha de Creacion</label>
                                <div id="moneda" class="col-lg-6" style="margin-left: 0px;"> 
                                    <input disabled type="input" class="form-control" readonly="readonly" value="<?php echo $asiento_diario[0]['fecha_creacion']; ?>"  style="width:143px;"></input>
                                </div>
                            </div>
                            <div class="form-group col-lg-4">  
                                <label class="col-lg-6">Fecha última edición</label>
                                <div id="moneda" class="col-lg-5" style=""> 
                                    <input disabled type="text" class="form-control" id="fecha_edicion" value="<?php echo($asiento_diario[0]['fecha_modificacion'] == null) ? "ND" : $asiento_diario[0]['fecha_modificacion']; ?>" readonly='readonly' style="width:143px;">
                                </div>
                            </div> 
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-lg-11"> 
                                <label class="col-lg-3">Descripción de Asiento</label>
                                <div class="form-group col-lg-5"> 
                                    <textarea  placeholder="Descripcion del asiento de diario" id="descripcion_asiento_diario" class="textarearecurrente" style="width: 500px; margin-left: -50px;" maxlength="200"><?php echo $asiento_diario[0]['descripcion_asiento_diario_recurrente']; ?></textarea>
                                    <input id="numero_asiento_diario" type="hidden">
                                </div></div>
                            <div class="form-group col-lg-1 col-lg-offset-5"> 
                                <a style="margin-left: 95%;" class="btn btn-success fa fa-plus fa-lg rec" role="button" id="agregar">  </a>
                            </div>                                       
                            <input id="usuario_creacion" type="hidden" value="<?= $this->session->userdata('user') ?>">
                        </div>
                    </div> 
                </form> 


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
                                    <input type="text" id="idcuenta_contable_" class="idcuenta_contable_" class="form-control buscar idcuenta_contable" style="background:white;">
                                    <span class="input-group-btn">
                                        <button id="b_" class="btn btn-default buscar_cuenta" type="button"><i class="fa-search fa flg" ></i></button>
                                    </span>
                                </div>
                            </td>
                            <td><input id="descripcion_cuenta_contable_" readonly="readonly" maxlength=120 size=50 class='form-control descripcion_cuenta_contable' placeholder='Descripcion Cta. Contable'></td>
                            <td><input id="balance_debito_" name ='balance_debito_'  type="text" value="" maxlength='10' size='10' class='form-control campo_debito' placeholder='0.0'></td>
                            <td><input id="balance_credito_" name ='balance_credito_'  type="text" value="" maxlength='10' size='10' class='form-control campo_credito' placeholder='0.0'></td>

                            <td><a class="btn btn-primary quitar fa fa-ban fa-sm" role="button" style="margin-left:5px;"></a></td>
                        </tr> 
                        <!--------------------------------------------------------------------------------------------------------->                

                        <tbody id="campos_agregados">

                            <?php
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
                                            <input type='text' id="idcuenta_contable_<?php echo $i ?>" value="<?php echo $ad_detalle['idcuenta_contable'] ?>" class='form-control buscar idcuenta_contable' style='background:white;'>
                                            <span class='input-group-btn'>
                                                <button id="b_<?php echo $i ?>" class='btn btn-default buscar_cuenta'  type='button'><i class='fa-search fa flg'></i></button>
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <input id="descripcion_cuenta_contable_<?php echo $i ?>" value='' disabled  readonly='readonly' maxlength=120 size=50 class='form-control descripcion_cuenta_contable' placeholder='Descripcion Cta. Contable'>
                                    </td>

                                    <?php
                                    $monto = $ad_detalle['monto_transaccion'];

                                    if ($ad_detalle['naturaleza_cuenta_contable'] == "D") {
                                        $debito = $monto;
                                        $credito = 0.0;
                                    } else if ($ad_detalle['naturaleza_cuenta_contable'] == "C") {
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
                </div><br> 
            <div class="form-group col-lg-12"> 
                <div class="form-group col-lg-6"> 
                    <button class="btn btn-success btn-lg fa fa-check fa-lg" id="editar">Editar</button>
                    <a href="<?php echo base_url(); ?>index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/index" class="btn btn-success btn-lg fa fa-close fa-lg" role="button">Cancelar</a>
                </div>
                <div class="form-group col-lg-5 col-lg-push-2">
                    <input disabled id="total_debito" name ='total_debito' value="<?php echo $asiento_diario[0]['balance_debito']; ?>" type="text" size=15 readonly class='col-lg-4 col-lg-pull-1'>
                    <input disabled id="total_credito" name ='total_credito' value="<?php echo $asiento_diario[0]['balance_credito']; ?>" type="text" size=15 readonly class='col-lg-4'>
                </div>
                 </div>  
             </div>
        </div>
    </div>
</div>