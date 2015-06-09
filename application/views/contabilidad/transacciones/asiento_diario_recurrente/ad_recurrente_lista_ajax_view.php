<?php
$i = $num + 1;

if (!empty($consulta_ad_recurrente)) {
    ?>
        <table class="table table-striped">
            <thead>
                <tr>
                     <th>N°</th>
                    <th>Descripción</th>
                    <th>Origen</th>
                    <th>Fecha Creacion</th>
                    <th>Fecha Modificacion</th>
                    <th>Monto Debito</th>
                    <th>Monto Credito</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                
     <?php
                
                   
                    foreach ($consulta_ad_recurrente as $ad) {
                        $id_ad = $ad['idasiento_diario_recurrente'];
                        if($ad['fecha_modificacion']!=""){
                            $fecha_mod =$ad['fecha_modificacion'];
                        }else{
                            $fecha_mod = "ND";
                        }
                        echo"
                        <tr>
                        <td>" . $i . "</td>
                        <td>" . $ad['descripcion_asiento_diario_recurrente'] . "</td>
                        <td>" . $ad['descripcion_origen_asiento_diario'] . "</td>
                        <td>" . $ad['fecha_creacion'] . "</td>
                        <td>" . $fecha_mod . "</td>
                        <td>" . $ad['balance_debito'] . "</td>
                        <td>" . $ad['balance_credito'] . "</td>
                        <td>" . '<a href="' . base_url() . 'index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_recurrente_modificar/'.$id_ad.'">Editar</a> -- '
                              . '<a class="eliminar_ad" value="'.$id_ad.'">Eliminar</a>' . "</td>
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

    echo '<h4>No se encontraron Asientos de diario recurrentes</h4>';
}
               