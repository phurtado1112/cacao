<?php
$i = $num + 1;
if (!empty($consulta_grupo)) {
    
    echo"<table class='table table-striped table-bordered'>"
    . " <tr>
                                <th class='tabletext'>No°</th>
                                <th>Grupo Cuenta</th>
                                <th class='tabletext'>Nivel</th>
                                <th class='tabletext'>Nivel Anterior</th>
                                <th>Categoria</th>
                                <th class='tabletext'>Edicion</th>
                                <th class='tabletext'>Inactivacion</th>
                            </tr> ";
    foreach ($consulta_grupo as $cat) {
        $id = $cat['idgrupo_cuenta'];
        echo"
                                   
                        <tr>
                        <td class='tabletext'>" . $i . "</td>
                        <td>" . $cat['grupo_cuenta'] . "</td>
                        <td class='tabletext'>" . $cat['nivel'] . "</td>
                        <td class='tabletext'>" . $cat['nivel_anterior'] . "</td>
                        <td>" . $cat['categoria'] . "</td>   
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/grupo_modificar/' . $id . '"class="fa fa-pencil fa-fw"></a>' . "</td>
                        <td>" . '<a class="fa fa-ban fa-fw inactivar" value="'.$id.'"></a></td>' .
                        

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
} else if (!empty($consulta_grupo_inactivos)) {

    echo"<table class='table table-striped table-bordered'>"
    . " <tr>
                                <th class='tabletext'>No°</th>
                                <th>Grupo Cuenta</th>
                                <th class='tabletext'>Nivel</th>
                                <th class='tabletext'>Nivel Anterior</th>
                                <th>Categoria</th>
                                <th class='tabletext'>Activar</th>
                                <th class='tabletext'>Eliminar</th>
                            </tr> ";

    foreach ($consulta_grupo_inactivos as $cate) {
        $id = $cate['idgrupo_cuenta'];
        echo"
                                   
                        <tr>
                        <td class='tabletext'>" . $i . "</td>
                        <td>" . $cate['grupo_cuenta'] . "</td>
                        <td class='tabletext'>" . $cate['nivel'] . "</td>
                        <td class='tabletext'>" . $cate['nivel_anterior'] . "</td>
                        <td>" . $cate['categoria'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/grupo_cambiar_estado/' . $id . '/1" class="fa fa-retweet fa-fw"></a>' .
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

    echo '<h4 class="col-lg-offset-5">No se encontraron categorias de cuentas</h4>';
}

