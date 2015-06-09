<div class="container">
    <div class="row">
        <div class="span3 well">
            <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Lista de grupos de cuentas</h4>
            <div class="navbar navbar-inner block-header">
                <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/grupo_crear" class="btn btn-success fa fa-file-o fa-lg"> Nuevo</a></br></br> 
                <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/index/0" class="btn btn-success fa fa-list-alt fa-lg">Inactivas</a></br>
               
                <input type="text" id="valor" class="col-lg-offset-6">
               <button id="buscar" class="btn btn-default"><i class="fa fa-search fa-sm"></i></button>  
               
                <select id="campo" class="dropdown">
                    <option value="grupo_cuenta">Grupo Cuenta</option>
                    <option value="nivel">Nivel</option>
                    <option value="nivel_anterior">Nivel Anterior</option>
                    <option value="categoria">Categoria</option>
                </select>
                 <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/index/1" class="btn fa fa-refresh fa-lg " id="refescar"></a></br></br>
                
            </div>
            
            <div class="block-content collapse in valor" id="resultado"> 

            </div>
        </div>
    </div>
</div>

