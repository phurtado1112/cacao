
$(document).ready(function () {
    //////////////// agregar cuentas de detalles de asiento///////////////
    
    //////////////// agregar campos de detalles de asiento///////////////
    function scrollWin() {
    $('.valor').animate({
        scrollTop: $("#contenedor_transacciones").height()+1000}, 1);
}

    $("#agregar").on('click', function () {
        scrollWin();

        var id_campo = parseInt($("tbody#campos_agregados>tr:last").attr("id"));
        
        $('#clone').show();
        var creado = $('#clone').clone();
        $('#clone').hide();

        creado.attr('class', 'asiento_diario_detalle agregado').insertAfter('tbody#campos_agregados>tr:last');
        
        creado.attr('id', id_campo + 1);
        
        var id_padre = creado.attr("id");

        creado.find('td:nth-child(1)>div').html(parseInt(id_padre));
        creado.find('td:nth-child(1)>.numero_transaccion').val(parseInt(id_padre));

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
        creado.find('td:nth-child(4)>input').attr('id', id_debito_final).attr('name', id_debito_final).validarCampoNumero('.0123456789');;

        var id_credito_defecto = 'balance_credito_';
        var id_credito_final = id_credito_defecto + id_padre;
        creado.find('td:nth-child(5)>input').attr('id', id_credito_final).attr('name', id_credito_final).validarCampoNumero('.0123456789');;
    });

    $("#campos_agregados").on('click',".quitar", function () {
        
        if( $("tr.asiento_diario_detalle:last").attr("id")>2){
            $(this).parents("tr.agregado").remove();
        }else{
            alert("Necesita almenos 2 transacciones para guardar el asiento");
        }
        
        var i=1;
        $("tr.agregado").each(function(){
            $(this).attr("id",i);
            $(this).find('td:nth-child(1)>div').html(i);
            $(this).find('td:nth-child(1)>.numero_transaccion').val(i);
            
            $(this).find(".idcuenta_contable").attr("id","idcuenta_contable_"+i).attr("name","idcuenta_contable_"+i);
            $(this).find('td:nth-child(2)>div>span>button').attr('id', "b_"+i).attr('name', "b_"+i);
            
            $(this).find('td:nth-child(3)>input').attr('id',"descripcion_cuenta_contable_"+i).attr('name', "descripcion_cuenta_contable_"+i);
            
            $(this).find('td:nth-child(4)>input').attr('id', "balance_debito_"+i).attr('name', "balance_debito_"+i);
            
            $(this).find('td:nth-child(5)>input').attr('id', "balance_credito_"+i).attr('name', "balance_credito_"+i);
            
            i++;
        });
        
        scrollWin();
        calcular_total();
        calcular_total2();
    });

/////validacion que solo debito o solo credito
    
    $("#campos_agregados").on('keyup', ".campo_debito",function () {
        
        var  id_original=$(this).attr("id");
        var idcampo = parseInt(id_original.substr(id_original.length-1,id_original.length));
        
        var campo = '#balance_credito_'+idcampo;
        var campo_vecino = '#balance_debito_'+idcampo;
        
        $(campo).val("0.0");
        calcular_total2();

    });
    
    $("#campos_agregados").on('keyup', ".campo_credito",function () {
        
        var  id_original=$(this).attr("id");
        var idcampo = parseInt(id_original.substr(id_original.length-1,id_original.length));
        
        var campo = '#balance_debito_'+idcampo;
        var campo_vecino = '#balance_credito_'+idcampo;
        
        $(campo).val("0.0");
        calcular_total();

    });

    //////////////seleccion de cuentas///////////////
    function busqueda_cuenta() {
        
        var tag = '#cuenta_contable_buscar';

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
    
    $('#buscar_cuenta').on("click",function(){
        busqueda_cuenta();
         
    });
    
     $('#cuenta_contable_buscar').on("keypress",function(){
        busqueda_cuenta();
         
    });

    function asig_valores() {
        $("#resultado").on("click", "tr#buscar_c", function () {
            
            var val = $("body").data("id_ref");
            var valor = $(this).attr('name');
            var arreglo = valor.split("/");
            var id = arreglo[0];
            var descripcion = arreglo[1];
            
            $('#cuenta_contable_buscar').val("");

            $('#listar').fadeOut('slow');

            var campo_cuenta = "#idcuenta_contable_" + val;
            var campo_descripcion = "#descripcion_cuenta_contable_" + val;

            $(campo_cuenta).val(id);
            $(campo_descripcion).val(descripcion);
            
        });
    }

    function mostrar() {
        $("#listar").fadeIn("fast");
        
        busqueda_cuenta();

    }

    $("#campos_agregados").on("click", ".buscar_cuenta", function () {
        var referencia = $(this).attr("id");
        var valor_ref = referencia.charAt(referencia.length - 1);
        
        mostrar();
        
        $("body").data("id_ref", valor_ref);
        
        asig_valores();
        
    });
    

    $("#cerrar_pop").on("click", function () {
        $('#cuenta_contable_buscar').val("");
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

    $(".campo_debito").validarCampoNumero('.0123456789');
    $(".campo_credito").validarCampoNumero('.0123456789');
    //////busqueda de pop-up/////////////
     $("#cuenta_contable_buscar").validarCampoNumero('-0123456789');
     
     
          
});









