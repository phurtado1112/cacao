<!DOCTYPE html>
<html>
    <head>
                <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/bootstrap.css">
                <link rel="stylesheet" href="<?php echo base_url(); ?>public/font-awesome-4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/estilo.css">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="span3 well">
                     <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Lista de grupos de cuentas</h4>
                    <div class="navbar navbar-inner block-header">
                        <?php echo $link; ?>
                    </div>
                    <div class="block-content collapse in" id="resultado"> 
                        
                            <?php  
                            
                            echo $this->table->generate($gruposcuentas);
                            
                            ?>
                       
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url();?>bootstrap/js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jquery-select.js"></script>
        <script src="<?php echo base_url(); ?>public/js/busqueda_grupo-ajax.js"></script>
    </body>
</html>
