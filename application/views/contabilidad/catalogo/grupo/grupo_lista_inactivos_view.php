<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="<?php echo base_url(); ?>bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/font-awesome-4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>public/css/estilo.css">
        <meta charset="UTF-8">
        <title>Lista de Categorias</title>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="span3 well">
                    <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Lista de Grupos Inactivos</h4>
                    <div class="navbar navbar-inner block-header">
                       <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/grupo/grupo" class="btn btn-success fa fa-list-alt fa-lg"> Cuentas Activas</a>
                    </div>

                    <div class="block-content collapse in" id="resultado"> 

                        <?php 
                       
                        $i=$num+1;
                        
                             if(!empty($consulta_grupo)){
                                  echo"<table class='table table-striped table-bordered'>"
                            . " <tr>
                                <th>No°</th>
                                <th>Grupo Cuenta</th>
                                <th>Nivel</th>
                                <th>Nivel Anterior</th>
                                <th>Categoria</th>
                                <th>Activar</th>
                            </tr> ";
                                  
                              foreach ($consulta_grupo as $cate) {
                                $id = $cate['idgrupo_cuenta'];
                                echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cate['grupo_cuenta'] . "</td>
                        <td>" . $cate['nivel'] . "</td>
                        <td>" . $cate['nivel_anterior'] . "</td>
                        <td>" . $cate['categoria'] . "</td>
                        <td>" . '<a href="'.base_url().'index.php/contabilidad/catalogo/grupo/grupo/grupo_cambiar_estado/'.$id.'/1">Activar</a>'.
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
                                 
                             }else{
                                 
                                 echo "<h3 align='center'>No se encontraron resultados<h3>";
                             }
                        
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>bootstrap/js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jquery-select.js"></script>
        <script src="<?php echo base_url(); ?>public/js/busqueda-ajax.js"></script>
    </body>
</html>