<?php 
//      $=array(
//            'size'=>'',
//        );
?>

<div class="container">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Editar cuentas contables</h4><br>
            </div>
                <form class="form-horizontal" method="POST">
                <?php
                echo form_open();
                 echo form_hidden('idcuenta_contable', $idcatalogo);
                ?>
                <div class="alert alert-success cacao valor" role="alert" style="width: 80%; margin-left:10%;"> 
                <div class="form-group has-error has-feedback">
                    <label class="col-lg-3 control-label col-lg-offset-2">Número de la cuenta</label>
                    <div class="col-lg-3"> 
                         <?php
                            $id = $lista_por_id[0]['idcuenta_contable'];

                            echo $id;
                            ?>
                    </div> </div>
                    <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Descripción de la cuenta</label>
                    <div class="col-lg-3"> 
                            <?php 
                            echo form_input('cuenta_contable', $lista_por_id[0]['cuenta'],'class="form-control"');
                            echo form_error('cuenta_contable');
                            ?>
                    </div> </div>
                    <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Naturaleza de la cuenta</label>
                    <div class="col-lg-3 dropdown"> 
                         <input id="naturaleza_cuenta" type="hidden" value="<?php echo $lista_por_id[0]['naturaleza']?>">
                            <?= form_dropdown('naturaleza_cuenta_contable', $tipocuenta,'','class="form-control"'); ?>
                    </div> </div>
                    <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Grupo</label>
                    <div class="col-lg-3 dropdown"> 
                        <input id="grupo_cuenta" type="hidden" value="<?php echo $lista_por_id[0]['grupo_cuenta']?>">
                            <?= form_dropdown('idgrupo_cuenta', $idgrupocuenta,'','class="form-control"'); ?>
                    </div>
                </div>
              </div>
              <button class="btn btn-success fa fa-pencil-square-o fa-lg col-lg-offset-4">Editar</button>
            <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/cuentas/cuentas/index/1" class="btn btn-success fa fa-close fa-lg col-lg-offset-1">Cancelar</a>
            <?php echo form_close(); ?>
            </form>
            
        </div>
    </div>
</div>