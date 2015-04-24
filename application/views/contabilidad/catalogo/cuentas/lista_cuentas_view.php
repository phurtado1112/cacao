<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url();?>bootstrap/css/estilo.css">
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="span3 well">
                    <h4><center>Lista de cuentas contables</center></h4>
                    <div class="navbar navbar-inner block-header">
                        <?php echo $link; ?>
                    </div>
                    <div class="block-content collapse in"> 
                        
                            <?php  
                            
                            echo $this->table->generate($cuentas);
                            
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
