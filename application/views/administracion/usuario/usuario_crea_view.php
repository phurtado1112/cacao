<?= form_open('administracion/usuario/usuario_procesar/usuario_crear/'); ?>
<div class="container">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-pencil-square-o fa-lg col-lg-offset-5"> Crear Nuevo Usuario</h4></br>
            </div>
            <form class="form-horizontal">
                <div class="alert alert-success valor" role="alert" style="width: 80%; margin-left:10%;">Datos Personales  
                <div class="form-group row">
                    <label class="col-md-2 control-label">Nombre</label>
                    <div class="col-md-2"> 
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" autofocus></div>

                    <label class="col-md-2 control-label">Apellido</label>
                    <div class="col-md-2"> 
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido"></div>
                </div>
              </div>
                <div class="alert alert-success valor" role="alert" style="width: 80%; margin-left:10%;">Datos de Usuario  
                <div class="form-group row">
                    <label class="col-md-2 control-label">Usuario</label>
                    <div class="col-md-2"> 
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario"></div>

                    <label class="col-md-2 control-label">Contraseña</label>
                    <div class="col-md-2"> 
                        <input type="password" class="form-control" id="contrasenia" name="contrasenia" placeholder="Contraseña"></div>
                </div>
              </div>
                <button type="submit" class="btn btn-success fa fa-save fa-lg col-lg-offset-4"> Crear</button>
                <a href="index/1" class="btn btn-success fa fa-close fa-lg col-lg-offset-1" id="botones">Cancelar</a>

            </form>
                <?= form_close(); ?>
                <?= validation_errors(); ?>

        </div>
    </div>
</div>
