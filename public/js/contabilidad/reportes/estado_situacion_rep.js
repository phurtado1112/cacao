
/* global smoke */


function generar_pdf() {
    var moneda = $("#moneda").val();
    var periodo = $("#periodo").val();
    var anio = $("#anio").val();
    var usuario = $("#usuario").val();

    if (periodo != "" && anio != "" && usuario != "") {
        window.location.href = "http://localhost/cacao/index.php/contabilidad/reportes/estado_situacion/generar_pdf/" + periodo + "/" + anio + "/" + usuario + "/" + moneda;

    } else if (periodo == "" || anio == "" || usuario == "") {
        alert("No se puede generar reporte por falta de datos \n\Porfabor ingrese los datos faltantes");
    } else {
        alert("No se puede generar reporte");
    }
}

function generar_excell() {
    var moneda = $("#moneda").val();
    var periodo = $("#periodo").val();
    var anio = $("#anio").val();
    var usuario = $("#usuario").val();

    if (periodo != "" && anio != "" && usuario != "") {
        window.location.href = "http://localhost/cacao/index.php/contabilidad/reportes/estado_situacion/generar_excel/" + periodo + "/" + anio + "/" + usuario +"/"+ moneda;

    } else if (periodo == "" || anio == "" || usuario == "") {
        alert("No se puede generar reporte por falta de datos \n\Porfabor ingrese los datos faltantes");
    } else {
        alert("No se puede generar reporte");
    }
}


function mostrar_balance_general(array) {
    var moneda = $("#moneda").val();
    var periodo = $("#periodo").val();
    var anio = $("#anio").val();
    var usuario = $("#usuario").val();
   

    if (periodo != "" && anio != "" && usuario != "") {
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/reportes/estado_situacion/mostrar_reporte",
            type: 'POST',
            data: "periodo=" + periodo + "&anio=" + anio + "&usuario=" + usuario + "&moneda=" + moneda +"&simbolo=" + array[0] +"&cambio=" + array[1],
            success: function (data) {
                $("#resultado").html(data);
            }

        });

    } else if (periodo == "" || anio == "" || usuario == "") {
        alert("No se puede generar reporte por falta de datos \n\Porfabor ingrese los datos faltantes");
    } else {
        alert("No se puede generar reporte");
    }
}


function buscar_tasa_por_fecha() {
    var moneda = $("#moneda").val();
    var fecha_tipo_cambio = $("#fecha").val();

    $.ajax({
        url: "http://localhost/cacao/index.php/contabilidad/reportes/estado_situacion/consulta_datos_moneda",
        type: 'POST',
        data: "idmoneda=" + moneda + "&fecha_tipo_cambio=" + fecha_tipo_cambio,
        success: function (data) {
            if (data === 'vacio') {
                $("#fecha_nueva_tasa_cambio").val(fecha_tipo_cambio).attr("disabled", "disabled");
                $("#moneda  option").each(function () {
                    var val_option = $(this).val();

                    if (val_option === "1") {
                        $(this).attr("selected", "selected");
                    }
                });

                smoke.confirm("No existe ningun tasa de cambio asociado a la fecha actual \n\
                Si desea obtener reporte en la monedas extranjera seleccionada debera introducir la tasa de cambio \n\
                ¿Desea introducir tasa de cambio?", function (e) {
                    if (e) {
                        $("#intro_tasa_cambio").fadeIn("fast");


                    } else {
                        return 0;
                    }
                    
                });
            }
            else {
                mostrar_balance_general(data.split("/")) ;
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
            mostrar_balance_general() ;

        },
        error: function () {
            smoke.alert('Error al agregar tasa de cambio');
        }

    });

}

(function (a) {
    a.fn.validarCampoNumero = function (b) {
        a(this).on({keypress: function (a) {
                var c = a.which, d = a.keyCode, e = String.fromCharCode(c).toLowerCase(), f = b;
                (-1 != f.indexOf(e) || 9 == d || 37 != c && 37 == d || 39 == d && 39 != c || 8 == d || 46 == d && 46 != c) && 161 != c || a.preventDefault()
            }
        }
        );
    };
})(jQuery);


$(document).on("ready", function () {

    $("#cerrar_pop_tasa_cambio").on("click", function () {
        $("#intro_tasa_cambio input").val("");
        $("#intro_tasa_cambio").hide();
    });

    $("#valor_tasa_cambio_nueva").validarCampoNumero('.0123456789');
    $("#agregar_tasa_cambio").on("click", agregar_tasa_cambio);


    var arr=["$C","1"];
    mostrar_balance_general(arr);

    $("#anio").on('keyup', function () {
         if ( $("#moneda").val() !== "1") {
            buscar_tasa_por_fecha();
        }else{
            mostrar_balance_general(arr);
        }
    });
//
    $("#periodo").on('change', function () {
         if ( $("#moneda").val() !== "1") {
            buscar_tasa_por_fecha();
        }else{
            mostrar_balance_general(arr);
        }
    });

    $("#moneda").on('change', function () {
        if ($(this).val() !== "1") {
            buscar_tasa_por_fecha();
        }else{
            mostrar_balance_general(arr);
        }
    });

    $("#boton_pdf").on('click', function () {
        generar_pdf();
    });
    
    $("#boton_excell").on('click', function () {
        generar_excell();
    });

});

