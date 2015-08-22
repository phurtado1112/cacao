        <div class="container">
            <div class="row">
                <div class="span3 well">
                    <div class="navbar navbar-inner block-header">
                        <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Editar Grupo de cuentas</h4></br>
                    </div>
                    <form class="form-horizontal" method="POST">
                <?php
                  echo form_open();
                  echo form_hidden('idgrupo_cuenta',$idgrupo);
                ?>
                <div class="alert alert-success cacao valor" role="alert" style="width: 80%; margin-left:10%;"> 
                    <div class="form-group">
                        <label class="col-lg-3 control-label col-lg-offset-2">Nombre del grupo</label>
                        <div class="col-lg-3">                              
                            <input name='grupo_cuenta' class="form-control" value="<?php echo $lista_por_id[0]['grupo_cuenta'] ?>" autocomplete="off" maxlength="50">                           
                            <?php echo form_error('grupo_cuenta');
                            ?>
                        </div></div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label col-lg-offset-2">Nivel</label>                   
                        <div class="col-lg-3"> 
                            <input id="nivel" type="hidden" value="<?php echo $lista_por_id[0]['nivel'] ?>">
                                    <?=form_dropdown('nivel',$nivel,'','class="form-control"');?>                       
                        </div> </div> 
                    <div class="form-group">
                        <label class="col-lg-3 control-label col-lg-offset-2">Categoria</label>
                        <div class="col-lg-3 dropdown"> 
                               <input id="categoria_grupo" type="hidden" value="<?php echo $lista_por_id[0]['categoria'] ?>">
                               <?=form_dropdown('idcategoria_cuenta',$categoria,'','class="form-control"');?>
                        </div> </div>
                    <div class="form-group">
                        <label class="col-lg-3 control-label col-lg-offset-2">Nivel Superior</label>
                        <div class="col-lg-3 dropdown"> 
                          <input id="idnivel_anterior" type="hidden" value="<?php echo $lista_por_id[0]['idnivel_anterior'] ?>">
                          <?=form_dropdown('idnivel_anterior','','class="form-control"');?>
                        </div></div>
                      <div class="form-group">
                        <label class="col-lg-3 control-label col-lg-offset-2">Aceptar cuentas</label>
                         <label class="col-lg-1">No</label>
                                <input class="col-lg-1" style="margin-left: -30px;" type = "radio" name = "acepta_cuenta"  value = "0"  checked = "checked" />
                         <label class="col-lg-1">Si</label>  
                                <input class="col-lg-1" style="margin-left: -30px;" type = "radio" name = "acepta_cuenta"  value = "1"  />
                        
                    
                    </div>
                </div>
                <button class="btn btn-success fa fa-pencil-square-o fa-lg col-lg-offset-4">Editar</button>
                <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/index/1" class="btn btn-success fa fa-close fa-lg col-lg-offset-1">Cancelar</a>
                <?php echo form_close(); ?>
            </form>
        </div>
    </div>
</div>       

             