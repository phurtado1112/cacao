    <body>
        <div class="container">
            <div class="row">
                <div class="span3 well">
                    <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Lista de Catalogos Inactivos</h4>
                    <div class="navbar navbar-inner block-header">
                       <a href="<?php echo base_url(); ?>index.php/contabilidad/catalogo/cuentas/cuentas" class="btn btn-success fa fa-list-alt fa-lg">Regresar</a>
                    </div>

                    <div class="block-content collapse in" id="resultado"> 

                        <?php 
                       
                        $i=$num+1;
                        
                             if(!empty($consulta_catalogo)){
                                  echo"<table class='table table-striped table-bordered'>"
                            . " <tr>
                                <th>No°</th>
                                <th>Cuenta</th>
                                <th>Naturaleza</th>
                                <th>Grupo Cuenta</th>
                                <th>Activar</th>
                            </tr> ";
                                  
                              foreach ($consulta_catalogo as $cate) {
                                $id = $cate['idcuenta_contable'];
                                echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cate['cuenta'] . "</td>
                        <td>" . $cate['naturaleza'] . "</td>
                        <td>" . $cate['grupo_cuenta'] . "</td>
                        <td>" . '<a href="'.base_url().'index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_cambiar_estado/'.$id.'/1">Activar</a>'.
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
        <script src="<?php echo base_url(); ?>public/js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jquery-select.js"></script>
        <script src="<?php echo base_url(); ?>public/js/catalogo/busqueda_grupo-ajax.js"></script>
    </body>
</html>