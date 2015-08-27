<?php 
//      $=array(
//            'size'=>'',
//        );
?>

<div class="container">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-pencil-square-o fa-lg col-lg-offset-5"> Crear Nueva Cuenta</h4><br>
            </div>
            <form class="form-horizontal" method="POST">
                <?php
                echo form_open();
                ?>
                <div class="alert alert-success cacao valor" role="alert" style="width: 80%; margin-left:10%;"> 
                <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Número de la cuenta</label>
                    <div class="col-lg-3"> 
                         <?php echo form_input($idcuenta_contable,'','class="form-control"');
                            echo form_error('idcuenta_contable');
                            ?>
                    </div> </div>
                    <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Nombre de la cuenta</label>
                    <div class="col-lg-3"> 
                        <input name='cuenta_contable' class="form-control" autocomplete="off" maxlength="50">
                            <?php echo form_error('cuenta_contable');?>
                    </div> </div>
                    <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Naturaleza de la cuenta</label>
                    <div class="col-lg-3 dropdown"> 
                         <?= form_dropdown('naturaleza_cuenta_contable', $tipocuenta,'','class="form-control"'); ?>
                    </div> </div>
                    <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Grupo</label>
                    <div class="col-lg-3 dropdown"> 
                         <?= form_dropdown('idgrupo_cuenta', $idgrupo_cuenta,'','class="form-control"'); ?>
                    </div>
                </div>
              </div>
              <button class="btn btn-success fa fa-pencil-square-o fa-lg col-lg-offset-4">Crear</button>
            <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/cuentas/cuentas/index/1" class="btn btn-success fa fa-close fa-lg col-lg-offset-1">Cancelar</a>
            <?php echo form_close(); ?>
            </form>
            </div>
        </div>
    </div>









