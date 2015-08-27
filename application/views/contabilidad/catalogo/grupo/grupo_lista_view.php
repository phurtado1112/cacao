<div class="container">
    <div class="row">
        <div class="span3 well">
            <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Lista de grupos de cuentas</h4></br><br>
            <div class="navbar navbar-inner block-header">
                <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/grupo_crear" class="btn btn-success fa fa-file-o fa-lg"> Nuevo</a> 
                <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/index/0" class="btn btn-success fa fa-list-alt fa-lg"> Inactivas</a>
                <form class="form-horizontal">
                    <div class="row">
                        <select id="campo" class="dropdown-toggle" style="width: 164px">
                            <option value="grupo_cuenta">Grupo Cuenta</option>
                            <option value="nivel">Nivel</option>
                            <option value="nivel_anterior">Nivel Anterior</option>
                            <option value="categoria">Categoria</option>
                        </select>
                        <div class="col-lg-3 col-lg-offset-3 col-lg-push-5">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Buscar..." id="valor">
                                <span class="input-group-btn">
                                    <button class="btn btn-default"  type="button" id="buscar">Buscar</button>
                                </span>
                            </div><!-- /input-group -->
                        </div><!-- /.col-lg-6 -->
                        <a href="<?php echo base_url() ?>index.php/contabilidad/catalogo/grupo/grupo/index/1" class="btn btn-default fa fa-refresh fa-lg" id="refescar"></a>
                    </div><!-- /.row -->
                </form>

<!--                <input type="text" id="valor" class="col-lg-offset-4">
<button id="buscar" class="btn btn-default"><i class="fa fa-search fa-sm"></i></button>  

<select id="campo" class="dropdown">
    <option value="grupo_cuenta">Grupo Cuenta</option>
    <option value="nivel">Nivel</option>
    <option value="nivel_anterior">Nivel Anterior</option>
    <option value="categoria">Categoria</option>
</select>
<a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/index/1" class="btn fa fa-refresh fa-lg " id="refescar"></a></br></br>-->

            </div>

            <div class="block-content collapse in valor" id="resultado"> 

            </div>
        </div>
    </div>
</div>

