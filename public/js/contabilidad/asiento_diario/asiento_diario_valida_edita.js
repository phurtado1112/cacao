function editar_asiento_diario() {

    var idorigen_asiento_diario = $("select#idorigen_asiento_diario").val();
    var descripcion_asiento_diario = $("#descripcion_asiento_diario").val();
    var numero_asiento_diario = $("#numero_asiento_diario").val();
    var usuario_edicion = $("#usuario_edicion").val();
    var balance_credito = $("#total_credito").val();
    var balance_debito = $("#total_debito").val();
    var fecha_edicion = $("#fecha_edicion").val();
    var idtasa_cambio = $("#idtasa_cambio").val();
    var fecha_fiscal = $("#fecha_fiscal").val();

    var idasiento_diario = $('#idasiento_diario').val();

    var tasa_cambio = $("#tasa_cambio").val();
    var transacciones = validar_transacciones();
    var origen_asiento_diario = $("select#idorigen_asiento_diario").find("option[value=" + idorigen_asiento_diario + "]").text();


//    alert(idorigen_asiento_diario+" "+descripcion_asiento_diario+" "
//            +numero_asiento_diario+" "+usuario_edicion+" "+balance_credito+" "+balance_debito+" "+fecha_edicion
//            +" "+idtasa_cambio+" "+fecha_fiscal);


    if (descripcion_asiento_diario == null || descripcion_asiento_diario.length == 0) {
        alert('Es necesario el campo de descripcion');
    }
    else if (fecha_edicion == null || fecha_edicion.length == 0) {
        alert('Es necesario el campo de Fecha Creacion');
    }
    else if (fecha_fiscal == null || fecha_fiscal.length == 0) {
        alert('Es necesario el campo de Fecha Fiscal');

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
            url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_editar',
            type: 'POST',
            data: "idorigen_asiento_diario=" + idorigen_asiento_diario + "&numero_asiento_diario=" + numero_asiento_diario + "&descripcion_asiento_diario=" + descripcion_asiento_diario +
                    "&idtasa_cambio=" + idtasa_cambio + "&balance_debito=" + balance_debito + "&balance_credito=" + balance_credito + "&usuario_edicion=" + usuario_edicion + "&fecha_edicion=" + fecha_edicion +
                    "&fecha_fiscal=" + fecha_fiscal, //+"&origen_asiento_diario="+origen_asiento_diario,
            success: function () {
                editar_transacciones(idasiento_diario);
//                editar_transacciones(idasiento_diario);
//                guardar_transacciones(idasiento_diario);
                alert();
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
    var campos_vacios = [montos_vacios, idcuenta_contable_not];
    return campos_vacios;
}

function editar_transacciones(idasiento_diario_editado) {
    var numero_transacciones_totales = $(".numero_transaccion_editar:last").val();

    $(".ad_detalle_editar").each(function () {
        ///adapatra lo que sigue
        var idasiento_diario = idasiento_diario_editado;
        var idasiento_diario_detalle = $(this).find("input#idasiento_diario_detalle").val();

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
            var monto_moneda_extranjera = monto * valor_dolar;

        } else if (idmoneda === "2") {
            var monto_moneda_nacional = monto * valor_dolar;
            var monto_moneda_extranjera = monto;
        }

        //alert("idasiento_diario_detalle=" + idasiento_diario_detalle + "&numero_transacciones=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable + "&tipo_transaccion=" + tipo_transaccion + "&monto_moneda_nacional=" + monto_moneda_nacional + "&monto_moneda_extranjera=" + monto_moneda_extranjera);

        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_detalle_modificar",
            type: "post",
            data: "idasiento_diario_detalle=" + idasiento_diario_detalle + "&numero_transacciones=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable + "&tipo_transaccion=" + tipo_transaccion + "&monto_moneda_nacional=" + monto_moneda_nacional + "&monto_moneda_extranjera=" + monto_moneda_extranjera,
            success: function (data) {
                alert(data);
                if (numero_transacciones_totales === numero_transacciones) {

                    //location.reload(true);
                }
            },
            error: function (data) {
                alert(data);
                alert("Error en el proceso de edicion de transacciones");
            }
        });
    });
}

function eliminar_transacciones(idasiento_diario_creado) {
    var numero_transacciones_totales = $(".numero_transaccion:last").val();

            var idasiento_diario = idasiento_diario_creado;

            var numero_transacciones = $(".asiento_diario_detalle:last").find(".numero_transaccion").val();
//        
            $.ajax({
                url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_detalle_guardar",
                type: "post",
                data: "idasiento_diario=" + idasiento_diario + "&numero_transacciones=" + numero_transacciones,
                success: function () {
                    if (numero_transacciones_totales === numero_transacciones) {
                        alert("detalle eliminado de transaccion");
                    }
                },
                error: function () {
                    alert("Error en el proceso eliminacion de transaccion");
                }
            });
}

////function guardar_transacciones(idasiento_diario_creado) {
////        var numero_transacciones_totales = $(".numero_transaccion:last").val();
////
////    $(".asiento_diario_detalle").each(function () {
////        var idasiento_diario = idasiento_diario_creado;
////
////        var numero_transacciones = $(this).find(".numero_transaccion").val();
////        var idcuenta_contable = $(this).find(".idcuenta_contable").val();
////
////        var debito = $(this).find(".campo_debito").val();
////        var credito = $(this).find(".campo_credito").val();
////
////        var valor_tasa_cambio = $("#tasa_cambio").val();
////
////        if (debito === "0.0" && credito !== "0.0") {
////            var tipo_transaccion = "c";
////
////            var monto_moneda_nacional = credito;
////            var monto_moneda_extranjera = credito * valor_tasa_cambio;
////
////        } else if (debito !== "0.0" && credito === "0.0") {
////            var tipo_transaccion = "d";
////
////            var monto_moneda_nacional = debito;
////            var monto_moneda_extranjera = debito * valor_tasa_cambio;
////
////        }
//////        
////        $.ajax({
////            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_detalle_guardar",
////            type: "post",
////            data: "idasiento_diario=" + idasiento_diario + "&numero_transacciones=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable + "&tipo_transaccion=" + tipo_transaccion + "&monto_moneda_nacional=" + monto_moneda_nacional + "&monto_moneda_extranjera=" + monto_moneda_extranjera,
////            success: function () {
////                if(numero_transacciones_totales === numero_transacciones){
////                alert("Asiento de Diario creado con exito");
////                location.reload(true);
////            }
////            },
////            error: function () {
////                alert("Error en el proceso de guradado de transacciones");
////            }
////        });
////    });
//}



$(document).ready(function () {

    $("#editar").on("click", function () {
        editar_asiento_diario();

    });



});