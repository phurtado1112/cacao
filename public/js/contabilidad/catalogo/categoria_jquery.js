
/* global smoke */

function lista_categoria() {
    var url1 = "http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/index/1";
    var url2 = "http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/index/0";

    var url_actual = window.location.href;

    if (url_actual === url1) {
        var controlador = "categorias_listar";
    } else if (url_actual === url2) {
        var controlador = "categorias_listar_inactivas";
    }

    $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/' + controlador,
        type: 'POST',
        success: function (data) {
            $("#resultado").html(data);
        }

    });
}

function busqueda_categoria() {
    var valor = $('#valor').val();
    var campo = $('#campo option:selected').val();
    
    if (isNaN(valor) && valor !== "") {
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/categorias_buscar",
            type: "post",
            data: "valor=" + valor + "&campo=" + campo,
            success: function (data) {

                $("#resultado").html(data);
            }

        });
    }else if(valor === "" ){
        location.reload();
        
    }else {
        smoke.alert("Solo se aceptan caracteres alfaberticos para esta busqueda");
    }

}


function confirmar_inactivar(val) {
    smoke. confirm("¿Esta seguro que desea desactivar esta categoria?",function(res){

    if (res === true) {
        window.location.href = "http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/categoria_cambiar_estado/" + val + "/0";

    } else if (res === false) {
        return 0;
    }
    });

}

function confirmar_eliminar(val) {
    smoke.confirm("¿Esta seguro que desea eliminar esta categoria?", function(res){

    if (res === true) {
        $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/categoria_relacion_grupo',
            type: 'POST',
            data: "idcategoria_cuenta=" + val,
            success: function (data) {
                
                if (data == 0) {
                    window.location.href = "http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/categoria_eliminar/" + val;

                } else if (data > 0) {
                    smoke.alert("No puede eliminar una categoria que esta siendo utilizada");
                }

            },
            error: function () {
                smoke.alert('Error al consultar dependecias');
            }

        });

    } else if (res === false) {
        return 0;
    }
    });

}

function categoria_asignar_valores() {
    var estructura_base = $("#categoria_grupo").val();
    $("select[name=idcategoria_cuenta] option").each(function () {

        var text_option = $(this).text();

        if (text_option === estructura_base) {
            $(this).attr("selected", "selected");
        }
    });

    var estructura_base = $("#estructura_base").val();
    $("select[name=idestructura_base] option").each(function () {

        var text_option = $(this).text();

        if (text_option === estructura_base) {
            $(this).attr("selected", "selected");
        }
    });

}

$(document).on("ready", function () {
    lista_categoria();

    categoria_asignar_valores();

    $("#buscar").on('click', function () {
        busqueda_categoria();
    });
    $("#valor").on('keyup', function () {
        busqueda_categoria();
    });
     $("#campo").on('change', function () {
        if($("#valor").val() !== ""){
        busqueda_categoria();
    }
    });
    $("#resultado").on('click', ".inactivar", function () {
        confirmar_inactivar($(this).attr("value"));
    });

    $("#resultado").on('click', ".eliminar", function () {
        confirmar_eliminar($(this).attr("value"));
    });

});
