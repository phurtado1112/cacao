<div class="container diario">
    <div class="row">
        <div class="span3 well">
            <h4 class="fa fa-align-justify fa-lg col-lg-offset-2"> Edicion Asiento de Diario</h4>
                        <div class="col-lg-3 dropdown col-lg-push-9" style="opacity: 0.5;"> 
                       <?php echo $dias[date('w')] . " " . date('d') . " de " . $meses[date('n') - 1] . " del " . date('Y'); ?>
                    <input type="hidden" id="fecha_edicion" value="<?php echo date('Y-m-d') ?>">
                    </div>
            <div class="row">
                <form class="form-horizontal">
                <div class="alert alert-success cacao valor" role="alert" style="width: 98%; height: 150px;; margin-left: 1%;"> 
                <div class="form-group row">
                    
                    <div class="form-group col-lg-4">                     
                    <label class="col-lg-7">Número Asiento Diario</label>
                    <div class="col-lg-5"> 
                        <input class="form-control" id="idasiento_diario" readonly type="text" value="<?php echo $asiento_diario[0]['idasiento_diario']; ?>">
                    </div></div> 
                    
                    <div class="form-group col-lg-3">  
                    <label class="col-lg-6 ">Fecha Fiscal</label>
                    <input class="col-lg-6 form-control fecha" type="text"  id="fecha_fiscal" value="<?php echo $asiento_diario[0]['fecha_fiscal']; ?>">
                    </div>
                    
                    <div class="form-group col-lg-3">  
                    <label class="col-lg-4">Moneda</label>
                    <div id="moneda" class="col-lg-6"> 
                        <?php echo form_dropdown('idmoneda', $idmoneda,'','class="form-control"'); ?></div>
                    </div>
                    
                    <div class="form-group col-lg-3">
                    <label class="col-lg-6">Tipo Cambio</label>
                    <div class="col-lg-6"> 
                    <input type="text" readonly id="tasa_cambio" value="1" class="form-control">
                    <input type="hidden" id="idtasa_cambio" name="idtasa_cambio" value="1" >
                    <input id="valor_moneda_extranjera" type="hidden" >
                    </div> 
                    </div> 
                    </div>
                    
                    <div class="form-group">
                    <div class="form-group col-lg-12">  
                    <label class="col-lg-3">Descripción de Asiento</label>
                    <div class="form-group col-lg-4"> 
                        <textarea  placeholder="Descripcion del asiento de diario" id="descripcion_asiento_diario" class="textarea" style="margin-left: -85px;" maxlength="200"><?php echo $asiento_diario[0]['descripcion_asiento_diario']; ?></textarea>
                     <input id="numero_asiento_diario" type="hidden">
                    </div>   
                    <label class="col-lg-2">Usuario Creacion</label>
                   <div class="form-group col-lg-2">                           
                       <input class="form-control" id="usuario_creacion" readonly placeholder="usuario"  value="<?php echo $asiento_diario[0]['usuario_creacion']; ?>">
                       <input id="usuario_edicion" placeholder="usuario edicion"  value="<?= $this->session->userdata('user') ?>" hidden>
                       <input id="usuario_creacion" type="hidden" value="<?= $this->session->userdata('user') ?>">
                        </div>
                    <div class="form-group col-lg-1"> 
                    <a style="margin-left:50px;" class="btn btn-success fa fa-plus fa-lg rec" role="button" id="agregar"> 
                    </a></div>
                    
                    </div>
                    </div>
                </div>                      
            </form>  
                <!--<input id="valor_origen_ad" hidden value="<?php //echo $asiento_diario[0]['idorigen_asiento_diario']; ?>">-->
                <input id="valor_tasa_cambio_ad" hidden value="<?php echo $asiento_diario[0]['idtasa_cambio']; ?>">
           <!--/////////////////// id de asiento diario--->
                <input id="idasiento_diario" type="hidden" value="<?php echo $asiento_diario[0]['idasiento_diario']; ?>">

                
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
                <table class=" table table-striped" id="contenedor_transacciones">
                    <!---------------------------------------elemento a clonar------------------------------------------------>
                    <tr id="clone" style="display: none" class="">
                        <td><div class="numero_asiento"></div><input type="hidden" class="numero_transaccion" value=""></td>
                        <td> 
                            <div class="input-group" style="width: 150px;" >
                                <input type="text" id="idcuenta_contable_" name="idcuenta_contable_" class="form-control buscar idcuenta_contable"  style="background:white;">
                                <span class="input-group-btn">
                                    <button id="b_" class="btn btn-default buscar_cuenta" type="button"><i class="fa-search fa flg" ></i></button>
                                </span>
                            </div>
                        </td>
                        <td><input id="descripcion_cuenta_contable_" disabled class='descripcion_cuenta_contable form-control' readonly="readonly" maxlength=120 size=50 placeholder='Descripcion Cta. Contable'></td>
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

                            echo"<tr id='" . $i . "' class='ad_detalle_editar agregado'>                               
                            <td><div class='numero_asiento'>" . $i . "</div><input type='hidden' class='numero_transaccion_editar' value='" . $ad_detalle['numero_transaccion'] . "'></td>
                            <td><div class='input-group' style='width: 150px;' >
                                    <input type='text' id='idcuenta_contable_" . $i . "' value='" . $ad_detalle['idcuenta_contable'] . "' class='form-control buscar idcuenta_contable'  style='background:white;'>
                                    <span class='input-group-btn'>
                                        <button id='b_" . $i . "' class='btn btn-default buscar_cuenta'  type='button'><i class='fa-search fa flg'></i></button>
                                    </span>
                                </div>
                            </td>
                            <td><input disabled id='descripcion_cuenta_contable_" . $i . "' value='' class ='descripcion_cuenta_contable form-control' readonly='readonly' maxlength=120 size=50 placeholder='Descripcion Cta. Contable'></td>       
                            ";
                            if ($asiento_diario[0]['idtasa_cambio']== 1) {
                                $monto = $ad_detalle['monto_moneda_nacional'];
                                $balance_debito = $asiento_diario[0]['balance_debito_nacional'];
                                $balance_credito = $asiento_diario[0]['balance_credito_nacional'];
                                
                            } else if ($asiento_diario[0]['idtasa_cambio']>0) {
                                $monto = $ad_detalle['monto_moneda_extranjera'];
                                $balance_debito = $asiento_diario[0]['balance_debito_extranjero'];
                                $balance_credito = $asiento_diario[0]['balance_credito_extranjero'];
                                
                            }
                            if ($ad_detalle['naturaleza_transaccion'] == "D") {
                                $debito = $monto;
                                $credito = 0.0;
                                
                            } else if ($ad_detalle['naturaleza_transaccion'] == "C") {
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
            </div><br>
             <div class="form-group col-lg-12"> 
                <div class="form-group col-lg-6"> 
                    <button class="btn btn-success btn-lg fa fa-save fa-lg" id="editar"> Editar</button>
                    <a href="<?php echo base_url(); ?>index.php/contabilidad/transacciones/asiento_diario/asiento_diario/index" class="btn btn-success btn-lg fa fa-close fa-lg" role="button">Cancelar</a>
                </div>
                <div class="form-group col-lg-5 col-lg-push-2">
                    <input id="total_debito" name ='total_debito' value="<?php echo $balance_debito; ?>" type="text" readonly class='col-lg-4 col-lg-pull-1'>
                    <input id="total_credito" name ='total_credito' value="<?php echo $balance_credito; ?>" readonly class='col-lg-4'>
                </div>
           </div>     
        </div>
    </div>
</div>

