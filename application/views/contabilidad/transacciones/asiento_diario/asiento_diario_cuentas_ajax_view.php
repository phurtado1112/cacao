<?php

$i = $num + 1;

if (!empty($consulta_cuentas)) {
    echo"<table class='table table-striped table-bordered'>
        <tr>
                                <th>No°</th>
                                <th>Cuenta</th>
                                <th>Select</th>
                               
                            </tr> ";
    foreach ($consulta_cuentas as $cat) {
        $id = $cat['idcuenta_contable'];
        echo"
                                   
                        <tr>
                        <td>" . $id . "</td>
                        <td>" . $cat['cuenta'] . "</td>
                        <td>" . "<input type='button' id='buscar_c' value='Select' name='" . $id . '/' . $cat['cuenta'] . "'></input>" . "</td>
                        </tr>";

        $i++;
    }
    echo "</table>";

    echo"<div align='center'>
                                <nav>
                                    <ul class='pagination'>
                                        " . $paginacion . "
                                    </ul>
                                </nav>
                                </div>";
} else {


    echo '<h4>No se encontraron categorias de cuentas</h4>';
}