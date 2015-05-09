    <body>
        <div class="container">
            <div class="row">
                <div class="span3 well">
                    <div class="navbar navbar-inner block-header">
                        <h4 class="fa fa-pencil-square-o fa-lg col-lg-offset-5"> Crear Nueva Cuenta</h4></br>
                        <a href="<?php echo base_url();?>index.php/contabilidad/catalogo/cuentas/cuentas/index/1" class="btn btn-success fa fa-reply-all fa-lg"> Regresar</a>
                    </div>
                    <div class="block-content collapse in">
                        <?php 
                            echo form_open();
                        ?>
                        
                        <table class="table table-striped table-bordered ">
                            <tr>
                                <th>Nombre de la Cuenta Contable</th>
                                <th><?php echo form_input('cuenta_contable');echo form_error('cuenta_contable');?></th>
                            </tr>
                            <tr>
                                <th>Naturaleza de la cuenta</th>
                                <th><?=form_dropdown('naturaleza_cuenta_contable',$tipocuenta);?></th>
                            </tr>
                            <tr>
                                <th>Estructura Base</th>
                                <th><?=form_dropdown('idgrupo_cuenta',$idgrupo_cuenta);?></th>
                            </tr>
                        </table>
                        
                        <?php 
                            echo form_submit('botonSubmit', '  Crear  ' ,'class="btn btn-success"');
                            echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url();?>public/js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url();?>public/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jquery-select.js"></script>
    </body>
</html>
