

function editar_asiento_diario(numero_transacciones_totales_inicio) {
     
    var id_ad_recurrente =  $('#idasiento_diario_recurrente').val();
    var idorigen_asiento_diario = $("select#idorigen_asiento_diario").val();
    var descripcion_asiento_diario = $("#descripcion_asiento_diario").val();
    var usuario_edicion = $("#usuario_edicion").val();
    var balance_credito = $("#total_credito").val();
    var balance_debito = $("#total_debito").val();
    var fecha_edicion = $("#fecha_edicion").val();
    var idtasa_cambio = $("#idtasa_cambio").val();


    var tasa_cambio = $("#tasa_cambio").val();
    var transacciones = validar_transacciones();

    var numero_transacciones_totales = $(".numero_transaccion_editar:last").val();


    if (descripcion_asiento_diario == null || descripcion_asiento_diario.length == 0) {
        alert('Es necesario el campo de descripcion');
    }
    else if (fecha_edicion == null || fecha_edicion.length == 0) {
        alert('Es necesario el campo de Fecha Creacion');
    }
    else if (tasa_cambio === "ND" || tasa_cambio.length == 0) {
        alert('El tipo de cambio no es valido');

    }
    else if (transacciones[0] > 0 && transacciones[1] === 0) {
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
        $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_recurrente_editar',
            type: 'POST',
            data:  "&descripcion_asiento_diario=" + descripcion_asiento_diario +
                    "&idtasa_cambio=" + idtasa_cambio + "&balance_debito=" + balance_debito + "&balance_credito=" + balance_credito + "&usuario_edicion=" + usuario_edicion +
                    "&fecha_edicion=" + fecha_edicion +"&origen_asiento_diario="+idorigen_asiento_diario+"&id_ad_recurrente="+id_ad_recurrente,
            success: function () {
                editar_transacciones(id_ad_recurrente);
                eliminar_transacciones(id_ad_recurrente, numero_transacciones_totales_inicio);
                guardar_transacciones(id_ad_recurrente);
//                
                alert("Asiento editado");

            },
            error: function () {
                alert('Error al actualizar Asiento Diario');
            }

        });
    }

}

function validar_transacciones() {
    var montos_vacios = 0;
    var idcuenta_contable_not = 0;

    $(".ad_detalle_editar").each(function () {

        var debito = $(this).find(".campo_debito").val();
        var credito = $(this).find(".campo_credito").val();
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();

        if (debito === "" || credito === "") {
            montos_vacios++;
        }
        else if (idcuenta_contable === "") {
            idcuenta_contable_not++;

        }
        if (debito == 0 && credito == 0) {
            montos_vacios++;
        }

    });

    $(".asiento_diario_detalle").each(function () {

        var debito = $(this).find(".campo_debito").val();
        var credito = $(this).find(".campo_credito").val();
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();

        if (debito === "" || credito === "") {
            montos_vacios++;
        }
        else if (idcuenta_contable === "") {
            idcuenta_contable_not++;

        }
        if (debito == 0 && credito == 0) {
            montos_vacios++;
        }

    });

    var campos_vacios = [montos_vacios, idcuenta_contable_not];
    return campos_vacios;
}

