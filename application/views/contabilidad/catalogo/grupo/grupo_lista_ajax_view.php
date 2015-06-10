<?php
$i = $num + 1;
if (!empty($consulta_grupo)) {
    
    echo"<table class='table table-striped table-bordered'>"
    . " <tr>
                                <th>No°</th>
                                <th>Grupo Cuenta</th>
                                <th>Nivel</th>
                                <th>Nivel Anterior</th>
                                <th>Categoria</th>
                                <th>Edicion</th>
                                <th>Inactivacion</th>
                            </tr> ";
    foreach ($consulta_grupo as $cat) {
        $id = $cat['idgrupo_cuenta'];
        echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cat['grupo_cuenta'] . "</td>
                        <td>" . $cat['nivel'] . "</td>
                        <td>" . $cat['nivel_anterior'] . "</td>
                        <td>" . $cat['categoria'] . "</td>   
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/grupo_modificar/' . $id . '"class="fa fa-pencil fa-fw">Editar</a>' . "</td>
                        <td>" . '<a class="fa fa-ban fa-fw inactivar" value="'.$id.'">Inactivar</a></td>' .
                        

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
} elseif (!empty($consulta_grupo_inactivos)) {

    echo"<table class='table table-striped table-bordered'>"
    . " <tr>
                                <th>No°</th>
                                <th>Grupo Cuenta</th>
                                <th>Nivel</th>
                                <th>Nivel Anterior</th>
                                <th>Categoria</th>
                                <th>Activar</th>
                                <th>Eliminar</th>
                            </tr> ";

    foreach ($consulta_grupo_inactivos as $cate) {
        $id = $cate['idgrupo_cuenta'];
        echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cate['grupo_cuenta'] . "</td>
                        <td>" . $cate['nivel'] . "</td>
                        <td>" . $cate['nivel_anterior'] . "</td>
                        <td>" . $cate['categoria'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/grupo_cambiar_estado/' . $id . '/1" class="fa fa-retweet fa-fw">Activar</a>' .
                        '<td><a  href="' . base_url() . 'index.php/contabilidad/catalogo/grupo/grupo/grupo_eliminar/' . $id . '" class="fa fa-retweet fa-fw">Eliminar</a></td>' .
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

