<?php
                 
if (!empty($consulta_asiento_diario)) {
    ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class='tabletext'>No.AD</th>
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
                        $id_ad = $ad['idasiento_diario'];
                        echo"
                        <tr>
                        
                        <td class='tabletext'>" . $id_ad . "</td>
                        <td>" . $ad['origen'] . "</td>
                        <td>" . $ad['descripcion_asiento_diario'] . "</td>
                        <td>" . $ad['fecha_creacion'] . "</td>
                        <td class='tabletext'>" . $ad['balance_debito_nacional'] . "</td>
                        <td class='tabletext'>" . $ad['balance_credito_nacional'] . "</td>
                        <td class='ad'>" . '<a  class="fa fa-pencil fa-sm" href="' . base_url() . 'index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_modificar/'.$id_ad.'">&nbsp;Editar</a> | '
                              . '<a class="eliminar_ad fa fa-trash fa-sm" value="'.$id_ad.'">&nbsp;Eliminar</a> | ' 
                              . '<a class="fa fa-external-link fa-sm" href="'. base_url() . 'index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_mayorizar/'.$id_ad.'">&nbsp;Mayorizar</a>'."</td>
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
               