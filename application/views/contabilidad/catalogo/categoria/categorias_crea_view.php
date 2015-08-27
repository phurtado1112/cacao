<div class="container">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-pencil-square-o fa-lg col-lg-offset-5"> Crear Nueva Categoría</h4></br>
                
            </div>
                <form class="form-horizontal" method="POST">
                <?php
                echo form_open();
                echo form_hidden('estado', 1);
                ?>
                <div class="alert alert-success cacao valor" role="alert" style="width: 80%; margin-left:10%;"> 
                <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Nombre de la Categoría</label>
                    <div class="col-lg-3"> 
                        <input name="categoria_cuenta" class="form-control" autocomplete="off" maxlength="50">
                    <?php echo form_error('categoria_cuenta'); ?>
                    </div> </div>                   
                    <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Tipo</label>
                    <div class="col-lg-3 dropdown"> 
                        <?= form_dropdown('idestructura_base', $idestructura_base,'','class="form-control"'); ?>
                    </div>
                </div>
              </div>
              <button class="btn btn-success fa fa-pencil-square-o fa-lg col-lg-offset-4">Crear</button>
            <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/categoria/categoria/index/1" class="btn btn-success fa fa-close fa-lg col-lg-offset-1">Cancelar</a>
            <?php echo form_close(); ?>
            
            </form>
            
        </div>
    </div>
</div>