<nav class="navbar navbar-default" role="navigation">
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
            <option value="1">Contabilidad</option>
            <option value="2">Administracion</option>
            <option value="3" selected="TRUE">Bancos</option>
        </select>
    </div>

    <!-- Agrupar los enlaces de navegación, los formularios y cualquier
         otro elemento que se pueda ocultar al minimizar la barra -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo base_url(); ?>index.php/bancos/banco">Inicio</a></li>
        </ul>

        <div id="modulo_menu" >  
            <!-- ////////////////////////////////////////////////////-->
            <ul class="nav navbar-nav">

                <li class="dropdown">
                    <!-- ////-->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Transacciones <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Ajustes bancarios</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Cheques</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Ingreso de fondos</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Rendicion de cuentas</a></li>
                    </ul>
                    <!-- ////-->
                </li>
            </ul>

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <!-- ////-->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catálogos<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>">Cuentas Bancaria</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>">Institucion Bancaria</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>index.php/categoria/c_categoria/listar/1">Tipo de Monedas</a></li>
                    </ul>
                    <!-- ////-->
                </li>
            </ul>


            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <!-- ////-->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>">Reportes de cheques emitidos por cuentas bancarias</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>">Reportes de conciliacion por cuentas bancarias</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>">Reportes de ingresos de fondos por cuentas bancarias</a></li>
                    </ul>
                    <!-- ////-->
                </li>
            </ul>

            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <!-- ////-->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Operaciones<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>">Conciliacion bancaria</a></li>
                    </ul>
                    <!-- ////-->
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>&nbsp;&nbsp;<?= $this->session->userdata('user') ?><b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>index.php/administracion/usuario/usuario/salir"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Salir</a></li>
                    </ul>
                </li>
                <li><a href="#"></a></li>
            </ul>

        </div>
    </div>
</nav>