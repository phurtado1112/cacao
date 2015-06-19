<div class="container">
    <div class="row">
        <div class="span3 well">
            <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Lista de cuentas contables</h4><br><br>
            <div class="navbar navbar-inner block-header">
                <a href="<?php echo base_url() ?>index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_crear" class="btn btn-success fa fa-file-o fa-lg"> Nueva</a> 
                <a href="<?php echo base_url() ?>index.php/contabilidad/catalogo/cuentas/cuentas/index/0" class="btn btn-success fa fa-list-alt fa-lg"> Inactivas</a>
               
                <input type="text" id="valor" class="col-lg-offset-4">
                <button id="buscar" class="btn btn-default"><i class="fa fa-search fa-sm"></i></button>
                <select id="campo" class="dropdown">
                    <option value="idcuenta_contable">Cuenta</option>
                    <option value="cuenta">Descripcion</option>
                    <option value="naturaleza">Naturaleza de Cuenta</option>
                    <option value="grupo_cuenta">Grupo de cuentas</option>
                </select>
                <a href="<?php echo base_url() ?>index.php/contabilidad/catalogo/cuentas/cuentas/index/1" class="btn btn-default fa fa-refresh fa-lg" id="refescar"></a></br></br>
            </div>

            <div class="block-content collapse in valor" id="resultado"> 

            </div>

        </div>
    </div>
</div>


