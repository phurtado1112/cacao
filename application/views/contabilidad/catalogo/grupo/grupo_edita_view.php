        <div class="container">
            <div class="row">
                <div class="span3 well">
                    <div class="navbar navbar-inner block-header">
                        <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Editar Grupo de cuentas</h4></br>
                    </div>
                    <div class="block-content collapse in valor" style="width: 80%; margin: auto; padding:0px 10px;">
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
                                    <input id="idnivel_anterior" type="hidden" value="<?php echo $lista_por_id[0]['idnivel_anterior'] ?>">
                                    <?=form_dropdown('idnivel_anterior');?>
                                </th>
                            </tr>
                        </table>
                        
                    </div>
                <div style="margin:0px auto; width: 250px;">
                <?php echo form_submit('botonSubmit', '  Editar  ', 'class="btn btn-success "'); ?>
                <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/index/1" class="btn btn-success">Cancelar</a>
                <?php echo form_close(); ?>
            </div>
                </div>
            </div>
        </div>