<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
        <title></title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="span3 well">
                    <div class="navbar navbar-inner block-header">
                        <a href="<?php echo base_url();?>index.php/contabilidad/catalogo/categoria/C_Categoria/leer/1" class="btn btn-success">Volver a lista de Cuentas</a>
                    </div>
                    <div class="block-content collapse in">
                        <?php 
                            echo form_open();
                            echo form_hidden('idcategoria_cuenta',$idcategorias);
                        ?>
                        
                        <table class="table table-striped table-bordered ">
                            <tr>
                                <th>Nombre de la Categoria</th>
                                <th><?php echo form_input('categoria_cuenta',$lista_por_id[0]['categoria']).validation_errors('categoria_cuenta');?></th>
                            </tr>
                            <tr>
                                <th>Estructura Base</th>
                                <td>
                                   <?=form_dropdown('idestructura_base',$idestructurabase);?>
                                </td>
                            </tr>
                        </table>
                        
                        <?php 
                            echo form_submit('botonSubmit', '  Editar  ');
                            echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url();?>bootstrap/bootstrap/js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jquery-select.js"></script>
    </body>
</html>