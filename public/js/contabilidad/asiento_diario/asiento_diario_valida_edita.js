//function editar_asiento_diario() {

    var idorigen_asiento_diario = $("select#idorigen_asiento_diario").val();
    var descripcion_asiento_diario = $("#descripcion_asiento_diario").val();
    var numero_asiento_diario = $("#numero_asiento_diario").val();
    //var usuario_creacion = $("#usuario_creacion").val();
    var usuario_edicion = $("#usuario_edicion").val();
    var balance_credito = $("#total_credito").val();
    var balance_debito = $("#total_debito").val();
    var fecha_edicion = $("#fecha_edicion").val();
    var idtasa_cambio = $("#idtasa_cambio").val();
    var fecha_fiscal = $("#fecha_fiscal").val();

//    var tasa_cambio = $("#tasa_cambio").val();
//    var transacciones = validar_transacciones();
//    var origen_asiento_diario = $("select#idorigen_asiento_diario").find("option[value="+idorigen_asiento_diario+"]").text();

    alert(idorigen_asiento_diario+" "+descripcion_asiento_diario+" "
            +numero_asiento_diario+" "+usuario_edicion+" "+balance_credito+" "+balance_debito+" "+fecha_edicion
            +" "+idtasa_cambio+" "+fecha_fiscal);

//
//    if (descripcion_asiento_diario == null || descripcion_asiento_diario.length == 0) {
//        alert('Es necesario el campo de descripcion');
//    }
//    else if (fecha_creacion == null || fecha_creacion.length == 0) {
//        alert('Es necesario el campo de Fecha Creacion');
//    }
//    else if (fecha_fiscal == null || fecha_fiscal.length == 0) {
//        alert('Es necesario el campo de Fecha Fiscal');
//
//    }
//    else if (tasa_cambio === "ND" || tasa_cambio.length == 0) {
//        alert('El tipo de cambio no es valido');
//
//    } 
//    else if (transacciones[0] > 0 && transacciones[1] === 0) {
//        alert("Usted tiene " + transacciones[0] + " transaccion sin monto:\n\-Debe llenar los montos vacios con '0' ó cualquier numero.");
//
//    } 
//    else if (transacciones[1] > 0 && transacciones[0] === 0) {
//        alert("Usted tiene " + transacciones[1] + " transacciones sin cuentas seleccionadas:\n\-Debe seleccionar una cuenta para cada transaccion.");
//
//    } 
//    else if (transacciones[1] > 0 && transacciones[0] > 0) {
//        alert("Usted tiene " + transacciones[1] + " transacciones sin cuentas seleccionadas:\n\-Debe seleccionar una cuenta para cada transaccion." +
//                "\n\ \n\Usted tiene " + transacciones[0] + " transaccion sin monto:\n\-Debe llenar los montos vacios con '0' ó cualquier numero.");
//    
//    }
//    else if (balance_credito !== balance_debito ) {
//        alert("Usted debe balancear el asiento para poder guardarlo");
//    
//    }
//    else if (transacciones[0] === 0 && transacciones[1] === 0) {
//        
//        $.ajax({
//            url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_modificar',
//            type: 'POST',
//            data: "idorigen_asiento_diario=" + idorigen_asiento_diario + "&numero_asiento_diario=" + numero_asiento_diario + "&descripcion_asiento_diario=" + descripcion_asiento_diario +
//                    "&idtasa_cambio=" + idtasa_cambio + "&balance_debito=" + balance_debito + "&balance_credito=" + balance_credito + "&usuario_creacion=" + usuario_creacion + "&fecha_creacion=" + fecha_creacion +
//                    "&fecha_fiscal=" + fecha_fiscal+"&origen_asiento_diario="+origen_asiento_diario,
//            success: function (data) {
//                guardar_transacciones(data);
//
//            },
//            error: function () {
//                alert('Error al crear Asiento Diario');
//            }
//
//        });
//    }
//    ;
//}
//
//function validar_transacciones() {
//    var montos_vacios = 0;
//    var idcuenta_contable_not = 0;
//
//    $(".asiento_diario_detalle").each(function () {
//
//        var debito = $(this).find(".campo_debito").val();
//        var credito = $(this).find(".campo_credito").val();
//        var idcuenta_contable = $(this).find(".idcuenta_contable").val();
//
//
//        if (debito === "" && credito === "") {
//            montos_vacios++;
//        }
//        else if (idcuenta_contable === "") {
//            idcuenta_contable_not++;
//
//        }
//
//    });
//    var campos_vacios = [montos_vacios, idcuenta_contable_not];
//    return campos_vacios;
//}

//function guardar_transacciones(idasiento_diario_creado) {
//        var numero_transacciones_totales = $(".numero_transaccion:last").val();
//
//    $(".asiento_diario_detalle").each(function () {
//        var idasiento_diario = idasiento_diario_creado;
//
//        var numero_transacciones = $(this).find(".numero_transaccion").val();
//        var idcuenta_contable = $(this).find(".idcuenta_contable").val();
//
//        var debito = $(this).find(".campo_debito").val();
//        var credito = $(this).find(".campo_credito").val();
//
//        var valor_tasa_cambio = $("#tasa_cambio").val();
//
//        if (debito === "0.0" && credito !== "0.0") {
//            var tipo_transaccion = "c";
//
//            var monto_moneda_nacional = credito;
//            var monto_moneda_extranjera = credito * valor_tasa_cambio;
//
//        } else if (debito !== "0.0" && credito === "0.0") {
//            var tipo_transaccion = "d";
//
//            var monto_moneda_nacional = debito;
//            var monto_moneda_extranjera = debito * valor_tasa_cambio;
//
//        }
////        
//        $.ajax({
//            url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_detalle_guardar",
//            type: "post",
//            data: "idasiento_diario=" + idasiento_diario + "&numero_transacciones=" + numero_transacciones + "&idcuenta_contable=" + idcuenta_contable + "&tipo_transaccion=" + tipo_transaccion + "&monto_moneda_nacional=" + monto_moneda_nacional + "&monto_moneda_extranjera=" + monto_moneda_extranjera,
//            success: function () {
//                if(numero_transacciones_totales === numero_transacciones){
//                alert("Asiento de Diario creado con exito");
//                location.reload(true);
//            }
//            },
//            error: function () {
//                alert("Error en el proceso de guradado de transacciones");
//            }
//        });
//    });
//}



$(document).ready(function () {

    $("#guardar").on("click", function () {
        guardar_asiento_diario();




    });



});