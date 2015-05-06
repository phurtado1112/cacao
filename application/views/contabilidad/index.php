<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Principal</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/font-awesome-4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/estilo.css">
        <style type="text/css">

            img.pequeña{width: 50px; height: 50px;}
            img.mediana{width: 500px; height: 250px ;filter:alpha(opacity=70);
                        opacity:.60; position: relative; display: block; margin-left: 600px; margin-top: -250px;}
            img.grande{width: 700px; height: 700px;position: relative;}

        </style>
    </head>
    <body>
        <img class="grande img-responsive" src="<?php echo base_url(); ?>public/img/cacao.png">
        <img class="mediana img-responsive" src="<?php echo base_url(); ?>public/img/contabilidad.png">
        <script src="<?php echo base_url(); ?>public/js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jquery-select.js"></script>
    </body>

</html>
