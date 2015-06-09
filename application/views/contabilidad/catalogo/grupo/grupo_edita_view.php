<html>
    <head>
        <meta charset="UTF-8">
                <link rel="stylesheet" href="<?php echo base_url();?>public/css/bootstrap.css">
                <link rel="stylesheet" href="<?php echo base_url(); ?>public/font-awesome-4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/estilo.css">
        <title></title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="span3 well">
                    <div class="navbar navbar-inner block-header">
                        <a href="<?php echo base_url();?>index.php/contabilidad/catalogo/grupo/grupo/index/1" class="btn btn-success"> Regresar</a>
                    </div>
                    <div class="block-content collapse in valor">
                        <?php 
                            echo form_open();
                            echo form_hidden('idgrupo_cuenta',$idgrupo);
                        ?>
                        
                        <table class="table table-striped ">
                            <tr>
                                <th>Nombre del Grupo</th>
                                <th><?php echo form_input('grupo_cuenta',$lista_por_id[0]['grupo_cuenta']); echo form_error('grupo_cuenta');?></th>
                            </tr>
                            <tr>
                                <th>Nivel</th>
                                <th>
                                    <input id="nivel" type="hidden" value="<?php echo $lista_por_id[0]['nivel'] ?>">
                                    <?=form_dropdown('nivel',$nivel);?>
                                </th>
                            </tr>
                            <tr>
                                <th>Categoria</th>
                                <th>
                                    <input id="categoria_grupo" type="hidden" value="<?php echo $lista_por_id[0]['categoria'] ?>">
                                    <?=form_dropdown('idcategoria_cuenta',$categoria);?>
                                </th>
                            </tr>
                            <tr>
                                <th>Nivel superior</th>
                                <th>
                                    <input id="nivel_anterior" type="hidden" value="<?php echo $lista_por_id[0]['nivel_anterior'] ?>">
                                    <?=form_dropdown('nivel_anterior');?>
                                </th>
                            </tr>
                        </table>
                        
                    </div>
                                            <?php 
                            echo form_submit('botonSubmit', '  Editar  ', "class='btn btn-success'");
                            echo form_close();
                        ?>
                </div>
            </div>
        </div>