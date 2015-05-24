function guardar_asiento_diario() {

    var idorigen_asiento_diario = $("select#idorigen_asiento_diario").val();
    var descripcion_asiento_diario = $("#descripcion_asiento_diario").val();
    var numero_asiento_diario = $("#numero_asiento_diario").val();
    var usuario_creacion = $("#usuario_creacion").val();
    var balance_credito = $("#total_credito").val();
    var balance_debito = $("#total_debito").val();
    var fecha_creacion = $("#recoge_fecha").val();
    var idtasa_cambio = $("#idtasa_cambio").val();
    var fecha_fiscal = $("#fecha_fiscal").val();

    var tasa_cambio = $("#tasa_cambio").val();


    if (descripcion_asiento_diario == null || descripcion_asiento_diario.length == 0) {
        alert('Es necesario el campo de descripcion');
    }
    else if (fecha_creacion == null || fecha_creacion.length == 0) {
        alert('Es necesario el campo de Fecha Creacion');
    }
    else if (fecha_fiscal == null || fecha_fiscal.length == 0) {
        alert('Es necesario el campo de Fecha Fiscal');

    }
    if (tasa_cambio === "ND" || tasa_cambio.length == 0) {
        alert('El tipo de cambio no es valido');

    } else {
        $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_guardar',
            type: 'POST',
            data: "idorigen_asiento_diario=" + idorigen_asiento_diario + "&numero_asiento_diario=" + numero_asiento_diario + "&descripcion_asiento_diario=" + descripcion_asiento_diario +
                    "&idtasa_cambio=" + idtasa_cambio + "&balance_debito=" + balance_debito + "&balance_credito=" + balance_credito + "&usuario_creacion=" + usuario_creacion + "&fecha_creacion=" + fecha_creacion +
                    "&fecha_fiscal=" + fecha_fiscal,
            success: function (data) {
                alert('Asiento Diario Creado');
                
                var transacciones = validar_transacciones();
                if (transacciones[0] === 0 && transacciones[1] === 0) {
                    guardar_transacciones(data);

                } else if (transacciones[0] > 0 && transacciones[1] === 0) {
                    alert("Usted tiene " + transacciones[0] + " montos vacios:\n\-Debe llenar los montos vacios con '0' ó cualquier numero.");

                } else if (transacciones[1] > 0 && transacciones[0] === 0) {
                    alert("Usted tiene " + transacciones[1] + " transacciones sin cuentas seleccionadas:\n\-Debe seleccionar una cuenta para cada transaccion.");

                } else if (transacciones[1] > 0 && transacciones[0] > 0) {
                    alert("Usted tiene " + transacciones[1] + " transacciones sin cuentas seleccionadas:\n\-Debe seleccionar una cuenta para cada transaccion." +
                            "\n\ \n\Usted tiene " + transacciones[0] + " montos vacios:\n\-Debe llenar los montos vacios con '0' ó cualquier numero.");
                }
            },
            error: function () {
                alert('Erro al crear Asiento Diario');
            }

        });
    }
    ;
}

function validar_transacciones() {
    var credito_not = 0;
    var debito_not = 0;
    var idcuenta_contable_not = 0;

    $(".asiento_diario_detalle").each(function () {

        var debito = $(this).find(".campo_debito").val();
        var credito = $(this).find(".campo_credito").val();
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();


        if (debito === "") {
            debito_not++;
        }

        if (credito === "") {
            credito_not++;

        }
        if (idcuenta_contable === "") {
            idcuenta_contable_not++;

        }

    });
    var campos_vacios = [debito_not + credito_not, idcuenta_contable_not];
    return campos_vacios;
}

function guardar_transacciones(idasiento_diario_creado) {
    
    $(".asiento_diario_detalle").each(function () {
        var idasiento_diario = idasiento_diario_creado;

        var numero_transacciones = $(this).find(".numero_transaccion").val();
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();

        var debito = $(this).find(".campo_debito").val();
        var credito = $(this).find(".campo_credito").val();

        var valor_tasa_cambio = $("#tasa_cambio").val();

        if (debito === "0.0" && credito !== "0.0") {
            var tipo_transaccion = "c";

            var monto_moneda_nacional = credito;
            var monto_moneda_extranjera = credito * valor_tasa_cambio;

        } else if (debito !== "0.0" && credito === "0.0") {
            var tipo_transaccion = "d";

            var monto_moneda_nacional = debito;
            var monto_moneda_extranjera = debito * valor_tasa_cambio;

        }

        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_detalle_guardar",
            type: "post",
            data: "idasiento_diario=" + idasiento_diario + "&numero_transacciones=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable + "&tipo_transaccion=" + tipo_transaccion + "&monto_moneda_nacional=" + monto_moneda_nacional + "&monto_moneda_extranjera=" + monto_moneda_extranjera,
            success: function (data) {
                alert(data + "Transacciones guardadas con exito");
            },
            error: function () {
                alert("Eror en el proceso de guradado de transacciones");
            }
        });
    });
}









$(document).ready(function () {




    $("#guardar").on("click", function () {
        guardar_asiento_diario();




    });



});