
<div class="container">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Editar cuentas contables</h4></br>
                <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/cuentas/cuentas/index/1" class="btn btn-success fa fa-reply-all fa-lg"> Regresar</a>
            </div>
            <div class="block-content collapse in">
                <?php
                echo form_open();
                echo form_hidden('idcuenta_contable', $idcatalogo);
                ?>

                <table class="table table-striped table-bordered ">
                    <tr>
                        <th>Numero de Cuenta</th>
                        <th><?php
                            $id = $lista_por_id[0]['idcuenta_contable'];

                            echo $id;
                            ?></th>
                    </tr>
                    <tr>
                        <th>Descripcion de la Cuenta Contable</th>
                        <th><?php echo form_input('cuenta_contable', $lista_por_id[0]['cuenta']);
                            echo form_error('cuenta_contable');
                            ?></th>
                    </tr>
                    <tr>
                        <th>Naturaleza de la Cuenta</th>
                        <td>
<?= form_dropdown('naturaleza_cuenta_contable', $tipocuenta); ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Grupo Cuenta</th>
                        <td>
<?= form_dropdown('idgrupo_cuenta', $idgrupocuenta); ?>
                        </td>
                    </tr>
                </table>

                <?php
                echo form_submit('botonSubmit', '  Editar  ', 'class="btn btn-success"');
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>