function guargar_contabilidad_config(anio_fiscal, decimales_redondeo, periodo_actual, patron_cuenta, cuenta_contable, bancos
        , inventarios, compras, cuentas_por_pagar, cuentas_por_cobrar, facturas) {

    $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_guardar',
        type: 'POST',
        data: "anio_fiscal=" + anio_fiscal + "&decimales_redondeo" + decimales_redondeo + "&periodo_actual=" + periodo_actual
                + "&patron_cuenta" + patron_cuenta + "&cuenta_contable" + cuenta_contable + "&bancos" + bancos + "&inventarios=" + inventarios
                + "&compras=" + compras + "&cuentas_por_pagar=" + cuentas_por_pagar + "&cuentas_por_cobrar=" + cuentas_por_cobrar
                + "&facturas=" + facturas,
        success: function (data) {
            alert(data);

        },
        error: function () {
            alert('Error al guardar su configuracion');
        }

    });

}


$(document).ready(function () {
    $("#anio_fiscal").validarCampo("0123456789");
    $("#periodo_actual").validarCampo("0123456789");
    $("#periodo_actual").validarCampo("9-");




    $("#guardar").on("click", function () {
//        alert($("#anio_fiscal").val() + " " + $("#periodo_actual").val() + " " + $("#patron_cuenta").val());

        $("input:checkbox:checked").each(function () {
            alert($(this).val());
        });
        
        

    });



}); 