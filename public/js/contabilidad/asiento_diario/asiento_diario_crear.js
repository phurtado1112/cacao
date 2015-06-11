$(document).ready(function () {
    
    obtener_cambio_dolar();
    $(function () {
//        estilo del datepicker para dar formato en idioma español
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
        $(function () {
            $("#fecha_fiscal").datepicker();
            $("#fecha_nueva_tasa_cambio").datepicker();
        });
    });
    
    /////////////// POP-UP NUEVA TASA CAMBIO7777777777777
    
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
    
    $("#valor_tasa_cambio_nueva").validarCampoNumero('.0123456789');
    
    
    $("#agregar_tasa_cambio").on("click",function(){
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
        
    });
     
    
    //////////////seleccion de moneda/cambio ///////////////
    
    
     $("#cerrar_pop_tasa_cambio").on("click", function () {
//        $('#cuenta_contable_buscar').val("");
        $("#intro_tasa_cambio").hide();
    });

    $("#moneda>select").change(function () {
        obtener_cambio_dolar();
        var fecha = $("#fecha_fiscal").val();

        var elegido = $(this).val();

        if (elegido === "1" && fecha !== '') {
            buscar_fecha();

        } else if (elegido === "2" && fecha !== '') {
            buscar_fecha();

        } else if ((elegido === "2") && fecha === '') {
            alert("Usted necesita introducir fecha fiscal");
            $("#tasa_cambio").val("ND");
        }
    });

    $("#fecha_fiscal").change(function () {
        var elegido = $("#moneda>select").val();

        obtener_cambio_dolar();

        if (elegido === "2" || elegido === "1") {

            buscar_fecha();
        }
    });


    function buscar_fecha() {

        var fecha_buscada = $("#fecha_fiscal").val();
        var elegido_moneda = $("#moneda>select").val();

        $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/buscar_fecha',
            type: 'POST',
            data: "fecha_buscada=" + fecha_buscada,
            success: function (data) {
                if (data === 'vacio') {
                    alert('No existe ningun tasa de cambio asociado a esta fecha');
                    $("#tasa_cambio").val("ND");

                    function comfirmar() {
                        var res = confirm("¿Desea introducir tasa de cambio?");
                        if (res === true) {
                            $("#intro_tasa_cambio").fadeIn("fast");
                        } else if (res === false) {
                            return 0;
                        }

                    }
                    comfirmar();
                }
                else {

                    if (elegido_moneda === "2") {
                        var arreglo = data.split('/');
                        $("#tasa_cambio").val(arreglo[0]);
                        $("#idtasa_cambio").val(arreglo[1]);

                    } else if (elegido_moneda === "1") {
                        $("#tasa_cambio").val(1);
                        $("#idtasa_cambio").val(1);

                    }



                }
            }
        });
    }

    function obtener_cambio_dolar() {

        var fecha_buscada = $("#fecha_fiscal").val();

        var valor_tasa_cambio_dolar;
        $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/buscar_fecha',
            type: 'POST',
            data: "fecha_buscada=" + fecha_buscada,
            success: function (data) {

                if (data === "vacio") {
                    valor_tasa_cambio_dolar = 0;
                    $("#valor_dolar").val(valor_tasa_cambio_dolar);

                } else {
                    var arreglo = data.split('/');
                    valor_tasa_cambio_dolar = parseInt(arreglo[0]);
                    $("#valor_dolar").val(valor_tasa_cambio_dolar);
                }

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
    ;

    generar_num_ad();

    $("select#idorigen_asiento_diario").on("change", function () {
        generar_num_ad();
    });

});