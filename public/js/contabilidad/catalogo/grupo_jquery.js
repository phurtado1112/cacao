/* global smoke */

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
    var nivel_busqueda_recuperado = parseInt(nivel) - 1;
    var categoria_grupo = $("#categoria_grupo").val();
    var nivel_anteriror = $("#idnivel_anterior").val();
    var acepta_cuenta_actual = $("#acepta_cuenta_actual").val();
    /// seleccion nivel
    $("select[name=nivel]").find("option[value=" + nivel + "]").attr("selected", "selected");
    /// seleccion categoria
    $("select[name=idcategoria_cuenta] option").each(function () {
        var text_option = $(this).text();

        if (text_option === categoria_grupo) {
            $(this).attr("selected", "selected");
        }
    });
    /// seleccion nivel anterior
    var idcategoria_grupo = $("select[name=idcategoria_cuenta]").val();

    disparadores_dependencias_grupos();

    if (nivel_busqueda_recuperado === 0) {
        idcategoria_grupo = 0;
    }

    select_nivel_superior(nivel_busqueda_recuperado, idcategoria_grupo);

    $("select[name=idnivel_anterior]").find("option[value=" + nivel_anteriror + "]").attr("selected", "selected");
    
    $("#radio_button").find("input[value=" + acepta_cuenta_actual + "]").attr("checked", "checked");

}


function select_nivel_superior(nivel, categoria) {

    $.ajax({
        url: "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/grupo_formulario_select",
        type: "post",
        data: "nivel=" + nivel + "&idcategoria=" + categoria,
        success: function (data) {
            if (data !== "0") {
                $("select[name=idnivel_anterior]").html(data);
            } else {
                smoke.alert("No se ecnontro ningun grupo con estas caracteristicas");
                $("select[name=idnivel_anterior]").html("<option value='' ></option>");
            }
        },
        error: function () {
            smoke.alert("error al consultar niveles anteriories");
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


function valida_campo_valor() {
    var valor = $('#valor').val();
    var campo = $('#campo option:selected').val();

    if (valor !== "" && !isNaN(valor) && (campo === "idnivel_anterior" || campo === "nivel")) {
        busqueda(valor, campo);

    } else if (valor !== "" && isNaN(valor) && ( campo === "nivel")) {
        smoke.alert("Solo se aceptan numeros para esta busqueda");

    } else if (valor !== "" && isNaN(valor) && (campo === "grupo_cuenta" || campo === "categoria" || campo === "nivel_anterior")) {
        busqueda(valor, campo);

    } else if (valor !== "" && !isNaN(valor) && (campo === "grupo_cuenta" || campo === "categoria" || campo === "nivel_anterior")) {
        smoke.alert("Solo se aceptan caracteres alfanumericos para esta busqueda");

    } else if (valor === "") {
        location.reload();
    }
}

function confirmar_inactivar(val) {
    smoke.confirm("¿Esta seguro que desea desactivar esta categoria?",function(res){
    if (res === true) {
        window.location.href = "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/grupo_cambiar_estado/" + val + "/0";
    } else if (res === false) {
        return 0;
    }
    });
}

function confirmar_eliminar(val) {
    smoke.confirm("¿Esta seguro que desea eliminar este grupo?",function(res){

    if (res === true) {
        $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/grupo_dependencia_cuenta',
            type: 'POST',
            data: "idcuenta_contable=" + val,
            success: function (data) {
                
                if (data == 0) {
                    window.location.href = "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/grupo_eliminar/" + val;

                } else if (data > 0) {
                    smoke.alert("No puede eliminar un grupo que esta siendo utilizado");
                }

            },
            error: function (data) {
                smoke.alert(data);
                smoke.alert('Error al consultar dependecias');
            }

        });

    } else if (res === false) {
        return 0;
    }
    });

}

/// prepara disparadores para busqueda de grupos superiories
function disparadores_dependencias_grupos() {

    $("select[name=nivel]").on("change", function () {
        var nivel = parseInt($(this).val()) - 1;
        var categoria = $("select[name=idcategoria_cuenta]").val();
        if (nivel === 0) {
            categoria = 0;
        }
        select_nivel_superior(nivel, categoria);


    });

    $("select[name=idcategoria_cuenta]").on("change", function () {
        var categoria = $(this).val();
        var nivel = parseInt($("select[name=nivel]").val()) - 1;
        if (nivel === 0) {
            categoria = 0;
        }
        select_nivel_superior(nivel, categoria);

    });

}

$(document).ready(function () {
    ///listado
    var url_actual = window.location.href;
    var url1 = "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/index/1";
    var url2 = "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/index/0";
    var url3 = "http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/grupo_crear";

    lista_grupo(url1, url2, url_actual);

    $("#buscar , #recargar").on('click', function () {
        valida_campo_valor();
    });

    $("#valor").on('keyup', function () {
        valida_campo_valor();
    });
    
     $("#campo").on('change', function () {
        if($("#valor").val() !== ""){
        valida_campo_valor();
    }
    });

    $("#resultado").on('click', ".inactivar", function () {
        confirmar_inactivar($(this).attr("value"));
    });

    $("#resultado").on("click", ".eliminar", function () {
        confirmar_eliminar($(this).attr("value"));
    });

    ///creacion
    if (url_actual === url3) {
        disparadores_dependencias_grupos();
    }

    /// y edicion
    if (url_actual !== url1 && url_actual !== url2 && url_actual !== url3) {
        valores_edicion_grupo(url1, url2, url3, url_actual);
    }


});
