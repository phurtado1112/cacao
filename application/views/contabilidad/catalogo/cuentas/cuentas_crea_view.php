<div class="container">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-pencil-square-o fa-lg col-lg-offset-5"> Crear Nueva Cuenta</h4><br>
            </div>
            <div class="block-content collapse in valor" style="width: 80%; margin: auto; padding:0px 10px;">
                <?php
                echo form_open();
                ?>

                <table class="table">
                    <tr>
                        <th>Numero de la Cuenta</th>
                        <th>
                            <?php echo form_input($idcuenta_contable);
                            echo form_error('idcuenta_contable');
                            ?>
                        </th>
                    </tr>
                    <tr>
                        <th>Nombre de la Cuenta</th>
                        <th>
                            <input name='cuenta_contable' autocomplete="off">
                            <?php echo form_error('cuenta_contable');?>
                        </th>
                    </tr>
                    <tr>
                        <th>Naturaleza de la cuenta</th>
                        <th>
                            <?= form_dropdown('naturaleza_cuenta_contable', $tipocuenta); ?>
                        </th>
                    </tr>
                    <tr>
                        <th>Grupo</th>
                        <th><?= form_dropdown('idgrupo_cuenta', $idgrupo_cuenta); ?></th>
                    </tr>
                </table>
            </div>
            <div style="margin:0px auto; width: 250px;">
            <?php
            echo form_submit('botonSubmit', '  Crear  ', 'class="btn btn-success"'); ?>
            <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/cuentas/cuentas/index/1" class="btn btn-success">Cancelar</a>
            <?php
            echo form_close();
            ?>
            </div>
        </div>
    </div>
</div>