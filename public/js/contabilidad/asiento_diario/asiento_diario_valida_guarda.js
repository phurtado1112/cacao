/* global smoke */

function generar_num_ad() {
    var idorigen_asiento_diario = $("select#idorigen_asiento_diario").val();
    var origen_asiento_diario = $("select#idorigen_asiento_diario").find("option[value=" + idorigen_asiento_diario + "]").text();

    $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_numero',
        type: 'POST',
        data: "origen_asiento_diario=" + origen_asiento_diario,
        error: function () {
            smoke.alert("Error al generar el Numero de Asiento");
        }
    }).done(function(data){
             if (data === "") {
                var numero_ad = origen_asiento_diario + "00000001";
                $("#numero_asiento_diario").val(numero_ad);

            } else if (data !== "") {
                var numero_ad = parseInt(data.substr(2, 10));
                var num_sum = numero_ad + 1;
                var cant_ceros = 8 - (num_sum.toString().length);
                var i = 0;
                var str_ceros = "";

                while (i < cant_ceros) {
                    var cero = "0";
                    str_ceros = str_ceros + cero;

                    i++;
                }
                var num_ad = origen_asiento_diario + str_ceros + (num_sum.toString());

                guardar_asiento_diario(num_ad);
            }
        });
}
function guardar_asiento_diario(num_ad) {
    var idorigen_asiento_diario = $("select#idorigen_asiento_diario").val();
    var descripcion_asiento_diario = $("#descripcion_asiento_diario").val();
    var usuario_creacion = $("#usuario_creacion").val();
    var balance_credito = $("#total_credito").val();
    var balance_debito = $("#total_debito").val();
    var fecha_creacion = $("#recoge_fecha").val();
    var idtasa_cambio = $("#idtasa_cambio").val();
    var fecha_fiscal = $("#fecha_fiscal").val();

    var tasa_cambio = $("#tasa_cambio").val();
    var transacciones = validar_transacciones();
    var origen_asiento_diario = $("select#idorigen_asiento_diario").find("option[value=" + idorigen_asiento_diario + "]").text();

    if (descripcion_asiento_diario == null || descripcion_asiento_diario.length == 0) {
        smoke.alert('Es necesario el campo de descripcion');
    }
    else if (fecha_creacion == null || fecha_creacion.length == 0) {
        smoke.alert('Es necesario el campo de Fecha Creacion');
    }
    else if (fecha_fiscal == null || fecha_fiscal.length == 0) {
        smoke.alert('Es necesario el campo de Fecha Fiscal');

    }
    else if (tasa_cambio === "ND" || tasa_cambio.length == 0) {
        smoke.alert('El tipo de cambio no es valido');
        comfirmar_tasa();

    }
    else if (transacciones[0] > 0 && transacciones[1] === 0) {
        smoke.alert("Usted tiene " + transacciones[0] + " transaccion sin monto:\n\-Debe establecer los montos con cualquier numero mayor a cero.");

    }
    else if (transacciones[1] > 0 && transacciones[0] === 0) {
        smoke.alert("Usted tiene " + transacciones[1] + " transacciones sin cuentas seleccionadas:\n\-Debe seleccionar una cuenta para cada transaccion.");

    }
    else if (transacciones[1] > 0 && transacciones[0] > 0) {
        smoke.alert("Usted tiene transacciones sin cuentas seleccionadas:\n\-Debe seleccionar una cuenta para cada transaccion." +
                "\n\ \n\Usted tiene transaccion sin monto:\n\-Debe establecer los montos con cualquier numero mayor a cero.");

    }
    else if (balance_credito !== balance_debito) {
        smoke.alert("Usted debe balancear el asiento para poder guardarlo");

    } else if ($("#valor_moneda_extranjera").val() === "") {
        smoke.alert("No se a encontrado tipo de cambio extranjero asociado a esta fecha fiscal");
        comfirmar_tasa();

    } else if (transacciones[0] === 0 && transacciones[1] === 0) {
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
            url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_guardar',
            type: 'POST',
            data: "idasiento_diario=" + num_ad + "&idorigen_asiento_diario=" + idorigen_asiento_diario + "&descripcion_asiento_diario=" + descripcion_asiento_diario +
                    "&idtasa_cambio=" + idtasa_cambio + "&balance_debito_nacional=" + balance_credito_nacional + "&balance_credito_nacional=" + balance_debito_nacional + "&usuario_creacion=" + usuario_creacion + "&fecha_creacion=" + fecha_creacion +
                    "&fecha_fiscal=" + fecha_fiscal + "&origen_asiento_diario=" + origen_asiento_diario + "&balance_debito_extranjero=" + balance_credito_extranjero + "&balance_credito_extranjero=" + balance_debito_extranjero,
            success: function (data) {
                guardar_transacciones(data);

            },
            error: function () {
                smoke.alert('Error al crear Asiento Diario');
            }
        });
    }
    
}

function validar_transacciones() {
    var montos_vacios = 0;
    var idcuenta_contable_not = 0;

    $(".asiento_diario_detalle").each(function () {

        var debito = $(this).find(".campo_debito").val();
        var credito = $(this).find(".campo_credito").val();
        var cuenta_contable = $(this).find(".descripcion_cuenta_contable").val();


        if (debito === "" || credito === "") {
            montos_vacios++;
        }
        else if (cuenta_contable === "") {
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

        if ((debito === "0.0" || debito === "0") && credito !== "0.0") {
            var tipo_transaccion = "C";

            var monto = credito;

        } else if (debito !== "0.0" && (credito === "0.0" || credito === "0")) {
            var tipo_transaccion = "D";

            var monto = debito;

        }

        var valor_moneda_extranjera = $("#valor_moneda_extranjera").val();

        if (idmoneda === "1") {
            var monto_moneda_nacional = monto;
            var monto_moneda_extranjera = monto / valor_moneda_extranjera;

        } else if (idmoneda > "1") {
            var monto_moneda_nacional = monto * valor_moneda_extranjera;
            var monto_moneda_extranjera = monto;
        }
        
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_detalle_guardar",
            type: "post",
            data: "idasiento_diario=" + idasiento_diario + "&numero_transacciones=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable +
                    "&naturaleza_cuenta_contable=" + tipo_transaccion + "&monto_moneda_nacional=" + monto_moneda_nacional + "&monto_moneda_extranjera=" + monto_moneda_extranjera,
            success: function () {
                if (numero_transacciones_totales === numero_transacciones) {
                    smoke.confirm("Asiento de Diario con el ID "+idasiento_diario+" fue creado con exito\n\¿Desea crear otro Asiento de Diario?",function(e){
                      if (e) {
                        window.location = 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_crear';

                    } else {
                        window.location = 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/index';

                    }
                        
                    });
                    
                }
            },
            error: function () {
                smoke.alert("Error en el proceso de guradado de transacciones");
            }
        });
    });
}

function comfirmar_tasa() {
    smoke.confirm("¿Desea introducir tasa de cambio?",function(e){
        if (e) {
        $("#intro_tasa_cambio").fadeIn("fast");
    } else {
        return 0;
    }
    });
    
}

$(document).on("ready",function (){
    $("#guardar").on("click", function () {
        generar_num_ad();
    });

});