function editar_transacciones(idasiento_diario_editado) {
    var numero_transacciones_totales = $(".numero_transaccion_editar:last").val();

    $(".ad_detalle_editar").each(function () {
        ///adapatra lo que sigue
        var idasiento_diario = idasiento_diario_editado;
        var idasiento_diario_detalle = $(this).find("#id_transaccion_editar").val();

        var numero_asiento_diario = $("numero_asiento_diario");

        var numero_transacciones = $(this).find(".numero_transaccion_editar").val();
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();

        var debito = $(this).find(".campo_debito").val();
        var credito = $(this).find(".campo_credito").val();

        var idmoneda = $("#moneda>select").val();

        if ((debito === "0" && credito !== "0") || (debito === "0.0" && credito !== "0.0")) {
            var tipo_transaccion = "c";

            var monto = credito;

        } else if ((debito !== "0" && credito === "0") || (debito !== "0.0" && credito === "0.0")) {
            var tipo_transaccion = "d";

            var monto = debito;

        }

        var valor_dolar = $("#valor_dolar").val();

        if (idmoneda === "1") {
            var monto_moneda_nacional = monto;
            var monto_moneda_extranjera = monto / valor_dolar;

        } else if (idmoneda === "2") {
            var monto_moneda_nacional = monto * valor_dolar;
            var monto_moneda_extranjera = monto;
        }

//        alert("idasiento_diario_detalle=" + idasiento_diario_detalle + "&numero_transacciones=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable + "&tipo_transaccion=" + tipo_transaccion + "&monto_moneda_nacional=" + monto_moneda_nacional + "&monto_moneda_extranjera=" + monto_moneda_extranjera);
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_detalle_recurrente_editar",
            type: "post",
            data: "idasiento_diario=" + idasiento_diario + "&numero_transacciones=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable + "&tipo_transaccion=" + tipo_transaccion + "&monto_moneda_nacional=" + monto_moneda_nacional + "&monto_moneda_extranjera=" + monto_moneda_extranjera,
            success: function () {

            },
            error: function (data) {
                alert(data);
                alert("Error en el proceso de edicion de transacciones");
            }
        }).done(function(){
            var res = confirm("Asiento de Diario Recurrente fue editado con exito\n\¿Desea regresar a la lista de asiento de diario recurrentes?");
                    if (res === false) {
                        return 0;

                    } else if (res === true) {
                        window.location = 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente';

                    }
        });
    });

}

function eliminar_transacciones(idasiento_diario_editado, numero_transacciones_totales_inicio) {

    var idasiento_diario = idasiento_diario_editado;

    var num_editado = 0;
    $(".ad_detalle_editar").each(function () {
        num_editado++;
    });

//    alert("elimindo"+"  "+idasiento_diario+"  "+num_editado+"  "+numero_transacciones_totales_inicio);

    var e;
    while (num_editado < numero_transacciones_totales_inicio) {
        e = num_editado + 1;

        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_detalle_recurrente_eliminar",
            type: "post",
            data: "idasiento_diario=" + idasiento_diario + "&numero_transacciones=" + e,
            success: function () {
            },
            error: function () {
                alert("Error en el proceso eliminacion de transaccion");
            }
        });
        num_editado++;
    }

}

function guardar_transacciones(idasiento_diario_creado) {
    var numero_transacciones_totales = $(".numero_transaccion:last").val();

    $(".asiento_diario_detalle").each(function () {
        var idasiento_diario = idasiento_diario_creado;

        var numero_transacciones = $(this).find(".numero_transaccion").val();
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();

        var debito = $(this).find(".campo_debito").val();
        var credito = $(this).find(".campo_credito").val();

//        var valor_tasa_cambio = $("#tasa_cambio").val();

        var idmoneda = $("#moneda>select").val();

        if (debito === "0.0" && credito !== "0.0") {
            var tipo_transaccion = "c";

            var monto = credito;

        } else if (debito !== "0.0" && credito === "0.0") {
            var tipo_transaccion = "d";

            var monto = debito;

        }

        var valor_dolar = $("#valor_dolar").val();

        if (idmoneda === "1") {
            var monto_moneda_nacional = monto;
            var monto_moneda_extranjera = monto * valor_dolar;

        } else if (idmoneda === "2") {
            var monto_moneda_nacional = monto * valor_dolar;
            var monto_moneda_extranjera = monto;
        }
//        
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_detalle_recurrente_guardar",
            type: "post",
            data: "idasiento_diario=" + idasiento_diario + "&numero_transacciones=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable + "&tipo_transaccion=" + tipo_transaccion + "&monto_moneda_nacional=" + monto_moneda_nacional + "&monto_moneda_extranjera=" + monto_moneda_extranjera,
            success: function () {
                if (numero_transacciones_totales === numero_transacciones) {
//                alert("Transacciones guardadas con exito");
                }
            },
            error: function () {
                alert("Error en el proceso de guradado de transacciones");
            }
        });
    });
}

$(document).ready(function () {
    alert( $('#idasiento_diario_recurrente').val());
    var numero_transacciones_totales_inicio = $(".numero_transaccion_editar:last").val();

    $("#editar").on("click", function () {
        var res = confirm("¿Comfirma que desea editar este asiento?");
        if (res === true) {
            if (editar_asiento_diario(numero_transacciones_totales_inicio)) {
                alert("Asiento editado con exito");
            }

        } else if (res === false) {
            return 0;
        }

    });



});