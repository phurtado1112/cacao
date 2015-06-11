<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bienvenido</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/font-awesome-4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/estilo.css">
    </head>
    <body>
        <div class="container well" id="formulario"> 
            <div class="row"> 
                <div class="col-xs-12"> 
                    <i class="fa fa-user-secret fa-5x" id="avatar"></i>
                </div>
                <form action="<?php echo base_url(); ?>index.php/contabilidad/contabilidad" class="login">
                    <div class="form-group"> 
                        <input type="text" id="user" name="user" placeholder="Ingrese su usuario" class="form-control" onfocus>
                    </div>
                    <div class="form-group"> 
                        <input type="password" id="pass" name="pass" placeholder="Password" class="form-control">
                    </div>
                    <button class="btn btn-lg btn-success btn-block" type="submit">Aceptar</button>
                </form>
            </div>
        </div>

<!--        <h1>Login<a href="<?php echo base_url(); ?>index.php/contabilidad/contabilidad"></a></h1>-->
        <script src="<?php echo base_url(); ?>public/js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
    </body>

</html>
