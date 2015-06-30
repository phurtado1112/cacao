
<div class="container">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-pencil-square-o fa-lg col-lg-offset-5"> Crear Nuevo Grupo</h4></br>
            </div>
            <div class="block-content collapse in valor" style="width: 80%; margin: auto; padding:0px 10px;">
                <?php
                echo form_open();
                echo form_hidden('estado', 1);
                ?>

                <table class="table">
                    <tr>
                        <th>Nombre del grupo</th>
                        <th><?php
                            echo form_input('grupo_cuenta');
                            echo form_error('grupo_cuenta');
                            ?></th>
                    </tr>
                    <tr>
                        <th>Nivel</th>
                        <th>
                            <?= form_dropdown('nivel', $nivel); 
                             echo form_error('nivel');?>
                        </th>
                    </tr>
                    <tr>
                        <th>Categoria</th>
                        <th>
                            <?= form_dropdown('idcategoria_cuenta',$categoria);
                            echo form_error('idcategoria_cuenta'); ?>
                        </th>
                    </tr>
                    <tr>
                        <th>Nivel superior</th>
                        <th>
                            <?= form_dropdown('idnivel_anterior'); 
                            echo form_error('nivel_anterior');?>
                        </th>
                    </tr>
                </table>
                
            </div>         
            <div style="margin:0px auto; width: 250px;">
                <?php echo form_submit('botonSubmit', '  Crear  ', 'class="btn btn-success "'); ?>
                <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/index/1" class="btn btn-success">Cancelar</a>
                <?php echo form_close(); ?>
            </div>

        </div>
    </div>
</div>