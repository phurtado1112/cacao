<div class="container">
    <div class="row">
        <div class="span3 well">
            <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Lista de cuentas contables</h4>
            <div class="navbar navbar-inner block-header">
                <a href="<?php echo base_url() ?>index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_crear" class="btn btn-success fa fa-file-o fa-lg"> Nueva</a></br></br> 
                <a href="<?php echo base_url() ?>index.php/contabilidad/catalogo/cuentas/cuentas/index/0" class="btn btn-success fa fa-list-alt fa-lg"> Inactivas</a>
                <a href="<?php echo base_url() ?>index.php/contabilidad/catalogo/cuentas/cuentas/index/1" class="btn btn-success fa fa-refresh fa-lg col-lg-offset-7"></a></br></br>
                <input type="text" id="valor" class="col-lg-offset-6">
                <select id="campo" class="dropdown">
                    <option value="idcuenta_contable">Cuenta</option>
                    <option value="cuenta">Descripcion</option>
                    <option value="naturaleza">Naturaleza de Cuenta</option>
                    <option value="grupo_cuenta">Grupo de cuentas</option>
                </select>
                <button id="buscar" class="btn btn-success">Buscar</button>
            </div>

            <div class="block-content collapse in" id="resultado"> 

            </div>

        </div>
    </div>
</div>


