 <body>
        <div class="container">
            <div class="row">
                <div class="span3 well">
                    <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Lista de categoria de cuentas</h4>
                    <div class="navbar navbar-inner block-header">
                        
                        <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/categoria/categoria/categoria_crear" class="btn btn-success fa fa-file-o fa-lg"> Nueva Categoría de Cuenta</a></br></br> 
                        <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/categoria/categoria/index/0" class="btn btn-success fa fa-list-alt fa-lg"> Categorias Inactivas</a>
                        <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/categoria/categoria/index/1" class="btn btn-success fa fa-refresh fa-lg col-lg-offset-7">Recargar</a></br></br>
                        
                        <input type="text" id="valor" class="col-lg-offset-6">
                        <select id="campo" class="dropdown">
                            <option value="categoria">Categoria</option>
                            <option value="nombre">Clasificacion Principal</option>
                        </select>
                         
                         <button class="btn btn-default"id="buscar" type="button"><i class="fa fa-search fa-lg"></i></button>
                             
                    </div>

                    <div class="block-content collapse in" id="resultado"> 

                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>public/js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/busqueda-ajax.js"></script>
    </body>
</html>