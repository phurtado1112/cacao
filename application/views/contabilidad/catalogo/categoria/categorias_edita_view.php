<div class="container">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Lista de Categoría cuentas</h4></br>
                <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/categoria/categoria/index/1" class="btn btn-success fa fa-reply-all fa-lg"> Regresar</a>
            </div>
            <div class="block-content collapse in">
                <?php
                echo form_open();
                echo form_hidden('idcategoria_cuenta', $idcategorias);
                ?>

                <table class="table table-striped table-bordered ">
                    <tr>
                        <th>Nombre de la Categoría</th>
                        <th><?php echo form_input('categoria_cuenta', $lista_por_id[0]['categoria']);echo form_error('categoria_cuenta'); ?></th>
                    </tr>
                    <tr>
                        <th>Estructura Base</th>
                        <td>
                            <?= form_dropdown('idestructura_base', $idestructurabase); ?>
                        </td>
                    </tr>
                </table>

                <?php
                echo form_submit('botonSubmit', '  Editar  ', "class='btn btn-success'");
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>