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
                    <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/grupo_crear" class="btn btn-success fa fa-file-o fa-lg"> Nuevo Grupo de Cuentas</a></br></br> 
                    <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/grupo_listar_inactivas" class="btn btn-success fa fa-list-alt fa-lg"> Grupos de cuentas Inactivas</a>
                    <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo/index" class="btn btn-success fa fa-refresh fa-lg col-lg-offset-6">Recargar</a></br></br>
                    <input type="text" id="valor" class="col-lg-offset-6">
                    <select id="campo" class="dropdown">
                    <option value="grupo_cuenta">Grupo Cuenta</option>
                    <option value="nivel">Nivel de la Cuenta</option>
                    <option value="nivel_anterior">Nivel Anterior</option>
                    <option value="categoria">Categoria</option>
                    </select>
                    <button id="buscar" class="btn btn-success">Buscar</button>
                    </div>
                    <div class="block-content collapse in" id="resultado"> 
                        
                            <?php  
                            
                             $i=$num+1;
                       
                        if (!empty($consulta_grupo)) {
                          echo"<table class='table table-striped table-bordered'>"
                          ." <tr>
                                <th>No°</th>
                                <th>Grupo Cuenta</th>
                                <th>Nivel</th>
                                <th>Nivel Anterior</th>
                                <th>Categoria</th>
                                <th>Edicion</th>
                                <th>Inactivacion</th>
                            </tr> ";
            foreach ($consulta_grupo as $cat) {
                $id = $cat['idgrupo_cuenta'];
                echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cat['grupo_cuenta'] . "</td>
                        <td>" . $cat['nivel'] . "</td>
                        <td>" . $cat['nivel_anterior'] . "</td>
                        <td>" . $cat['categoria'] . "</td>   
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/grupo_modificar/' . $id . '"class="fa fa-pencil fa-fw">Editar</a>' . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/grupo_cambiar_estado/' . $id . '/0"class="fa fa-ban fa-fw">Inactivar</a>' .
                "</tr>";

                $i++;
            }
            echo "</table>";
            
             echo"<div align='center'>
                                <nav>
                                    <ul class='pagination'>
                                        ".$paginacion."
                                    </ul>
                                </nav>
                                </div>";
                        } else {
           

            echo '<h4>No se encontraron categorias de cuentas</h4>';
        }
                            
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
