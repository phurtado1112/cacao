<html>
    <body>
        <div class="container">
            <div class="row">
                <div class="span3 well">
                    <h4 class="fa fa-align-justify fa-lg col-lg-offset-5"> Lista de cuentas contables</h4>
                    <div class="navbar navbar-inner block-header">
                        <a href="<?php echo base_url()?>index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_crear" class="btn btn-success fa fa-file-o fa-lg"> Nueva Cuenta Contable</a></br></br> 
                        <a href="<?php echo base_url()?>index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_listar_inactivas" class="btn btn-success fa fa-list-alt fa-lg"> Cuentas Inactivas</a>
                        <a href="<?php echo base_url()?>index.php/contabilidad/catalogo/cuentas/cuentas/index" class="btn btn-success fa fa-refresh fa-lg col-lg-offset-7">Recargar</a></br></br>
                        <input type="text" id="valor" class="col-lg-offset-6">
                        <select id="campo" class="dropdown">
                        <option value="cuenta">Cuentas</option>
                        <option value="naturaleza">Naturaleza de Cuenta</option>
                        <option value="grupo_cuenta">Grupo de cuentas</option>
                        </select>
                        <button id="buscar" class="btn btn-success">Buscar</button>
                    </div>
                    <div class="block-content collapse in" id="resultado"> 

                        <?php
                        
                         $i=$num+1;
                       
                        if (!empty($consulta_catalogo)) {
                          echo"<table class='table table-striped table-bordered'>"
                          ." <tr>
                                <th>No°</th>
                                <th>Cuenta</th>
                                <th>Naturaleza de Cuenta</th>
                                <th>Grupo de Cuenta</th>
                                <th>Edicion</th>
                                <th>Inactivacion</th>
                            </tr> ";
            foreach ($consulta_catalogo as $cat) {
                $id = $cat['idcuenta_contable'];
                echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cat['cuenta'] . "</td>
                        <td>" . $cat['naturaleza'] . "</td>
                        <td>" . $cat['grupo_cuenta'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_modificar/' . $id . '"class="fa fa-pencil fa-fw">Editar</a>' . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_cambiar_estado/' . $id . '/0"class="fa fa-ban fa-fw">Inactivar</a>' .
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
        <script src="<?php echo base_url(); ?>public/js/jquery-2.1.3.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>public/js/jquery-select.js"></script>
        <script src="<?php echo base_url(); ?>public/js/busqueda_catalogo-ajax.js"></script>
    </body>
</html>
