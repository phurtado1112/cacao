
/* global smoke */


function generar_pdf() {
    var periodo = $("#periodo").val();
    var anio = $("#anio").val();
    var usuario = $("#usuario").val();

    if (periodo != "" && anio != "" && usuario != "") {
        window.location.href = "http://localhost/cacao/index.php/contabilidad/reportes/estado_resultado/generar_pdf/" + periodo + "/" + anio + "/" + usuario;

    } else if (periodo == "" || anio == "" || usuario == "") {
        alert("No se puede generar reporte por falta de datos \n\Porfabor ingrese los datos faltantes");
    } else {
        alert("No se puede generar reporte");
    }
}

function mostrar_balance_general() {
    var periodo = $("#periodo").val();
    var anio = $("#anio").val();
    var usuario = $("#usuario").val();



    if (periodo != "" && anio != "" && usuario != "") {
        $.ajax({
            url: "http://localhost/cacao/index.php/contabilidad/reportes/estado_situacion/mostrar_reporte",
            type: 'POST',
            data: "periodo=" + periodo + "&anio=" + anio + "&usuario=" + usuario,
            success: function (data) {
                $("#resultado").html(data);
            }

        });

    } else if (periodo == "" || anio == "" || usuario == "") {
        alert("No se puede generar reporte por falta de datos \n\Porfabor ingrese los datos faltantes");
    } else {
        alert("No se puede generar reporte");
    }
}

//function busqueda_cuentas(campo, valor) {
//
//    $.ajax({
//        url: "http://localhost/cacao/index.php/contabilidad/reportes/cuentas_contable/cuentas_contables_reporte",
//        type: "post",
//        data: "valor=" + valor + "&campo=" + campo,
//        success: function (data) {
//
//            $("#resultado").html(data);
//        }
//
//    });
//
//}

//function validar_busqueda() {
//    var valor = $('#valor').val();
//    var campo = $('#campo').val();
//
//    if ((!isNaN(valor) && valor !== "") && campo === "idcuenta_contable") {
//        busqueda_cuentas(campo, valor);
//
//    } else if (isNaN(valor) && campo === "idcuenta_contable") {
//        smoke.alert("Busqueda por numero de cuenta solo admite valores numericos");
//
//    } else if ((isNaN(valor) && valor !== "") && (campo === "cuenta" || campo === "naturaleza" || campo === "grupo_cuenta")) {
//        busqueda_cuentas(campo, valor);
//
//    } else if ((!isNaN(valor)) && (campo === "cuenta" || campo === "naturaleza" || campo === "grupo_cuenta")) {
//        smoke.alert("Este tipo de busqueda solo admite valores no numericos");
//        
//    }else if(valor === ""){
//        location.reload();
//    }
//
//}

$(document).on("ready", function () {

//    mostrar_balance_general();
//

    $("#boton_pdf").on('click', function () {
        generar_pdf();
    });
//
//    $("#anio").on('keyup', function () {
//       mostrar_balance_general();
//    });
////
//    $("#periodo").on('change', function () {
//        mostrar_balance_general();
//    });
////
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

