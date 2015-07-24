<!DOCTYPE html>
<html>
    <head>
        <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
        <META HTTP-EQUIV="Expires" CONTENT="-1">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/jquery-ui.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/estilo.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/smoke.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/font-awesome-4.3.0/css/font-awesome.min.css">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>public/img/leaf.ico"> 
        <meta charset="UTF-8">
        <title><?php echo $titulo; ?></title>
    </head>
    <body>
        <nav class="navbar navbar-fixed-top" role="navigation">
            <!-- El logotipo y el icono que despliega el menú se agrupan
                 para mostrarlos mejor en los dispositivos móviles -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Desplegar navegación</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <select id="modulo" class="navbar-brand" style="border: none; background: none">
                    <option value="1" selected>Contabilidad</option>
                    <option value="2">Administración</option>
                    <option value="3">Bancos</option>
                </select>
            </div>

            <!-- Agrupar los enlaces de navegación, los formularios y cualquier
                 otro elemento que se pueda ocultar al minimizar la barra -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li class=""><a href="<?php echo base_url(); ?>index.php/contabilidad/contabilidad">Inicio</a></li>
                </ul>

                <ul class="nav navbar-nav">

                    <li class="dropdown">
                        <!-- ////-->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Transacciones <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url(); ?>index.php/contabilidad/transacciones/asiento_diario/asiento_diario">Asientos de Diario</a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente">Asientos de Diario Recurrentes</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Cálculo Depreciación de Activos Fijos</a></li>   
                        </ul>
                        <!-- ////-->
                    </li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <!-- ////-->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catálogos <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/cuentas/cuentas/index/1">Catálogo de Cuentas</a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/index/1">Grupos de Cuentas</a></li>
                            <li><a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/categoria/categoria/index/1">Categorías de Cuentas</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url(); ?>">Activos Fijos</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url(); ?>">Presupuestos</a></li>
                        </ul>
                        <!-- ////-->
                    </li>
                </ul>


                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <!-- ////-->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url(); ?>">Estado de Balance</a></li>
                            <li><a href="<?php echo base_url(); ?>">Estado de Resultados</a></li>
                            <li><a href="<?php echo base_url(); ?>">Balanza de Comprobación</a></li>
                            <li><a href="<?php echo base_url(); ?>">Flujo de efectivo</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url(); ?>">Libro de diario</a></li>
                            <li><a href="<?php echo base_url(); ?>">Asiento de Mayor</a></li>
                            <li><a href="<?php echo base_url(); ?>">Saldo de cuentas</a></li>
                            <li><a href="<?php echo base_url(); ?>">Catálogo de Cuentas</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url(); ?>">Informes a los donantes</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url(); ?>">Activos Fijos</a></li>
                            <li><a href="<?php echo base_url(); ?>">Presupuestos</a></li>
                        </ul>
                        <!-- ////-->
                    </li>
                </ul>

                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <!-- ////-->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Gestión<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo base_url(); ?>">Cierre Fiscal</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url(); ?>index.php/contabilidad/gestion/contabilidad_config">Configuración del Módulo</a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo base_url(); ?>">Periodos Fiscales</a></li>
                        </ul>
                        <!-- ////-->
                    </li>
                </ul>
                
                <ul class="nav navbar-nav">
                    <li class=""><a href="<?php echo base_url(); ?>index.php/administracion/usuario/usuario/salir">Cerrar sesion</a></li>
                </ul>
                
                <h5 style="text-align: center">Bienvenido de nuevo <?= $this->session->userdata('user') ?></h5>
            </div>
        </nav>
