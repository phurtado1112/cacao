<?php

$i = $num + 1;
if (!empty($consulta_usuario)) {
    echo"<table class='table table-striped table-bordered'>"
    . " <tr>
                                <th>No°</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Usuario</th>
                                <th>Editar</th>
                                <th>Cambiar Clave</th>
                                <th>Desactivar</th>
                            </tr> ";

    foreach ($consulta_usuario as $cate) {
        $id = $cate['idusuario'];
        echo"
                                   
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $cate['nombre'] . "</td>
                        <td>" . $cate['apellido'] . "</td>
                        <td>" . $cate['usuario'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/administracion/usuario/usuario_procesar/usuario_editar/' . $id . '" class="fa fa-pencil fa-fw">Editar</a>' . "</td>
                             <td>" . '<a href="' . base_url() . 'index.php/administracion/usuario/usuario_procesar/usuario_editar_pass/' . $id . '" class="fa fa-pencil fa-fw">Cambiar Clave</a>' . "</td>
                        <td>" . '<a class="fa fa-ban fa-fw inactivar inactivar" value="' . $id . '">Inactivar</a>' .
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
} 

elseif (!empty($consulta_usuario_inactivos)) {
    echo"<table class='table table-striped table-bordered'>"
    . " <tr>
                                <th>No°</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Usuario</th>
                                <th>Activar</th>
                                <th>Eliminar</th>
                            </tr> ";

    foreach ($consulta_usuario_inactivos as $cate) {
        $id = $cate['idusuario'];
        echo"
                                   
       <tr>
                        <td>" . $i . "</td>
                        <td>" . $cate['nombre'] . "</td>
                        <td>" . $cate['apellido'] . "</td>
                        <td>" . $cate['usuario'] . "</td>
                        <td>" . "<a href='" . base_url() . "index.php/administracion/usuario/usuario_procesar/usuario_cambiar_estado/" . $id . "/1' class='fa fa-retweet fa-fw'>Activar</a></td>
                        <td>" . "<a href='" . base_url() . "index.php/administracion/usuario/usuario_procesar/usuario_eliminar/" . $id . "' class='fa fa-trash fa-fw'>Eliminar</a></td>" .
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
}
else {

    echo '<h4 class="col-lg-offset-5">No se encontraron resultados<h4>';
}
