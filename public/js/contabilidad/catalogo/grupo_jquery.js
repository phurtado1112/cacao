function lista_grupo(url1, url2, url_actual) {

    if (url_actual === url1) {
        var controlador = "grupos_listar";
    } else if (url_actual === url2) {
        var controlador = "grupos_listar_inactivas";
    }

    $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/' + controlador,
        type: 'POST',
        success: function (data) {
            $("#resultado").html(data);
        }

    });

}

function valores_edicion_grupo(url1, url2, url3, url_actual) {
    var nivel = $("#nivel").val();
    var categoria_grupo = $("#categoria_grupo").val();
    var nivel_anteriror = $("#nivel_anterior").val();

    $("select[name=nivel]").find("option[value=" + nivel + "]").attr("selected", "selected");

    $("select[name=idcategoria_cuenta] option").each(function () {
        var text_option = $(this).text();

        if (text_option === categoria_grupo) {
            $(this).attr("selected", "selected");
        }
    });

    var idcategoria_grupo = $("select[name=idcategoria_cuenta]").val();

    if (nivel !== "" && url_actual !== url1 && url_actual !== url2 && url_actual !== url3) {
        select_nivel_superior(nivel, idcategoria_grupo);
    }
    $("select[name=nivel_anterior]").find("option[value=" + nivel_anteriror + "]").attr("selected", "selected");

}


function select_nivel_superior(nivel, categoria) {
    $.ajax({
        url: "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/grupo_formulario_select",
        type: "post",
        data: "nivel=" + nivel + "&idcategoria=" + categoria,
        success: function (data) {
            $("select[name=nivel_anterior]").html(data);
        },
        error: function (data) {
            alert(nivel + categoria + data);
            alert("error al consultar niveles anteriories");
        }

    });
}

function busqueda(val, camp) {

    $.ajax({
        url: "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/grupos_buscar",
        type: "post",
        data: "valor=" + val + "&campo=" + camp,
        success: function (data) {

            $("#resultado").html(data);
        }

    });
}

function valida() {
    var valor = $('#valor').val();
    var campo = $('#campo option:selected').val();

    if (valor !== "" && !isNaN(valor) && (campo === "nivel_anterior" || campo === "nivel")) {
        busqueda(valor, campo);

    } else if (valor !== "" && isNaN(valor) && (campo === "nivel_anterior" || campo === "nivel")) {
        alert("Solo se aceptan numeros para esta busqueda");

    } else if (valor !== "" && isNaN(valor) && (campo === "grupo_cuenta" || campo === "categoria")) {
        busqueda(valor, campo);

    } else if (valor !== "" && !isNaN(valor) && (campo === "grupo_cuenta" || campo === "categoria")) {
        alert("Solo se aceptan caracteres alfaberticos para esta busqueda");

    } else if (valor === "") {
        busqueda(valor, campo);
    }
}

function confirmar_inactivar(val) {
    var res = confirm("¿Esta seguro que desea desactivar esta categoria?");
    if (res === true) {
        window.location.href = "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/grupo_cambiar_estado/" + val + "/0";
    } else if (res === false) {
        return 0;
    }
}

function confirmar_eliminar(val) {
    var res = confirm("¿Esta seguro que desea eliminar este grupo?");
    
    if (res === true) {
        $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/grupo_dependencia_cuenta',
            type: 'POST',
            data: "idcuenta_contable=" + val,
            success: function (data) {

                if (data == 0) {
                    window.location.href = "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/grupo_eliminar/" + val;

                } else if (data > 0) {
                    alert("No puede eliminar un grupo que esta siendo utilizado");
                }

            },
            error: function () {
                alert('Error al consultar dependecias');
            }

        });

    } else if (res === false) {
        return 0;
    }

}

$(document).ready(function () {
    ///listado
    var url_actual = window.location.href;
    var url1 = "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/index/1";
    var url2 = "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/index/0";
    var url3 = "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/grupo_crear";

    lista_grupo(url1, url2, url_actual);

    $("#buscar , #recargar").on('click', function () {
        valida();
    });

    $("#valor").on('keyup', function () {
        valida();
    });

    $("#resultado").on('click', ".inactivar", function () {
        confirmar_inactivar($(this).attr("value"));
    });
    
    $("#resultado").on("click",".eliminar",function(){
        confirmar_eliminar($(this).attr("value"));
    });
    
    
    ///creacion y edicion
    var nivel = $("select[name=nivel]").val();
    var categoria = parseInt($("select[name=idcategoria_cuenta]").val());
    select_nivel_superior(nivel, categoria);

    $("select[name=nivel]").on("change", function () {
        var nivel = parseInt($(this).val());
        var categoria = parseInt($("select[name=idcategoria_cuenta]").val());
        select_nivel_superior(nivel, categoria);

    });

    $("select[name=idcategoria_cuenta]").on("change", function () {
        var categoria = parseInt($(this).val());
        var nivel = parseInt($("select[name=nivel]").val());
        select_nivel_superior(nivel, categoria);

    });
    
    valores_edicion_grupo(url1, url2, url3, url_actual);

});
