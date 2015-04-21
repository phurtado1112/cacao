
<form id="form1" name="form1" method="post" >
    N. de Productos a Registrar:
    <input name="cantidad" type="number" min="1" id="cantidad" value="1" />
    <input type="submit" name="Submit" value="Ok" />
</form>

<?php $cantidad='cantidad'; ?>
<?php if ($cantidad > 0) { ?>
    <br /><br />
    <form method="POST">
        <table width="auto" border="0">
            <tr>
                <td colspan="3">
                    <p>No. Factura:
                        <input type="text" name="factura" id="factura" required >
                    </p>           
                </td>
            </tr>
            <tr>
                <td>No.</td>
                <td>Nombre Producto:</td>
                <td>Descripcion Producto:</td>
            </tr>
            <?php
            $cantidad = 1;
            While ($cantidad <= $_POST['cantidad']) {
                ?>
                <td><?php echo "$cantidad"; ?></td>
                <td><input type="text" name="producto<?php echo "$cantidad"; ?>" required="required"></td>
                <td><input type="text" name="descripcion<?php echo "$cantidad"; ?>" required="required"></td>
                <td><input type="hidden" name="num<?php echo "$cantidad"; ?>"  />
                    <input name="cantidad" type="hidden" id="cantidad" value="<?php echo "$_POST[cantidad]" ?>" /></td>
                    <?php
                    $cantidad++;
                }
                ?>

            <tr>
                <td colspan="3" align="right">
                    <button type ="submit" name="submit" >Guardar</button>
                </td>
            <?php } ?>  
        </tr>
    </table>
</form>
