<div class="container diario">
    <div class="row">
        <div class="span3 well">
            <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Lista de Usuarios</h4>
            <div class="navbar navbar-inner block-header">

                <a href="<?php echo base_url(); ?>index.php/administracion/usuario/usuario_procesar/usuario_crear" id="botones" class="btn btn-success fa fa-file-o fa-lg"> Nueva</a></br></br> 
                <a href="<?php echo base_url(); ?>index.php/administracion/usuario/usuario_procesar/index/0" id="botones" class="btn btn-success fa fa-list-alt fa-lg"> Inactivas</a></br>

              
                <input type="text" id="valor" class="col-lg-offset-6">
                <button class="btn btn-default" id="buscar" type="button"><i class="fa fa-search fa-sm"></i></button>
                
                <select id="campo" class="dropdown">
                    <option value="nombre">Nombre</option>
                    <option value="apellido">Apellido</option>
                    <option value="usuario">Usuario</option>
                </select>
                <a href="<?php echo base_url(); ?>index.php/administracion/usuario/usuario_procesar/index/1" id="refescar" class="btn  fa fa-refresh fa-sm"></a></br></br>
                
            </div>

            <div class="block-content collapse in valor" id="resultado" > 

            </div>
        </div>
    </div>
</div>