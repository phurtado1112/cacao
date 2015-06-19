
function lista_cuentas() {
    var url1 = "http://localhost/cacao/index.php/contabilidad/catalogo/cuentas/cuentas/index/1";
    var url2 = "http://localhost/cacao/index.php/contabilidad/catalogo/cuentas/cuentas/index/0";

    var url_actual = window.location.href;

    if (url_actual === url1) {
        var controlador = "cuentas_listar";
    } else if (url_actual === url2) {
        var controlador = "cuentas_listar_inactivas";
    }

    $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/catalogo/cuentas/cuentas/' + controlador,
        type: 'POST',
        success: function (data) {
            $("#resultado").html(data);
        }

    });
}

function busqueda_cuentas(campo, valor) {

    $.ajax({
        url: "http://localhost/cacao/index.php/contabilidad/catalogo/cuentas/cuentas/cuentas_buscar",
        type: "post",
        data: "valor=" + valor + "&campo=" + campo,
        success: function (data) {

            $("#resultado").html(data);
        }

    });

}

function desactivar_confirmar(val) {
    var res = confirm("¿Esta seguro que desea desactivar esta cuenta?");
    if (res === true) {
        window.location.href = "http://localhost/cacao/index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_cambiar_estado/" + val + "/0";
    } else if (res === false) {
        return 0;
    }
}

function validar_busqueda() {

    var valor = $('#valor').val();
    var campo = $('#campo').val();

    if ((!isNaN(valor) || valor === "") && campo === "idcuenta_contable") {
        busqueda_cuentas(campo, valor);

    } else if (isNaN(valor) && campo === "idcuenta_contable") {
        alert("Busqueda por numero de cuenta solo admite valores numericos");

    } else if ((isNaN(valor) || valor === "") && (campo === "cuenta" || campo === "naturaleza" || campo === "grupo_cuenta")) {
        busqueda_cuentas(campo, valor);

    } else if ((!isNaN(valor)) && (campo === "cuenta" || campo === "naturaleza" || campo === "grupo_cuenta")) {
        alert("Este tipo de busqueda solo admite valores no numericos");
    }

}

function cuenta_asignar_valores() {
    var naturaleza_cuenta = $("#naturaleza_cuenta").val();
    $("select[name=naturaleza_cuenta_contable]").find("option[value=" + naturaleza_cuenta + "]").attr("selected", "selected");

    var grupo_cuenta = $("#grupo_cuenta").val();
    $("select[name=idgrupo_cuenta] option").each(function () {

        var text_option = $(this).text();

        if (text_option === grupo_cuenta) {
            $(this).attr("selected", "selected");
        }
    });

}

function confirmar_eliminar(val) {
    var res = confirm("¿Esta seguro que desea eliminar esta cuenta?");
    if (res === true) {
        
        $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_relacion_adr_adrd',
            type: 'POST',
            data: "idcuenta=" + val,
            success: function (data) {
                
                if (data == 0) {
                    window.location.href = "http://localhost/cacao/index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_eliminar/" + val;

                } else if (data > 0) {
                    alert("No puede eliminar una cuenta que esta siendo utilizada");
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

function consulta_cuenta_id(id) {

    $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/catalogo/cuentas/cuentas/cuenta_consulta_esturctura_id',
            type: 'POST',
            data: "idgrupo=" + id,
            success: function (data) {
                alert(data);
            },
            error: function () {
                alert('Error');
            }
        });
}

$(document).on("ready", function () {
    lista_cuentas();

    cuenta_asignar_valores();

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
        desactivar_confirmar($(this).attr("value"));
    });

    $("#resultado").on('click', ".eliminar", function () {
        confirmar_eliminar($(this).attr("value"));
    });
    
    //crear cuenta
//    $("select[name=idgrupo_cuenta]").on('change', function () {
//        alert($(this).val());
//        consulta_cuenta_id($(this).val());
//        
//    });
    

  $("#idcuenta_contable").mask("9999-99-99");

});