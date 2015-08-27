<div class="container">
    <div class="row">
        <div class="span3 well">
            <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Lista de cuentas contables</h4><br><br>
            <div class="navbar navbar-inner block-header">
                <a href="<?php echo base_url() ?>index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_crear" class="btn btn-success fa fa-file-o fa-lg"> Nueva</a> 
                <a href="<?php echo base_url() ?>index.php/contabilidad/catalogo/cuentas/cuentas/index/0" class="btn btn-success fa fa-list-alt fa-lg"> Inactivas</a>
                <form class="form-horizontal">
                   <div class="row">
                        <select id="campo" class="dropdown-toggle">
                            <option value="idcuenta_contable">Cuenta</option>
                            <option value="cuenta">Descripcion</option>
                            <option value="naturaleza">Naturaleza de Cuenta</option>
                            <option value="grupo_cuenta">Grupo de cuentas</option>
                        </select> 
                        <div class="col-lg-3 col-lg-offset-3 col-lg-push-5">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Buscar..." id="valor">
                                <span class="input-group-btn">
                                    <button class="btn btn-default"  type="button" id="buscar">Buscar</button>
                                </span>
                            </div><!-- /input-group -->
                            </div><!-- /.col-lg-6 -->
                            <a href="<?php echo base_url() ?>index.php/contabilidad/catalogo/cuentas/cuentas/index/1" class="btn btn-default fa fa-refresh fa-lg" id="refescar"></a>
                        
                      </div><!-- /.row -->

                </form>
            </div>
            <div class="block-content collapse in valor" id="resultado"> 

            </div>

        </div>
    </div>
</div>


