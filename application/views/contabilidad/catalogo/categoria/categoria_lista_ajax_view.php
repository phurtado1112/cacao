<?php

$i = $num + 1;
if (!empty($consulta_categorias)) {
    echo"<table class='table table-striped table-bordered'>"
    . " <tr>
                                <th>No°</th>
                                <th>Categoría</th>
                                <th>Clasificación Principal</th>
                                <th>Modificar</th>
                                <th>Desactivar</th>
                            </tr> ";

    foreach ($consulta_categorias as $cate) {
        $id = $cate['idcategoria_cuenta'];
        echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cate['categoria'] . "</td>
                        <td>" . $cate['nombre'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/categoria/categoria/categoria_modificar/' . $id . '" class="fa fa-pencil fa-fw">Editar</a>' . "</td>
                        <td>" . '<a class="fa fa-ban fa-fw inactivar" value="'.$id.'">Inactivar</a>' .
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
} elseif (!empty($consulta_categorias_inactivas)) {
    echo"<table class='table table-striped table-bordered'>"
    . " <tr>
                                <th>No°</th>
                                <th>Categoría</th>
                                <th>Clasificación Principal</th>
                                <th>Activar</th>
                            </tr> ";

    foreach ($consulta_categorias_inactivas as $cate) {
        $id = $cate['idcategoria_cuenta'];
        echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cate['categoria'] . "</td>
                        <td>" . $cate['nombre'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/categoria/categoria/categoria_cambiar_estado/' . $id . '/1" class="fa fa-retweet fa-fw">Activar</a>' .
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

    echo "<h3 align='center'>No se encontraron resultados<h3>";
}

