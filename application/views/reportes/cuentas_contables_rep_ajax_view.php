<?php
if (!empty($cuentas)) {
    ?>
    <table class='table table-striped table-bordered'>
        <tr>
            <th>Categoría de Cuenta</th>
            <th>Grupo de Cuenta</th>
            <th>Cuenta</th>
            <th>Descripción</th>
            <th>Naturaleza de Cuenta</th>
        </tr>
        <?php
        foreach ($cuentas as $cat) {
//                $id = $cat['idcuenta_contable'];
//                if ($cat['naturaleza'] == "A") {
//                    $naturaleza = "Acreedora";
//                } else if ($cat['naturaleza']) {
//                    $naturaleza = "Deudora";
//                }
            ?>    
            <tr>
                <td><?= $cat['categoria_cuenta'] ?></td>
                <td><?= $cat['grupo_cuenta'] ?></td>
                <td><?= $cat['idcuenta_contable'] ?></td>
                <td><?= $cat['cuenta_contable'] ?></td>
                <td><?= $cat['naturaleza_cuenta_contable'] ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
    echo"<div align='center'>
        <nav>
            <ul class='pagination'>
                " . $paginacion . "
            </ul>
        </nav>
    </div>";
} else {
    ?>
    <table class='table table-striped table-bordered'>
        <tr>
            <th>Categoría de Cuenta</th>
            <th>Grupo Cuenta</th>
            <th>Cuenta</th>
            <th>Descripción</th>
            <th>Naturaleza</th>
        </tr>
        <tr><td colspan="5" style="text-align: center"><h2>NO HAY DATOS</h2></td></tr>
    </table>
    <?php
}
?>