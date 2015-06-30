<?php

$i = $num + 1;
if (!empty($consulta_categorias)) {
    echo"<table class='table table-striped table-bordered'>"
    . " <tr>
                                <th class='tabletext'>No°</th>
                                <th>Categoría</th>
                                <th>Tipo</th>
                                <th class='tabletext'>Modificar</th>
                                <th class='tabletext'>Desactivar</th>
                            </tr> ";

    foreach ($consulta_categorias as $cate) {
        $id = $cate['idcategoria_cuenta'];
        echo"
                                   
                        <tr>
                        <td class='tabletext'>" . $i . "</td>
                        <td>" . $cate['categoria'] . "</td>
                        <td>" . $cate['nombre'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/categoria/categoria/categoria_modificar/' . $id . '" class="fa fa-pencil fa-fw"></a>' . "</td>
                        <td>" . '<a class="fa fa-ban fa-fw inactivar" value="'.$id.'"></a>' .
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
} else if (!empty($consulta_categorias_inactivas)) {
    echo"<table class='table table-striped table-bordered'>"
    . " <tr>
                                <th class='tabletext'>No°</th>
                                <th>Categoría</th>
                                <th>Tipo</th>
                                <th class='tabletext'>Activar</th>
                                <th class='tabletext'>Eliminar</th>
                            </tr> ";

    foreach ($consulta_categorias_inactivas as $cate) {
        $id = $cate['idcategoria_cuenta'];
        echo"
                                   
        <tr>
                        <td class='tabletext'>" . $i . "</td>
                        <td>" . $cate['categoria'] . "</td>
                        <td>" . $cate['nombre'] . "</td>
                        <td>" . "<a href='" . base_url() . "index.php/contabilidad/catalogo/categoria/categoria/categoria_cambiar_estado/" . $id . "/1' class='fa fa-retweet fa-fw'></a></td>
                        <td>" . "<a value=".$id." class='fa fa-trash fa-fw eliminar'></a></td>" .
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

    echo '<h4 class="col-lg-offset-5">No se encontraron resultados<h4>';
}

