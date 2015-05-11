
<div class="container">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-pencil-square-o fa-lg col-lg-offset-5"> Crear Nuevo Grupo</h4></br>
                <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/index/1" class="btn btn-success fa fa-reply-all fa-lg"> Regresar</a>
            </div>
            <div class="block-content collapse in">
                <?php
                echo form_open();
                echo form_hidden('estado', 1);
                ?>

                <table class="table table-striped table-bordered ">
                    <tr>
                        <th>Nombre del grupo</th>
                        <th><?php echo form_input('grupo_cuenta');
                echo form_error('grupo_cuenta');
                ?></th>
                    </tr>
                    <tr>
                        <th>Nivel</th>
                        <th><?= form_dropdown('nivel', $nivel); ?></th>
                    </tr>
                    <tr>
                        <th>Titulo superior</th>
                        <th><?= form_dropdown('nivel_anterior', $nivel_anterior); ?></th>
                    </tr>
                    <tr>
                        <th>Categoria</th>
                        <th><?= form_dropdown('idcategoria_cuenta', $categoria); ?></th>
                    </tr>
                </table>

                <?php
                echo form_submit('botonSubmit', '  Crear  ', 'class="btn btn-success"');
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>