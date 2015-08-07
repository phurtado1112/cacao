
function editar_asiento_diario(numero_transacciones_totales_inicio) {
    var id_ad_recurrente =  $('#idasiento_diario_recurrente').val();
    var idorigen_asiento_diario = $("select#idorigen_asiento_diario").val();
    var descripcion_asiento_diario = $("#descripcion_asiento_diario").val();
    var usuario_edicion = $("#usuario_edicion_nuevo").val();
    var balance_credito = $("#total_credito").val();
    var balance_debito = $("#total_debito").val();
    var fecha_edicion = $("#fecha_edicion_nueva").val();
    var idmoneda = $("#idmoneda").val();


    var tasa_cambio = $("#tasa_cambio").val();
    var transacciones = validar_transacciones();

    var numero_transacciones_totales = $(".numero_transaccion_editar:last").val();

alert(id_ad_recurrente+"--"+idorigen_asiento_diario+"--"+descripcion_asiento_diario+"--"+usuario_edicion+"--"+balance_credito+"--"+balance_debito+"--"+fecha_edicion+"--"+idmoneda);
    if (descripcion_asiento_diario === null || descripcion_asiento_diario.length === 0) {
        alert('Es necesario el campo de descripcion');
    }
    else if (fecha_edicion === null || fecha_edicion.length === 0) {
        alert('Es necesario el campo de Fecha Creacion');
    }
    else if (transacciones[0] > 0 && transacciones[1] === 0) {
        alert("Usted tiene " + transacciones[0]/2 + " transaccion sin monto:\n\-Debe establecer los montos con cualquier numero mayor a cero.");

    }
    else if (transacciones[1] > 0 && transacciones[0] === 0) {
        alert("Usted tiene " + transacciones[1] + " transacciones sin cuentas seleccionadas:\n\-Debe seleccionar una cuenta para cada transaccion.");

    }
    else if (transacciones[1] > 0 && transacciones[0] > 0) {
        alert("Usted tiene transacciones sin cuentas seleccionadas:\n\-Debe seleccionar una cuenta para cada transaccion." +
                "\n\ \n\Usted tiene transaccion sin monto:\n\-Debe establecer los montos con cualquier numero mayor a cero.");

    }
    else if (balance_credito !== balance_debito) {
        alert("Usted debe balancear el asiento para poder guardarlo");

    } else if (transacciones[0] === 0 && transacciones[1] === 0) {
        
        $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_recurrente_editar',
            type: 'POST',
            data:  "&descripcion_asiento_diario=" + descripcion_asiento_diario +
                    "&idmoneda=" + idmoneda + "&balance_debito=" + balance_debito + "&balance_credito=" + balance_credito + "&usuario_edicion=" + usuario_edicion +
                    "&fecha_edicion=" + fecha_edicion +"&origen_asiento_diario="+idorigen_asiento_diario+"&id_ad_recurrente="+id_ad_recurrente,
            success: function () {
                editar_transacciones(id_ad_recurrente);
                eliminar_transacciones(id_ad_recurrente);
                guardar_transacciones(id_ad_recurrente);
////                
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
        if (debito === "0" && credito === "0" || debito === "0.0" && credito === "0.0") {
            montos_vacios++;
        }

    });

    var campos_vacios = [montos_vacios, idcuenta_contable_not];
    return campos_vacios;
}

function editar_transacciones(idasiento_diario_editado) {
    
    $(".ad_detalle_editar").each(function () {

        var numero_transacciones = $(this).find(".numero_transaccion_editar").val();
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();

        var debito = $(this).find(".campo_debito").val();
        var credito = $(this).find(".campo_credito").val();

        if ((debito === "0" && credito !== "0") || (debito === "0.0" && credito !== "0.0")) {
            var naturaleza_cuenta_contable = "C";

            var monto = Number(credito);

        } else if ((debito !== "0" && credito === "0") || (debito !== "0.0" && credito === "0.0")) {
            var naturaleza_cuenta_contable = "D";

            var monto = Number(debito);
        }
        
//        alert("&numero_asiento_diario_recurrente=" + idasiento_diario_editado +"&numero_transacciones=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable + "&naturaleza_cuenta_contable=" + naturaleza_cuenta_contable + "&monto_transaccion="+monto);
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_detalle_recurrente_editar",
            type: "post",
            data: "&idasiento_diario_recurrente=" + idasiento_diario_editado +"&numero_transaccion=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable + "&naturaleza_cuenta_contable=" + naturaleza_cuenta_contable + "&monto_transaccion="+monto,
            success: function () {
            },
            error: function (data) {
                alert(data);
                alert("Error en el proceso de edicion de transacciones");
            }
        });
    });

}

function eliminar_transacciones(idasiento_diario_editado) {

    var idasiento_diario = idasiento_diario_editado;

    var i = 0;
    var array_eliminar = $("body").data("reg_trans_eliminadas");
    var len = array_eliminar.length;

     for (len; i < len; i++) {
//         alert("idasiento_diario=" + idasiento_diario + "&numero_transacciones=" + array_eliminar[i]);

        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_detalle_recurrente_eliminar",
            type: "post",
            data: "idasiento_diario=" + idasiento_diario + "&numero_transacciones=" + array_eliminar[i],
            success: function () {
            },
            error: function () {
                alert("Error en el proceso eliminacion de transaccion");
            }
        });
    }

}


function guardar_transacciones(idasiento_diario_editado) {
    var numero_transacciones_totales = $(".numero_transaccion:last").val();

    $(".asiento_diario_detalle").each(function () {
        var idasiento_diario = idasiento_diario_editado;

        var numero_transacciones = $(this).find(".numero_transaccion").val();
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();

        var debito = $(this).find(".campo_debito").val();
        var credito = $(this).find(".campo_credito").val();

        if ((debito === "0.0" || debito === "0") && credito !== "0.0") {
            var tipo_transaccion = "C";

            var monto = credito;

        } else if (debito !== "0.0" && (credito === "0.0" || credito === "0")) {
            var tipo_transaccion = "D";

            var monto = debito;

        }
//        alert("idasiento_diario=" + idasiento_diario + "&numero_transaccion=" + numero_transacciones + "&idcuenta_contable=" 
//                + idcuenta_contable + "&naturaleza_cuenta_contable=" + tipo_transaccion + "&monto_transaccion="+monto);
//        
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario_recurrente/asiento_diario_recurrente/ad_detalle_recurrente_guardar",
            type: "post",
            data: "idasiento_diario=" + idasiento_diario + "&numero_transaccion=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable
                    + "&naturaleza_cuenta_contable=" + tipo_transaccion + "&monto_transaccion=" + monto,
            
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
    var numero_transacciones_totales_inicio = $(".numero_transaccion_editar:last").val();

    $("#editar").click(function () {
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