<?php

$i = $num + 1;

if (!empty($consulta_cuentas)) {
    echo"<table class='table table-striped table-bordered'>"
    . " <tr>
                                <th class='tabletext'>No°</th>
                                <th>Cuenta</th>
                                <th>Decripcion</th>
                                <th>Naturaleza de Cuenta</th>
                                <th>Grupo de Cuenta</th>
                                <th class='tabletext'>Edicion</th>
                                <th class='tabletext'>Inactivacion</th>
                            </tr> ";
    foreach ($consulta_cuentas as $cat) {
        $id = $cat['idcuenta_contable'];
        if ($cat['naturaleza'] == "A") {
            $naturaleza = "Acreedora";
            
        } else if ($cat['naturaleza']) {
            $naturaleza = "Deudora";
        }

        echo"
                                   
                        <tr>
                        <td class='tabletext'>" . $i . "</td>
                        <td>" . $id . " </td>
                        <td>" . $cat['cuenta'] . "</td>
                        <td>" . $naturaleza . "</td>
                        <td>" . $cat['grupo_cuenta'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_modificar/' . $id . '"class="fa fa-pencil fa-fw"></a>' . "</td>
                        <td>" . '<a class="fa fa-ban fa-fw inactivar" value="' . $id . '"></a>' .
        "</tr>";

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
} elseif (!empty($consulta_cuentas_inactivas)) {
    echo"<table class='table table-striped table-bordered'>"
    . " <tr>
                                <th class='tabletext'>No°</th>
                                <th>Cuenta</th>
                                <th>Decripcion</th>
                                <th>Naturaleza</th>
                                <th>Grupo Cuenta</th>
                                <th class='tabletext'>Activar</th>
                                <th class='tabletext'>Eliminar</th>
                            </tr> ";

    foreach ($consulta_cuentas_inactivas as $cate) {
        $id = $cate['idcuenta_contable'];

        echo"
                                   
                        <tr>
                        <td class='tabletext'>" . $i . "</td>
                        <td>" . $id . "</td>
                        <td>" . $cate['cuenta'] . "</td>
                        <td>" . $cate['naturaleza'] . "</td>
                        <td>" . $cate['grupo_cuenta'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_cambiar_estado/' . $id . '/1 " class="fa fa-retweet fa-fw"></a></td>' .
                        '<td><a class="fa fa-trash fa-fw eliminar" value="'.$id.'"></a></td>' .
        "</tr>";

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
    echo '<h4 class="col-lg-offset-5">No se encontraron cuentas</h4>';
}


