<div id="listar" style="width: 450px;  position: absolute; z-index: 1000; background: white; display: none"  >
            <?php
                        
                         $i=1;
                       
                        if (!empty($idcuenta_contable)) {
                          echo"<table class='table table-striped table-bordered'>"
                          ." <tr>
                                <th>No°</th>
                                <th>Cuenta</th>
                                <th>Select</th>
                               
                            </tr> ";
                        foreach ($idcuenta_contable as $cat) {
                        $id = $cat['idcuenta_contable'];
                        echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cat['cuenta'] . "</td>
                        <td>" . "<input type='button' id='buscar_c' value='Select' name='".$id.'/'.$cat['cuenta']."'></input>" . "</td>
                        </tr>";

                        $i++;
                        }
                        echo "</table>";
            
                     } else {
           

            echo '<h4>No se encontraron categorias de cuentas</h4>';
        }
                        ?>
                        </div>
