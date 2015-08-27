<div class="container catalogo">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Editar Categoría cuenta</h4></br>
                
            </div>
                <form class="form-horizontal" method="POST">
                <?php
                    echo form_open();
                echo form_hidden('idcategoria_cuenta', $idcategorias);
                
                ?>
                <div class="alert alert-success cacao valor" role="alert" style="width: 80%; margin-left:10%;"> 
                <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Nombre de la Categoría</label>
                    <div class="col-lg-3"> 
                        <input name="categoria_cuenta" class="form-control" autocomplete="off" maxlength="50" value="<?=$lista_por_id[0]['categoria']; ?>">
                    <?php echo form_error('categoria_cuenta'); ?>
                    </div> </div>                   
                    <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Estructura Base</label>
                    <div class="col-lg-3 dropdown"> 
                         <input id="estructura_base" type="hidden" value="<?php echo $lista_por_id[0]['nombre'] ?>">
                            <?= form_dropdown('idestructura_base', $idestructura_base,'','class="form-control"'); ?>
                    </div>
                </div>
              </div>
              <button class="btn btn-success fa fa-pencil-square-o fa-lg col-lg-offset-4">Editar</button>
            <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/categoria/categoria/index/1" class="btn btn-success fa fa-close fa-lg col-lg-offset-1">Cancelar</a>
            <?php echo form_close(); ?>
            </form>
            
        </div>
    </div>
</div>