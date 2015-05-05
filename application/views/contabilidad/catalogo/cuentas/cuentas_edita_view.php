<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/font-awesome-4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/estilo.css">
        <title></title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="span3 well">
                    <div class="navbar navbar-inner block-header">
                        <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Editar cuentas contables</h4></br>
                        <a href="<?php echo base_url();?>index.php/contabilidad/catalogo/cuentas/cuentas/leer/1" class="btn btn-success fa fa-reply-all fa-lg"> Lista de Cuentas</a>
                    </div>
                    <div class="block-content collapse in">
                        <?php 
                            echo form_open();
                            echo form_hidden('idcuenta_contable',$idcatalogo);
                        ?>
                        
                        <table class="table table-striped table-bordered ">
                            <tr>
                                <th>Nombre de la Cuenta Contable</th>
                                <th><?php echo form_input('cuenta_contable',$lista_por_id[0]['cuenta']).validation_errors('categoria_cuenta');?></th>
                            </tr>
                            <tr>
                                <th>Naturaleza de la Cuenta</th>
                                <td>
                                   <?=form_dropdown('naturaleza_cuenta_contable',$tipocuenta);?>
                                </td>
                            </tr>
                            <tr>
                                <th>Grupo Cuenta</th>
                                <td>
                                   <?=form_dropdown('idgrupo_cuenta',$idgrupocuenta);?>
                                </td>
                            </tr>
                        </table>
                        
                        <?php 
                            echo form_submit('botonSubmit', '  Editar  ','class="btn btn-success"');
                            echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url();?>bootstrap/js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jquery-select.js"></script>
    </body>
</html>