<div class="container"> 
    <div class="row">
        <div class="span3 well">
            <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Configuración del Módulo</h4><br><br> 
            <div class="panel-group" id="accordion" role="tablist">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Configuración General
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <!--  INPUTS NECESARIOS PARA LOS PROCESOS -->
                            <form class="form-horizontal" role="form">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-md-2 control-label">Año Fiscal</label>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" id="anio_fiscal" placeholder="Año Fiscal" maxlength="4">
                                            </div>
                                            <label  class="col-md-3 control-label">Decimales de Redondeo</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" id="decimales_redondeo" placeholder="Decimales de Redondeo" maxlength="1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form class="form-horizontal" role="form">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-md-2 control-label">Período Actual</label>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control" id="periodo_actual" placeholder="Período Actual" maxlength="2">
                                            </div>
                                            <label  class="col-md-3 control-label">Patrón de cuenta Contable</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" id="patron_cuenta" placeholder="Patrón de cuenta Contable" maxlength="25">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form class="form-horizontal" role="form">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label  class="col-md-3 col-lg-offset-4 control-label">Cuenta de Utilidades</label>
                                            <div class="col-md-3">
                                                <select type="text" class="form-control" id="cuenta_contable" placeholder="Cuenta de Utilidades">
                                                    <?php 
                                                        echo $lista_cuenta;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Transferencia Automática de Asientos de Diario
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <!--  INPUTS NECESARIOS PARA LOS PROCESOS -->
                            <form class="form-horizontal" role="form"><br>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="checkbox" id="bancos" value="1" aria-label="...">
                                            </span>
                                            <label class="form-control">Bancos</label>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-4 -->
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="checkbox" id="inventarios" value="1" aria-label="...">
                                            </span>
                                            <label class="form-control">Inventarios</label>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-4 -->
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="checkbox" id="compras" value="1" aria-label="...">
                                            </span>
                                            <label class="form-control">Compras</label>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-4 -->
                                </div><br>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="checkbox" id="cuentas_por_pagar" value="1" aria-label="...">
                                            </span>
                                            <label class="form-control">Cuentas por Pagar</label>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-4 -->
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="checkbox" id="cuentas_por_cobrar" value="1" aria-label="...">
                                            </span>
                                            <label class="form-control">Cuentas por Cobrar</label>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-4 -->
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <input type="checkbox" id="facturas" value="1" aria-label="...">
                                            </span>
                                            <label class="form-control">Facturas</label>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-4 -->
                                </div><br>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row col-lg-offset-4"> 
            <button type="button" id="guardar" class="btn btn-success fa fa-pencil fa-lg"> Guardar</button>
            <button type="button" class="btn btn-success fa fa-ban fa-lg"> Cancelar</button>            
            </div>
        </div>
    </div>
</div>