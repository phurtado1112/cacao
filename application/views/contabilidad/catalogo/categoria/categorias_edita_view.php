<div class="container catalogo">
    <div class="row">
        <div class="span3 well">
            <div class="navbar navbar-inner block-header">
                <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Editar Categoría cuenta</h4></br>
                
            </div>
            <div class="block-content collapse in " style="width: 80%; margin: auto; padding:0px 10px;">
                <?php
                echo form_open();
                echo form_hidden('idcategoria_cuenta', $idcategorias);
                ?>

                <table class="table table-striped valor">
                    <tr>
                        <th>Nombre de la Categoría</th>
                        <th><?php echo form_input('categoria_cuenta', $lista_por_id[0]['categoria']);
                        echo form_error('categoria_cuenta'); ?></th>
                    </tr>
                    <tr>
                        <th>Estructura Base</th>
                        <td>
                            <input id="estructura_base" type="hidden" value="<?php echo $lista_por_id[0]['nombre'] ?>">
                            <?= form_dropdown('idestructura_base', $idestructurabase); ?>
                        </td>
                    </tr>
                </table>
                <div style="margin:0px auto; width: 250px;">
                <?php
                echo form_submit('botonSubmit', '  Editar  ', "class='btn btn-success'");?>
                <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/categoria/categoria/index/1" class="btn btn-success">Cancelar</a>
                <?php echo form_close();
                ?>
            </div></div>
        </div>
    </div>
</div>