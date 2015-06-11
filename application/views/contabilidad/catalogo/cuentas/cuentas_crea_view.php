<div class="container">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-pencil-square-o fa-lg col-lg-offset-5"> Crear Nueva Cuenta</h4></br>
                <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/cuentas/cuentas/index/1" class="btn btn-success fa fa-reply-all fa-lg"> Regresar</a>
            </div>
            <div class="block-content collapse in valor">
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
                        <th><?php echo form_input('cuenta_contable');
                            echo form_error('cuenta_contable');
                            ?></th>
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
            <?php
            echo form_submit('botonSubmit', '  Crear  ', 'class="btn btn-success"');
            echo form_close();
            ?>

        </div>
    </div>
</div>