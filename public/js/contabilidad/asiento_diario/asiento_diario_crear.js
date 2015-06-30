$(function () {
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'yy-mm-dd',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);

});

function buscar_tasa_por_fecha(fecha_buscada, idmoneda, uso_valores) {

    $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/buscar_tasa_cambio_por_fecha',
        type: 'POST',
        data: "fecha_buscada=" + fecha_buscada + "&idmoneda=" + idmoneda,
        success: function (data) {
            if (data === 'vacio') {
                $("#tasa_cambio").val("ND");
                $("#valor_moneda_extranjera").val(0);

                var res = confirm("No existe ningun tasa de cambio asociado a esta fecha \n\
                ¿Desea introducir tasa de cambio?");

                if (res === true) {
                    $("#intro_tasa_cambio").fadeIn("fast");

                } else if (res === false) {
                    return 0;
                }
            }
            else {
                var arreglo = data.split('/');
                uso_valores(arreglo);

            }
        },
        error: function () {
            alert("Error al consultar la tasa de cambio");
        }
    });

}

function generar_num_ad() {
    var idorigen_asiento_diario = $("select#idorigen_asiento_diario").val();
    var origen_asiento_diario = $("select#idorigen_asiento_diario").find("option[value=" + idorigen_asiento_diario + "]").text();

    $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_numero',
        type: 'POST',
        data: "origen_asiento_diario=" + origen_asiento_diario,
        success: function (data) {

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
                $("#numero_asiento_diario").val(num_ad);
            }
        },
        error: function () {
            alert("Error al generar el Numero de Asiento");
        }
    });
}
function agregar_tasa_cambio() {
    var idmoneda_tasa = $("select[name=idmoneda_tasa]").val();
    var fecha_tipo_cambio = $("#fecha_nueva_tasa_cambio").val();
    var tasa_cambio = $("#valor_tasa_cambio_nueva").val();

    $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/tasa_cambio_agregar',
        type: 'POST',
        data: "idmoneda_agregar=" + idmoneda_tasa
                + "&fecha_tipo_cambio=" + fecha_tipo_cambio
                + "&tasa_cambio=" + tasa_cambio,
        success: function () {
            alert("Tasa de cambio agregada con exito");
            $("#intro_tasa_cambio").hide();
        },
        error: function () {
            alert('Error al agregar tasa de cambio');
        }

    });

}


$(document).ready(function () {
    ///////////////// NUMERO ASIENTO DIARIO////////////////
    generar_num_ad();

    $("select#idorigen_asiento_diario").on("change", function () {
        generar_num_ad();
    });

    $("#fecha_fiscal").datepicker();

    /////////////// POP-UP NUEVA TASA CAMBIO7777777777777
    $("#valor_tasa_cambio_nueva").validarCampoNumero('.0123456789');
    $("#agregar_tasa_cambio").on("click", agregar_tasa_cambio);

    //////////////seleccion de moneda/cambio ///////////////
    $("#cerrar_pop_tasa_cambio").on("click", function () {
        $("#intro_tasa_cambio").hide();
    });

    $("#moneda>select").change(function () {

        var fecha_fiscal = $("#fecha_fiscal").val();
        var idmoneda = parseInt($(this).val());

        if (idmoneda > 1 && fecha_fiscal !== '') {
            buscar_tasa_por_fecha(fecha_fiscal, idmoneda, function (arreglo) {
                $("#tasa_cambio").val(arreglo[0]);
                $("#idtasa_cambio").val(arreglo[1]);
                $("#valor_moneda_extranjera").val(arreglo[0]);
            });


        } else if ((idmoneda > 1) && fecha_fiscal === '') {
            alert("Usted necesita introducir fecha fiscal");
            $("#tasa_cambio").val("ND");

        } else if (idmoneda === 1 && fecha_fiscal !== '') {
            $("#tasa_cambio").val(1);
            $("#idtasa_cambio").val(1);
            buscar_tasa_por_fecha(fecha_fiscal, 2, function (arreglo) {
                $("#valor_moneda_extranjera").val(arreglo[0]);
            });

        }
    });
/////////////////////////////
    $("#fecha_fiscal").change(function () {
        var idmoneda = parseInt($("#moneda>select").val());
        var fecha_fiscal = $(this).val();

        if (idmoneda > 1) {///si es de id moneda 
            buscar_tasa_por_fecha(fecha_fiscal, idmoneda, function (arreglo) {
                $("#tasa_cambio").val(arreglo[0]);
                $("#idtasa_cambio").val(arreglo[1]);
                $("#valor_moneda_extranjera").val(arreglo[0]);
            });
        } else if (idmoneda === 1) {
            $("#tasa_cambio").val(1);
            $("#idtasa_cambio").val(1);
            buscar_tasa_por_fecha(fecha_fiscal, 2, function (arreglo) {
                $("#valor_moneda_extranjera").val(arreglo[0]);
            });

        }
    });


});