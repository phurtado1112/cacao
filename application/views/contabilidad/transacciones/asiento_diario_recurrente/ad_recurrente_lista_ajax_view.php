<?php
$i = $num + 1;

if (!empty($consulta_ad_recurrente)) {
    ?>
        <table class="table table-striped recurrente">
            <thead>
                <tr>
                     <th class='tabletext'>N°</th>
                    <th>Descripción</th>
                    <th>Origen</th>
                    <th>Fecha Creacion</th>
                    <th>Fecha Modificacion</th>
                    <th class='tabletext'>Monto Debito</th>
                    <th class='tabletext'>Monto Credito</th>
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
                        <td class='tabletext'>" . $i . "</td>
                        <td>" . $ad['descripcion_asiento_diario_recurrente'] . "</td>
                        <td>" . $ad['descripcion_origen_asiento_diario'] . "</td>
                        <td>" . $ad['fecha_creacion'] . "</td>
                        <td>" . $fecha_mod . "</td>
                        <td class='tabletext'>" . $ad['balance_debito'] . "</td>
                        <td class='tabletext'>" . $ad['balance_credito'] . "</td>
                        <td class='ad'>" . '<a href="' . base_url() . 'index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_recurrente_modificar/'.$id_ad.'" class="fa fa-pencil fa-sm" >&nbsp;Editar</a> '
                              . '<a class="eliminar_ad fa fa-trash fa-sm" value="'.$id_ad.'">&nbsp;Eliminar</a> <a class="usar_ad fa fa-external-link fa-sm" href="' . base_url() . 'index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_crear/'.$id_ad.'">&nbsp;Usar</a>' . "</td>
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
               