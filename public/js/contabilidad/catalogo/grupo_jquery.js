var url1 = "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/index/1";
var url2 = "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/index/0";

var url_actual = window.location.href;

if (url_actual === url1) {
    var controlador = "grupos_listar";
} else if (url_actual === url2) {
    var controlador = "grupos_listar_inactivas";
}

$(document).ready(function () {
    
   $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/'+controlador,
        type: 'POST',
        success: function (data) {
            $("#resultado").html(data);
        }

    });

    function busqueda() {
        var valor = $('#valor').val();
        var campo = $('#campo option:selected').val();

        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/grupos_buscar",
            type: "post",
            data: "valor=" + valor + "&campo=" + campo,
            success: function (data) {

                $("#resultado").html(data);
            }

        });
    }
    
     function confirmar(val) {
        var res = confirm("¿Esta seguro que desea desactivar esta categoria?");
        if (res === true) {
            window.location.href = "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/grupo_cambiar_estado/" + val + "/0";
        } else if (res === false) {
            return 0;
        }

    }

    $("#buscar , #recargar").on('click', function () {
        busqueda();
    });

    $("#valor").on('keypress', function () {
        busqueda();
    });
    
    $("#resultado").on('click', ".inactivar", function () {
        confirmar($(this).attr("value"));
    });

});
