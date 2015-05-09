var url1 = "http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/index/1";
var url2 = "http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/index/0";

var url_actual = window.location.href;

if (url_actual === url1) {
    var controlador = "categorias_listar";
} else if (url_actual === url2) {
    var controlador = "categorias_listar_inactivas";
}

$(document).on("ready", function () {

    $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/' + controlador,
        type: 'POST',
        success: function (data) {
            $("#resultado").html(data);
        }

    });


    function busqueda() {
        var valor = $('#valor').val();
        var campo = $('#campo option:selected').val();
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/categorias_buscar",
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
            window.location.href = "http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/categoria_cambiar_estado/" + val + "/0";
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


});
