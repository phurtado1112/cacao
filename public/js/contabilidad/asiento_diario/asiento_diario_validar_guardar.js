
   function guardar(){
       var idorigen_asiento_diario = $("#idorigen_asiento_diario>selected").val();
        var descripcion_asiento_diario = $("#descripcion_asiento_diario").val();
        var numero_asiento_diario = $("#numero_asiento_diario").val();
        var usuario_creacion = $("#usuario_creacion").val();
        var balance_credito = $("#total_credito").val();
        var balance_debito = $("#total_debito").val();
        var fecha_creacion = $("#recoge_fecha").val();
        var idtasa_cambio = $("#idtasa_cambio").val();
        var fecha_fiscal = $("#fecha_fiscal").val();
        
        
        
        if(descripcion_asiento_diario==null||descripcion_asiento_diario.length == 0){
            alert('Es necesario el campo de descripcion');
        }
        else if(fecha_creacion==null||fecha_creacion.length==0){
            alert('Es necesario el campo de Fecha Creacion');
        }
        else if(fecha_fiscal==null||fecha_fiscal.length==0){
            alert('Es necesario el campo de Fecha Fiscal');
        }

        else {  
            $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_guardar',
            type: 'POST',
            data: "idorigen_asiento_diario="+idorigen_asiento_diario + "&numero_asiento_diario="+numero_asiento_diario + "&descripcion_asiento_diario="+descripcion_asiento_diario +
                   "&idtasa_cambio="+idtasa_cambio + "&balance_debito="+balance_debito + "&balance_credito="+balance_credito + "&usuario_creacion="+usuario_creacion + "&fecha_creacion="+fecha_creacion+
                   "&fecha_fiscal="+fecha_fiscal,
            success : function (data){
               alert('Asiento Diario Creado');
               alert(data);
           }

        });
    };
   }
    
    
$(document).ready(function(){
        
        $(".crear").on("click", function(){
                guardar();     
        });

    
    
});


