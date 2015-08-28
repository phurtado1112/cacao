
/* global smoke */

function lista_cuentas() {

    $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/reportes/cuentas_contable/cuentas_contables_reporte/',
        type: 'POST',
        success: function (data) {
            $("#resultado").html(data);
        }

    });
}

function busqueda_cuentas(campo, valor) {

    $.ajax({
        url: "http://localhost/cacao/index.php/contabilidad/reportes/cuentas_contable/cuentas_contables_reporte/cuentas_buscar",
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

    if ((!isNaN(valor) && valor !== "") && campo === "idcuenta_contable") {
        busqueda_cuentas(campo, valor);

    } else if (isNaN(valor) && campo === "idcuenta_contable") {
        smoke.alert("Busqueda por numero de cuenta solo admite valores numericos");

    } else if ((isNaN(valor) && valor !== "") && (campo === "cuenta" || campo === "naturaleza" || campo === "grupo_cuenta")) {
        busqueda_cuentas(campo, valor);

    } else if ((!isNaN(valor)) && (campo === "cuenta" || campo === "naturaleza" || campo === "grupo_cuenta")) {
        smoke.alert("Este tipo de busqueda solo admite valores no numericos");
        
    }else if(valor === ""){
        location.reload();
    }

}

$(document).on("ready", function () {
    lista_cuentas();

//    cuenta_asignar_valores();
//
//    $("#buscar").on('click', function () {
//        validar_busqueda();
//    });
//
//    $("#valor").on('keyup', function () {
//        validar_busqueda();
//    });
//
//    $("#campo").on('change', function () {
//        if($("#valor").val() !== ""){
//        validar_busqueda();
//    }
//    });
//
//    $("#resultado").on('click', ".inactivar", function () {
//        desactivar_confirmar($(this).attr("value"));
//    });
//
//    $("#resultado").on('click', ".eliminar", function () {
//        confirmar_eliminar($(this).attr("value"));
//    });
//    
//
//  $("#idcuenta_contable").mask("9999-99-99");
//
});

