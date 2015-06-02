<?php

$i = $num + 1;

if (!empty($consulta_cuentas)) {
    echo"<table class='table table-bordered table-condensed table-hover'>
        <tr >
                                <th>No°</th>
                                <th>Cuenta</th>
                               
                            </tr> ";
    foreach ($consulta_cuentas as $cat) {
        $id = $cat['idcuenta_contable'];
        echo"
                                   
                        <tr id='buscar_c' name='" . $id . '/' . $cat['cuenta'] . "'>
                        <td>" . $id . "</td>
                        <td>" . $cat['cuenta'] . "</td>
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


    echo '<h4>No se encontraron cuentas</h4>';
}