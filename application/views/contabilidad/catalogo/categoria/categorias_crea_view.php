<div class="container">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-pencil-square-o fa-lg col-lg-offset-5"> Crear Nueva Categoría</h4></br>
                <a href="index/1" class="btn btn-success fa fa-reply-all fa-lg"> Lista de Cuentas</a>
            </div>
            <div class="block-content collapse in">
                <?php
                echo form_open();
                echo form_hidden('estado', 1);
                ?>

                <table class="table table-striped table-bordered ">
                    <tr>
                        <th>Nombre de la Categoría</th>
                        <th><?php echo form_input('categoria_cuenta') . validation_errors('categoria_cuenta'); ?></th>
                    </tr>
                    <tr>
                        <th>Estructura Base</th>
                        <th><?= form_dropdown('idestructura_base', $idestructura_base); ?></th>
                    </tr>
                </table>

                <?php
                echo form_submit('botonSubmit', 'Crear', "class='btn btn-success'");
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>
