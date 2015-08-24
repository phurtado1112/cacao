function editar_asiento_diario(numero_transacciones_totales_inicio) {

    var descripcion_asiento_diario = $("#descripcion_asiento_diario").val();
    var usuario_edicion = $("#usuario_edicion").val();
    var balance_credito = $("#total_credito").val();
    var balance_debito = $("#total_debito").val();
    var fecha_edicion = $("#fecha_edicion").val();
    var idtasa_cambio = $("#idtasa_cambio").val();
    var fecha_fiscal = $("#fecha_fiscal").val();

    var idasiento_diario = $('#idasiento_diario').val();

    var tasa_cambio = $("#tasa_cambio").val();
    var transacciones = validar_transacciones();

    var numero_transacciones_totales = $(".numero_transaccion_editar:last").val();

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
        alert("Usted tiene transacciones sin cuentas seleccionadas:\n\-Debe seleccionar una cuenta para cada transaccion." +
                "\n\ \n\Usted tiene transaccion sin monto:\n\-Debe establecer los montos con cualquier numero mayor a cero.");

    }
    else if (balance_credito !== balance_debito) {
        alert("Usted debe balancear el asiento para poder guardarlo");

    } else if ($("#valor_dolar").val() === "0") {
        alert("No se a encontrado tipo de cambio extranjero asociado a esta fecha fiscal");

    }
    else if (transacciones[0] === 0 && transacciones[1] === 0) {
        var idmoneda = $("#moneda>select").val();
        var valor_moneda_extranjera = $("#valor_moneda_extranjera").val();

        if (idmoneda === "1") {
            var balance_credito_extranjero = balance_credito / valor_moneda_extranjera;
            var balance_debito_extranjero = balance_debito / valor_moneda_extranjera;

            var balance_credito_nacional = balance_credito;
            var balance_debito_nacional = balance_debito;

        } else if (idmoneda > "1") {
            var balance_credito_extranjero = balance_credito;
            var balance_debito_extranjero = balance_debito;

            var balance_credito_nacional = balance_credito * valor_moneda_extranjera;
            var balance_debito_nacional = balance_debito * valor_moneda_extranjera;

        }
        
        $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_editar',
            type: 'POST',
            data: "idasiento_diario=" + idasiento_diario + "&descripcion_asiento_diario=" + descripcion_asiento_diario +
                    "&idtasa_cambio=" + idtasa_cambio + "&balance_debito_nacional=" + balance_debito_nacional + "&balance_credito_nacional=" + balance_credito_nacional +
                    "&balance_debito_extranjero=" + balance_debito_extranjero + "&balance_credito_extranjero=" + balance_credito_extranjero + "&usuario_edicion=" + usuario_edicion + "&fecha_edicion=" + fecha_edicion +
                    "&fecha_fiscal=" + fecha_fiscal,
            success: function () {

                editar_transacciones(idasiento_diario);
                eliminar_transacciones(idasiento_diario);
                guardar_transacciones(idasiento_diario);

            },
            error: function () {
                alert('Error al actualizar Asiento Diario');
            }

        }).done(function(){
            var res = confirm("Asiento de Diario con el ID "+idasiento_diario+" fue editado con exito\n\¿Desea regresar a la lista de asiento de diario?");
                    if (res === false) {
                        return 0;

                    } else if (res === true) {
                        window.location = 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/index';

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
        var cuenta_contable = $(this).find(".descripcion_cuenta_contable").val();

        if (debito === "" || credito === "") {
            montos_vacios++;
        }
        else if (cuenta_contable === "") {
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

    $(".ad_detalle_editar").each(function () {
        var idasiento_diario = idasiento_diario_editado;

        var numero_transacciones = $(this).find(".numero_transaccion_editar").val();
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();

       var debito = Number($(this).find(".campo_debito").val());
        var credito = Number($(this).find(".campo_credito").val());

        var idmoneda = $("#moneda>select").val();

        if ((debito == 0 && credito != 0) || (debito == 0 && credito != 0)) {
            var tipo_transaccion = "C";

            var monto = Number(credito);

        } else if ((debito != 0 && credito == 0 ) || (debito != 0 && credito == 0 )) {
            var tipo_transaccion = "D";

            var monto = Number(debito);
        }
        var valor_moneda_extranjera = Number($("#valor_moneda_extranjera").val());

        if (idmoneda === "1") {
            var monto_moneda_nacional = monto;
            var monto_moneda_extranjera = monto / valor_moneda_extranjera;

        } else if (idmoneda > "1") {
            var monto_moneda_nacional = monto * valor_moneda_extranjera;
            var monto_moneda_extranjera = monto;
        }
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_detalle_editar",
            type: "post",
            data: "idasiento_diario=" + idasiento_diario + "&numero_transacciones=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable + "&naturaleza_cuenta_contable=" + tipo_transaccion +
                    "&monto_moneda_nacional="+monto_moneda_nacional+"&monto_moneda_extranjera="+monto_moneda_extranjera,
            success: function () {
            },
            error: function () {
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

        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_detalle_eliminar",
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

function guardar_transacciones(idasiento_diario_creado) {

    $(".asiento_diario_detalle").each(function () {
        var idasiento_diario = idasiento_diario_creado;

        var numero_transacciones = $(this).find(".numero_transaccion").val();
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();

        var debito = $(this).find(".campo_debito").val();
        var credito = $(this).find(".campo_credito").val();

        var idmoneda = $("#moneda>select").val();

        if ((debito == 0 ||debito == 0) && credito != 0) {
            var tipo_transaccion = "C";

            var monto = credito;

        } else if (debito != 0 && (credito == 0 || credito == 0)) {
            var tipo_transaccion = "D";

            var monto = debito;

        }

        var valor_moneda_extranjera = $("#valor_moneda_extranjera").val();

        if (idmoneda === "1") {
            var monto_moneda_nacional = monto;
            var monto_moneda_extranjera = monto / valor_moneda_extranjera;

        } else if (paresInt(idmoneda) > 1) {
            var monto_moneda_nacional = monto * valor_moneda_extranjera;
            var monto_moneda_extranjera = monto;
        }
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_detalle_guardar",
            type: "post",
            data: "idasiento_diario=" + idasiento_diario + "&numero_transacciones=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable + "&naturaleza_cuenta_contable=" + tipo_transaccion + "&monto_moneda_nacional=" + monto_moneda_nacional + "&monto_moneda_extranjera=" + monto_moneda_extranjera,
            success: function () {
            },
            error: function () {
                alert("Error en el proceso de guradado de transacciones");
            }
        });
    });
}

$(document).ready(function () {
    var numero_transacciones_totales_inicio = $(".numero_transaccion_editar:last").val();

    $("#editar").on("click", function () {
        var res = confirm("¿Comfirma que desea editar este asiento?");
        if (res === true) {
            if (editar_asiento_diario(numero_transacciones_totales_inicio)) {
                var res = confirm("Asiento de Diario editado con exito\n\¿Desea realizar mas cambios en este Asiento de Diario?");
                    if (res === true) {
                        window.location = 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_modificar/'+numero_transacciones_totales_inicio;

                    } else if (res === false) {
                        window.location = 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/index';

                    }
            }

        } else if (res === false) {
            return 0;
        }

    });



});