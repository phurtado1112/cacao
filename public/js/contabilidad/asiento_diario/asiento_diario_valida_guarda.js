$(document).ready(function () {
    
    function validar_transacciones(){
        var credito_not = 0;
        var debito_not = 0;
        var idcuenta_contable_not = 0;
        
        $(".asiento_diario_detalle").each(function () {
        
        var debito = $(this).find(".campo_debito").val();
        var credito = $(this).find(".campo_credito").val();
        var idcuenta_contable = $(this).find(".idcuenta_contable").val();
        
        
        if(debito===""){
            debito_not++;
        }
        
        if(credito===""){
            credito_not++;
            
        }
        if(idcuenta_contable===""){
            idcuenta_contable_not++;
            
        }
        
        });
        var campos_vacios = [debito_not+credito_not,idcuenta_contable_not];
        return campos_vacios;
    }
   
    
    function guardar_transacciones(){
        $(".asiento_diario_detalle").each(function () {
            var idasiento_diario = 1;

            var numero_transacciones = $(this).find(".numero_transaccion").val();
            var idcuenta_contable = $(this).find(".idcuenta_contable").val();

            var debito = $(this).find(".campo_debito").val();
            var credito = $(this).find(".campo_credito").val();

            var valor_tasa_cambio = 27;//$("#tasa_cambio").val();

            if (debito==="0.0" && credito!=="0.0") {
                var tipo_transaccion = "c";

                var monto_moneda_nacional = credito;
                var monto_moneda_extranjera = credito * valor_tasa_cambio;

            } else if (debito!=="0.0" && credito==="0.0") {
                var tipo_transaccion = "d";

                var monto_moneda_nacional = debito;
                var monto_moneda_extranjera = debito * valor_tasa_cambio;
                
            }
            
            $.ajax({
                url: "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_detalle_guardar",
                type: "post",
                data: "idasiento_diario="+idasiento_diario+"&numero_transacciones="+numero_transacciones+"&idcuenta_contable="+idcuenta_contable+ "&tipo_transaccion="+tipo_transaccion+"&monto_moneda_nacional="+monto_moneda_nacional+"&monto_moneda_extranjera="+monto_moneda_extranjera,
                success: function (data) {
                    alert(data+"Transacciones guardadas con exito");
                },
                error: function(){
                    alert("Eror en el proceso de guradado de transacciones");
                }
            });
        });
    }
     
    
    $("#guardar").on("click", function () {
        var transacciones= validar_transacciones();
        
        if(transacciones[0]===0 && transacciones[1]===0){
            guardar_transacciones();
            
        }else if(transacciones[0]>0 && transacciones[1]===0){
            alert("Usted tiene "+transacciones[0]+" montos vacios:\n\-Debe llenar los montos vacios con '0' ó cualquier numero.");
            
        }else if(transacciones[1]>0 && transacciones[0]===0){
            alert("Usted tiene "+transacciones[1]+" transacciones sin cuentas seleccionadas:\n\-Debe seleccionar una cuenta para cada transaccion.");
            
        }else if(transacciones[1]>0 && transacciones[0]>0){
            alert("Usted tiene "+transacciones[1]+" transacciones sin cuentas seleccionadas:\n\-Debe seleccionar una cuenta para cada transaccion."+
            "\n\ \n\Usted tiene "+transacciones[0]+" montos vacios:\n\-Debe llenar los montos vacios con '0' ó cualquier numero.");
        }
        

        
    });



});