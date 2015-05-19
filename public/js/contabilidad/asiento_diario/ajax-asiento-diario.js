
$(document).ready(function () {
    //////////////// agregar cuentas de detalles de asiento///////////////


    //////////////// agregar campos de detalles de asiento///////////////
    function scrollWin() {
        $('html,body').animate({
            scrollTop: $("#add-delete").offset().top
        }, 1);
    }

    $("#agregar").on('click', function () {
        scrollWin();

        var id_campo = parseInt($("tbody#campos_agregados>tr:last").attr("id"));

        $('#clone').show();
        var creado = $('#clone').clone();
        $('#clone').hide();

        creado.attr('class', 'agregado').insertAfter('tbody#campos_agregados>tr:last');

        creado.attr('id', id_campo + 1);


        var id_padre = creado.attr("id");

        creado.find('td:nth-child(1)>div').html(parseInt(id_padre) + 1);


        var id_cuenta_defecto = creado.find('#idcuenta_contable_').attr('id');
        var id_cuenta_final = id_cuenta_defecto + id_padre;
        creado.find('td:nth-child(2)>div>input').attr('id', id_cuenta_final).attr('name', id_cuenta_final);

        var id_boton_defecto = 'b_';
        var id_boton_final = id_boton_defecto + id_padre;
        creado.find('td:nth-child(2)>div>span>button').attr('id', id_boton_final).attr('name', id_boton_final);

        var id_descripcion_defecto = creado.find('#descripcion_cuenta_contable_').attr('id');
        var id_descripcion_cuenta_final = id_descripcion_defecto + id_padre;
        creado.find('td:nth-child(3)>input').attr('id', id_descripcion_cuenta_final).attr('name', id_descripcion_cuenta_final);

        var id_debito_defecto = 'balance_debito_';
        var id_debito_final = id_debito_defecto + id_padre;
        creado.find('td:nth-child(4)>input').attr('id', id_debito_final).attr('name', id_debito_final);

        var id_credito_defecto = 'balance_credito_';
        var id_credito_final = id_credito_defecto + id_padre;
        creado.find('td:nth-child(5)>input').attr('id', id_credito_final).attr('name', id_credito_final);
    });

    $("#quitar").on('click', function () {

        $('.agregado:last').remove();

        scrollWin();
    });



    //////////////seleccion de moneda/cambio ///////////////

    $("#tasa_cambio").hide();

    $("#moneda>select").change(function () {

        var elegido = $(this).val();

        if (elegido == 1) {
            $("#tasa_cambio").hide();

        } else if (elegido == 2) {
            $("#tasa_cambio").show();
        }

    });

    //////////////seleccion de cuentas///////////////
    function busqueda(fin) {
        ///talves pasando la var valor_ref 
        var tag = '#idcuenta_contable_' + fin;

        var valor = $(tag).val();

        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_cuentas_buscar",
            type: "post",
            data: "valor=" + valor + "&campo=idcuenta_contable",
            success: function (data) {

                $("#resultado").html(data);
            }
        });
    }

    function asig_valores() {
        $("#resultado").on("click", "input#buscar_c", function () {
            var val = $("#listar").data("id_ref");
            var valor = $(this).attr('name');
            var arreglo = valor.split("/");
            var id = arreglo[0];
            var descripcion = arreglo[1];

            $('#listar').fadeOut('slow');

            var campo_cuenta = "#idcuenta_contable_" + val;
            var campo_descripcion = "#descripcion_cuenta_contable_" + val;

            $(campo_cuenta).val(id);
            $(campo_descripcion).val(descripcion);

        });
    }

    function mostrar() {
        $("#listar").fadeIn("fast");

    }

    $("#campos_agregados").on("click", ".buscar_cuenta", function () {
        var referencia = $(this).attr("id");
        var valor_ref = referencia.charAt(referencia.length - 1);

        mostrar();
        busqueda(valor_ref);

        $("#listar").data("id_ref", valor_ref);
        if (asig_valores()) {
            $("#listar").removeData("id_ref", valor_ref);
        }

    });

    $("#campos_agregados").on("keypress", ".buscar", function () {
        var referencia = $(this).attr("id");
        var valor_ref = referencia.charAt(referencia.length - 1);

        mostrar();
        busqueda(valor_ref);

        $("#listar").data("id_ref", valor_ref);
        if (asig_valores()) {
            $("#listar").removeData("id_ref", valor_ref);
        }

    });

    $("#cerrar_pop").on("click", function () {
        $("#listar").hide();
    });

    /////////////////////////montos de debito y credito///////////////

    function calcular_total() {
        var debito_total = 0;
        $(".campo_debito").each(
                function () {
                    var numero;

                    if (isNaN(eval($(this).val()))) {
                        numero = 0;

                    } else {
                        numero = eval($(this).val());

                    }
                    debito_total = debito_total + numero;

                }
        );

        $("#total_debito").val(debito_total);
    }
    
    function calcular_total2() {
        var debito_total = 0;
        $(".campo_credito").each(
                function () {
                    var numero;

                    if (isNaN(eval($(this).val()))) {
                        numero = 0;

                    } else {
                        numero = eval($(this).val());

                    }
                    debito_total = debito_total + numero;

                }
        );

        $("#total_credito").val(debito_total);
    }


    $("#campos_agregados").on("keyup", ".campo_debito", function () {
        calcular_total();
    });
    
     $("#campos_agregados").on("keyup", ".campo_credito", function () {
        calcular_total2();
    });

    $(document).on("mousemove", function () {

        $(".campo_debito").each(
                function () {
                    if (isNaN(eval($(this).val()))) {
                        $(this).val(0);
                    }
                }
        );

    $(".campo_credito").each(
                    function () {
                        if (isNaN(eval($(this).val()))) {
                            $(this).val(0);
                        }
                    }
            );
    });



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

    $(".campo_debito").validarCampoNumero('0123456789');
    $(".campo_credito").validarCampoNumero('0123456789');
    
    
          
});









