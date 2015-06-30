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
//                    
                var num_ad = origen_asiento_diario + str_ceros + (num_sum.toString());

                $("#numero_asiento_diario").val(num_ad);

            }
        },
        error: function () {
            alert("Error al generar el Numero de Asiento");
        }
    });
}

$(document).ready(function () {
/////SELECCION DE ORIGEN
    var valor_origen = $("#valor_origen_ad").val();
    $("select#idorigen_asiento_diario").find("option[value=" + valor_origen + "]").attr("selected", "selected");

    var valor_tasa_cambio_ad = Number($("#valor_tasa_cambio_ad").val());
    var fecha_fiscal = $("#fecha_fiscal").val();
   
    if (valor_tasa_cambio_ad > 1) {
        $("#moneda>select").find("option[value=" + 2 + "]").attr("selected", "selected");
         var idmoneda = parseInt($("#moneda>select").val());

        buscar_tasa_por_fecha(fecha_fiscal, idmoneda, function (arreglo) {
            $("#idtasa_cambio").val(arreglo[1]);
            $("#tasa_cambio").val(arreglo[0]);
            $("#valor_moneda_extranjera").val(arreglo[0]);
        });

    } else if (valor_tasa_cambio_ad === 1) {
        $("#moneda>select").find("option[value=" + 1 + "]").attr("selected", "selected");

        $("#tasa_cambio").val(1);
        $("#idtasa_cambio").val(1);
        buscar_tasa_por_fecha(fecha_fiscal, 2, function (arreglo) {
            $("#valor_moneda_extranjera").val(arreglo[0]);
        });
    }

    $("#fecha_fiscal").datepicker();
    //////////////seleccion de moneda/cambio ///////////////


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