
$(document).ready(function () {
 //////////////// agregar cuentas de detalles de asiento///////////////
     function busqueda() {

        var valor = $('#idcuenta_contable1').val();
        
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_cuentas_buscar",
            type: "post",
            data: "valor=" + valor + "&campo=idcuenta_contable",
            success: function (data) {

                $("#resultado").html(data);
            }

        });

    }

    //////////////// agregar campos de detalles de asiento///////////////
    function scrollWin() {
        $('html,body').animate({
            scrollTop: $("#add-delete").offset().top
        }, 1);
    }

    $("#agregar").on('click', function () {
        
        scrollWin();

        $('#clone').show();
        $('#clone').clone().attr('id', 'agregado').insertAfter('tbody>tr:last');
        $('#clone').hide();

    });

    $("#quitar").on('click', function () {

        $('#agregado:last').remove();

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
    function mostrar() {
        $("#listar").fadeIn("fast");
    }

    $("#resultado").on("click","input#buscar_c",function () {
        var valor = $(this).attr('name');
        var arreglo = valor.split("/");
        var id = arreglo[0];
        var descripcion = arreglo[1];
        $('#listar').fadeOut('slow');
        $(".buscar").val(id);
        $(".descripcion").val(descripcion);

        var b = a.parents("tr").attr("id");
    });

    $("#campos_agregados").on("click", ".buscar_cuenta", function () {
        mostrar();
        busqueda();
    });
    
    $("#campos_agregados").on("keypress", ".buscar", function () {
        mostrar();
        busqueda();
    });
    
    
    $("#cerrar_pop").on("click", function(){
       $("#listar").hide();
    });
});









