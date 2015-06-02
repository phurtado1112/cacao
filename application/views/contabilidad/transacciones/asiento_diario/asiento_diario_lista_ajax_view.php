<?php
                 
if (!empty($consulta_asiento_diario)) {
    ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.AD</th>
                    <th>Origen</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Monto Debito</th>
                    <th>Monto Credito</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                
     <?php
                
                   
                    foreach ($consulta_asiento_diario as $ad) {
                        $num_ad = $ad['numero_asiento_diario'];
                        $id_ad = $ad['idasiento_diario'];
                        echo"
                        <tr>
                        
                        <td>" . $ad['numero_asiento_diario'] . "</td>
                        <td>" . $ad['origen'] . "</td>
                        <td>" . $ad['descripcion_asiento_diario'] . "</td>
                        <td>" . $ad['fecha_creacion'] . "</td>
                        <td>" . $ad['balance_debito'] . "</td>
                        <td>" . $ad['balance_credito'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_modificar/' . $num_ad . '/'.$id_ad.'">Editar</a> -- '
                              . '<a class="fa fa-ban fa-fw eliminar" value="'.$id_ad.'">Eliminar</a>' ."</td>
                        </tr>";
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

    echo '<h4>No se encontraron Asientos de diario</h4>';
}
               