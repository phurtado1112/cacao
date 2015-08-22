/* global smoke */

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
            smoke.alert("Error al consultar la tasa de cambio");
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
            smoke.alert("Tasa de cambio agregada con exito");
            $("#intro_tasa_cambio input").val("");
            $("#intro_tasa_cambio").hide();
            
        },
        error: function () {
            smoke.alert('Error al agregar tasa de cambio');
        }

    }).done(function () {
        var idmoneda = parseInt($("#moneda>select").val());
        var fecha_fiscal = $("#fecha_fiscal").val();

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

}

$(document).ready(function () {
    $("#fecha_fiscal").datepicker();
    $("#fecha_nueva_tasa_cambio").datepicker();
    
    $("#cerrar_pop_tasa_cambio").on("click", function () {
        $("#intro_tasa_cambio input").val("");
        $("#intro_tasa_cambio").hide();
    });
    
     $("#agregar_tasa_cambio").on("click", agregar_tasa_cambio);
/////SELECCION DE ORIGEN
//    var valor_origen = $("#valor_origen_ad").val();
//    $("select#idorigen_asiento_diario").find("option[value=" + valor_origen + "]").attr("selected", "selected");

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
            smoke.alert("Usted necesita introducir fecha fiscal");
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