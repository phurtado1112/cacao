<?php
echo form_open();
echo form_hidden('idusuario', $idusuario);
?>
<div class="container">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-pencil-square-o fa-lg col-lg-offset-5"> Editar Contraseña</h4></br>
            </div>
            <form class="form-horizontal">
                <div class="alert alert-success valor" role="alert" style="width: 80%; margin-left:10%;">Datos de Usuario  
                    <div class="form-group row">
<!--                        <label class="col-md-2 control-label">Usuario</label>
                        <div class="col-md-2"> 
                            <input type="text" class="form-control" id="Input3" placeholder="Usuario" disabled=""></div>      -->
                        <label class="col-md-2 control-label">Contraseña</label>
                        <div class="col-md-2"> 
                            <input type="text" class="form-control" id="pass" name="pass" placeholder="Contraseña">
                        </div>
                        <label class="col-md-2 control-label">Confirmar Contraseña</label>
                        <div class="col-md-2"> 
                            <input type="text" class="form-control" id="confirmar_pass" name="confirmar_pass" placeholder="Contraseña">
                            
                        </div>
                    </div>
                </div>   
                <button type="submit" class="btn btn-success fa fa-pencil-square fa-lg col-lg-offset-4 editar">Editar</button>
                <a href="<?php echo base_url(); ?>index.php/administracion/usuario/usuario_procesar/index/1" class="btn btn-success fa fa-close fa-lg col-lg-offset-1">Cancelar</a>
               
            </form>
            <?= form_close(); ?>
            <?= validation_errors(); ?>
        </div>
    </div>
</div>