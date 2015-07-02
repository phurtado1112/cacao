var url1 = "http://localhost/cacao/index.php/administracion/usuario/usuario_procesar/index/1";
var url2 = "http://localhost/cacao/index.php/administracion/usuario/usuario_procesar/index/0";
var url_actual = window.location.href;
if (url_actual === url1) {
    var controlador = "usuario_listar";
} else if (url_actual === url2) {
    var controlador = "usuario_listar_inactivos";
}




$(document).on("ready", function () {

    $.ajax({
        url: 'http://localhost/cacao/index.php/administracion/usuario/usuario_procesar/' + controlador,
        type: 'POST',
        success: function (data) {
            $("#resultado").html(data);
        }

    });

    function confirmar(val) {
        var res = confirm("¿Esta seguro que desea desactivar este usuario?");
        if (res === true) {
            window.location.href = "http://localhost/cacao/index.php/administracion/usuario/usuario_procesar/usuario_cambiar_estado/" + val + "/0";
        } else if (res === false) {
            return 0;
        }

    }
    ;

    function busqueda(campo, valor) {

        $.ajax({
            url: "http://localhost/cacao/index.php/administracion/usuario/usuario_procesar/usuario_buscar",
            type: "post",
            data: "valor=" + valor + "&campo=" + campo,
            success: function (data) {
                $("#resultado").html(data);
            }
        });
    }

    function validar_busqueda() {

        var valor = $('#valor').val();
        var campo = $('#campo').val();

        if ((!isNaN(valor) || valor === "") && campo === "idusuario") {
            busqueda(campo, valor);

        } else if ((isNaN(valor) || valor === "") && (campo === "nombre" || campo === "apellido" || campo === "usuario")) {
            busqueda(campo, valor);

        } 

    }
    
    
    $("#buscar").on('click', function () {
        validar_busqueda();
    });

    $("#valor").on('keyup', function () {
       validar_busqueda();
    });
    
    $("#campo").on('change', function () {
       validar_busqueda();
    });

    $("#resultado").on('click', ".inactivar", function () {
        confirmar($(this).attr("value"));
    });



});

