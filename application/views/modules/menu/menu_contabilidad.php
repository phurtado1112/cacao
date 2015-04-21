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
          <option value="1" selected="TRUE">Contabilidad</option>
          <option value="2">Administración</option>
          <option value="3">Bancos</option>
      </select>
  </div>
 
  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
      <li class="active"><a href="<?php echo base_url(); ?>index.php">Inicio</a></li>
    </ul>
    
       <ul class="nav navbar-nav">
      
      <li class="dropdown">
         <!-- ////-->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Transacciones <b class="caret"></b></a>
        <ul class="dropdown-menu">
          <li><a href="#">Asientos de Diario Recurrentes</a></li>
          <li class="divider"></li>
          <li><a href="#">Calculo depreciacion de Activos Fijos</a></li>
          <li class="divider"></li>
          <li><a href="#">Crear Asientos de Diario</a></li>
          <li class="divider"></li>
          <li><a href="#">Mayorizar Asientos de Diario</a></li>
        </ul>
        <!-- ////-->
      </li>
    </ul>
      
    <ul class="nav navbar-nav">
      <li class="dropdown">
          <!-- ////-->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catálogos <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo base_url();?>">Activos Fijos</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>index.php/contabilidad/catalogo/cuentas/c_cuentas/leer/1">Catálogo de Cuentas</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>index.php/contabilidad/catalogo/categoria/c_categoria/leer/1">Categorías de Cuentas</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>index.php/contabilidad/catalogo/grupo/c_grupo/leer/1">Grupos de Cuentas</a></li>
        </ul>
        <!-- ////-->
      </li>
    </ul>
    
       
    <ul class="nav navbar-nav">
      <li class="dropdown">
          <!-- ////-->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes<b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo base_url();?>">Activos Fijos</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>">Catalogos</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>">Informe al donante</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>">AD Anulado</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>">AD Contabilizado</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>">AD No contabilizado</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>">Balanza de Comprobacion</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>">Estado de Balance</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>">Estado de Ingreso</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>">Flujo de efectivo</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>">Libro de diario</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>">Saldo de cuentas</a></li>
        </ul>
        <!-- ////-->
      </li>
    </ul>
       
    <ul class="nav navbar-nav">
      <li class="dropdown">
          <!-- ////-->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Operaciones<b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo base_url();?>">Cierre Fiscal</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo base_url();?>">Periodos Fiscales</a></li>
        </ul>
        <!-- ////-->
      </li>
    </ul>
    
  </div>
</nav>