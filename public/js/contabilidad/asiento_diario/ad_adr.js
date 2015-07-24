function asig_valores_recuperados() {
    var val = 1;
    $("tbody#campos_agregados>tr").each(function () {
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();
        var campo_descripcion = "#descripcion_cuenta_contable_" + val;
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/cuenta_por_id",
            type: "post",
            data: "idcuenta_contable=" + idcuenta_contable,
            success: function (data) {
                $(campo_descripcion).val(data);
            },
            error: function () {
                alert('error');
            }
        });
        val++;
    });
    $("html").data("num_reg", val - 1);
}

$(document).ready(function () {
    var url = "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_crear";

    if (window.location.href > url) {
        var valor_origen = $("#valor_origen_ad").val();
        $("select#idorigen_asiento_diario").find("option[value=" + valor_origen + "]").attr("selected", "selected");
        $("select#idorigen_asiento_diario").attr("disabled","disabled");

        var idtasa_cambio = $("#idtasa_cambio").val();
        $("#moneda>select").find("option[value=" + idtasa_cambio + "]").attr("selected", "selected");
        $("#moneda>select").attr("disabled","disabled");
        
        asig_valores_recuperados();
    }
});