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
          <option value="2" selected="TRUE">Administracion</option>
          <option value="3">Bancos</option>
      </select>
  </div>
 
  <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav">
      <li class="active"><a href="<?php echo base_url(); ?>index.php/administracion/administracion">Inicio</a></li>
    </ul>
    
    <div id="modulo_menu" >  
       <!-- ////////////////////////////////////////////////////-->
       <ul class="nav navbar-nav">
      <li ><a href="<?php echo base_url(); ?>">Transacciones</a></li>
    </ul>
      
    <ul class="nav navbar-nav">
      <li class="dropdown">
          <!-- ////-->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catálogos <b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo base_url();?>">Ususarios</a></li>
        </ul>
        <!-- ////-->
      </li>
    </ul>
    
       
    <ul class="nav navbar-nav">
      <li class="dropdown">
          <!-- ////-->
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes<b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li><a href="<?php echo base_url();?>">Reportes de usuarios</a></li>
        </ul>
        <!-- ////-->
      </li>
    </ul>
       
    <ul class="nav navbar-nav">
      <li ><a href="<?php echo base_url(); ?>">Operaciones</a></li>
    </ul>
    <!-- ////////////////////////////////////////////////////-->
    </div>
  </div>
</nav>