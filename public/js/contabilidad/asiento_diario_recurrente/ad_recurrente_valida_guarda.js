
function guardar_asiento_diario_recurrente() {

    var idorigen_asiento_diario = $("select#idorigen_asiento_diario").val();
    var descripcion_asiento_diario = $("#descripcion_asiento_diario").val();
    var usuario_creacion = $("#usuario_creacion").val();
    var balance_credito = $("#total_credito").val();
    var balance_debito = $("#total_debito").val();
    var fecha_creacion = $("#recoge_fecha").val();
    var idmoneda = $("select[name=idmoneda]").val();

    var transacciones = validar_transacciones();

    if (descripcion_asiento_diario == null || descripcion_asiento_diario.length == 0) {
        alert('Es necesario el campo de descripcion');
    }
    else if (fecha_creacion == null || fecha_creacion.length == 0) {
        alert('Es necesario el campo de Fecha Creacion');

    } else if (transacciones[0] > 0 && transacciones[1] === 0) {
        alert("Usted tiene " + transacciones[0] + " transaccion sin monto:\n\-Debe establecer los montos con cualquier numero mayor a cero.");

    }
    else if (transacciones[1] > 0 && transacciones[0] === 0) {
        alert("Usted tiene " + transacciones[1] + " transacciones sin cuentas seleccionadas:\n\-Debe seleccionar una cuenta para cada transaccion.");

    }
    else if (transacciones[1] > 0 && transacciones[0] > 0) {
        alert("Usted tiene " + transacciones[1] + " transacciones sin cuentas seleccionadas:\n\-Debe seleccionar una cuenta para cada transaccion." +
                "\n\ \n\Usted tiene " + transacciones[0] + " transaccion sin monto:\n\-Debe establecer los montos con cualquier numero mayor a cero.");

    }
    else if (balance_credito !== balance_debito) {
        alert("Usted debe balancear el asiento para poder guardarlo");

    } else if ($("#valor_dolar").val() === "0") {
        alert("No se a encontrado tipo de cambio extranjero asociado a esta fecha fiscal");

    }
    else if (transacciones[0] === 0 && transacciones[1] === 0) {
//        alert("idorigen_asiento_diario=" + idorigen_asiento_diario + "&descripcion_asiento_diario=" + descripcion_asiento_diario +
//                    "&idmoneda=" + idmoneda + "&balance_debito=" + balance_debito + "&balance_credito=" + balance_credito + 
//                    "&usuario_creacion="+ usuario_creacion + "&fecha_creacion=" + fecha_creacion
//                  );

        $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_recurrente_guardar',
            type: 'POST',
            data: "idorigen_asiento_diario=" + idorigen_asiento_diario + "&descripcion_asiento_diario=" + descripcion_asiento_diario +
                    "&idmoneda=" + idmoneda + "&balance_debito=" + balance_debito + "&balance_credito=" + balance_credito +
                    "&usuario_creacion=" + usuario_creacion + "&fecha_creacion=" + fecha_creacion,
            success: function (data) {
                guardar_transacciones(data);

            },
            error: function () {
                alert('Error al crear Asiento Diario');
            }

        });
    }
    ;
}

function validar_transacciones() {
    var montos_vacios = 0;
    var idcuenta_contable_not = 0;

    $(".asiento_diario_detalle").each(function () {

        var debito = $(this).find(".campo_debito").val();
        var credito = $(this).find(".campo_credito").val();
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();


        if (debito === "" || credito === "") {
            montos_vacios++;
        }
        else if (idcuenta_contable === "") {
            idcuenta_contable_not++;

        } else if (debito == 0 && credito == 0) {
            montos_vacios++;
        }

    });
    var campos_vacios = [montos_vacios, idcuenta_contable_not];
    return campos_vacios;
}



function guardar_transacciones(idasiento_diario_creado) {
    var numero_transacciones_totales = $(".numero_transaccion:last").val();

    $(".asiento_diario_detalle").each(function () {
        var idasiento_diario = idasiento_diario_creado;

        var numero_transacciones = $(this).find(".numero_transaccion").val();
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();

        var debito = $(this).find(".campo_debito").val();
        var credito = $(this).find(".campo_credito").val();

        var idmoneda = $("#moneda>select").val();

        if (debito === "0.0" && credito !== "0.0") {
            var tipo_transaccion = "a";

            var monto_transaccion = credito;

        } else if (debito !== "0.0" && credito === "0.0") {
            var tipo_transaccion = "d";

            var monto_transaccion = debito;

        }
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_detalle_recurrente_guardar",
            type: "post",
            data: "idasiento_diario=" + idasiento_diario + "&numero_transaccion=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable + "&tipo_transaccion=" + tipo_transaccion + "&monto_transaccion=" + monto_transaccion,
            success: function () {

                if (numero_transacciones_totales === numero_transacciones) {
                    var res = confirm("Asiento de Diario Recurrente fue creado con exito\n\¿Desea crear otro Asiento de Diario Recurrente?");
                    if (res === true) {
                        window.location = 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_recurrente_crear';

                    } else if (res === false) {
                        window.location = 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente';

                    }
                }
            },
            error: function () {
                if (numero_transacciones_totales === numero_transacciones) {
                alert("Error en el proceso de guardado de transacciones");
            }

            }
        }).fail(function () {
            $.ajax({
                url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_recurrente_eliminar/" + idasiento_diario + "/" + 0,
                type: "post",
                success: function () {
                    if (numero_transacciones_totales === numero_transacciones) {
                    alert("El asiento de diario no pudo ser creado");
                }
                }
            });

        });
    });
}

$(document).ready(function () {

    $("#guardar").on("click", function () {

        guardar_asiento_diario_recurrente();

    });



});