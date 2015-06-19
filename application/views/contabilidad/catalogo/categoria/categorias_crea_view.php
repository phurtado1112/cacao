<div class="container">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-pencil-square-o fa-lg col-lg-offset-5"> Crear Nueva Categoría</h4></br>
                
            </div>
            <div class="block-content collapse in " style="width: 80%; margin: auto; padding:0px 10px;">
                <?php
                echo form_open();
                echo form_hidden('estado', 1);
                ?>

                <table class="table table-striped  valor">
                    <tr>
                        <th>Nombre de la Categoría</th>
                    
                    <th><?php echo form_input('categoria_cuenta');echo form_error('categoria_cuenta'); ?></th>
               
                    </tr>
                    <tr>
                        <th>Tipo</th>
                        <th><?= form_dropdown('idestructura_base', $idestructura_base); ?></th>
                    </tr>
                </table>
                 <div style="margin:0px auto; width: 250px;">
                <?php
                echo form_submit('botonSubmit', 'Crear', "class='btn btn-success botones'");
                echo '<a href="index/1" class="btn btn-success" id="botones">Cancelar</a>';
                echo form_close();
                ?>
                 </div>
            </div>
        </div>
    </div>
</div>
