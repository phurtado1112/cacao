var url1 = "http://localhost/cacao/index.php/contabilidad/catalogo/cuentas/cuentas/index/1";
var url2 = "http://localhost/cacao/index.php/contabilidad/catalogo/cuentas/cuentas/index/0";

var url_actual = window.location.href;

if (url_actual === url1) {
    var controlador = "cuentas_listar";
} else if (url_actual === url2) {
    var controlador = "cuentas_listar_inactivas";
}

$(document).on("ready", function () {

    $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/catalogo/cuentas/cuentas/' + controlador,
        type: 'POST',
        success: function (data) {
            $("#resultado").html(data);
        }

    });
    
    var naturaleza_cuenta = $("#naturaleza_cuenta").val();
    $("select[name=naturaleza_cuenta_contable]").find("option[value="+naturaleza_cuenta+"]").attr("selected","selected");
    
     var grupo_cuenta = $("#grupo_cuenta").val();
     $("select[name=idgrupo_cuenta] option").each(function(){
         
          var text_option = $(this).text();
          
         if(text_option === grupo_cuenta){
             $(this).attr("selected","selected");
         }
     });
//   
    
    function busqueda() {

        var valor = $('#valor').val();
        var campo = $('#campo option:selected').val();

        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/catalogo/cuentas/cuentas/cuentas_buscar",
            type: "post",
            data: "valor=" + valor + "&campo=" + campo,
            success: function (data) {

                $("#resultado").html(data);
            }

        });

    }


    function confirmar(val) {
        var res = confirm("¿Esta seguro que desea desactivar esta cuenta?");
        if (res === true) {
            window.location.href = "http://localhost/cacao/index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_cambiar_estado/" + val + "/0";
        } else if (res === false) {
            return 0;
        }

    }

    $("#buscar").on('click', function () {
        busqueda();

    });

    $("#valor").on('keypress', function () {
        busqueda();
    });

    $("#resultado").on('click', ".inactivar", function () {
        confirmar($(this).attr("value"));
    });

    ///////////mascar para agregar////////////////

    $("#idcuenta_contable").mask("9999-99-99");

});