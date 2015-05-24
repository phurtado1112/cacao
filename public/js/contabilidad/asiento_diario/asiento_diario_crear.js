$(document).ready(function () {

    $(function () {
//        estilo del datepicker para dar formato en idioma español
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            dateFormat: 'yy-mm-dd',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        $(function () {
            $("#recoge_fecha").datepicker();
            $("#fecha_fiscal").datepicker();
        });
    });
            
    //////////////seleccion de moneda/cambio ///////////////
    
    $("#moneda>select").change(function () {
        var fecha=$("#recoge_fecha").val();
        
        var elegido = $(this).val();

        if (elegido == 1 ) {
            $("#tasa_cambio").val(1);

        } else if (elegido == 2 &&  fecha!=''){
            buscar_fecha();
//
        }else if (elegido == 2 &&  fecha==='') {
            alert("Usted necesita introducir fecha de creacion");
            $("#tasa_cambio").val("ND");
        }
    });
    
    $("#recoge_fecha").change(function () {
         var elegido = $("#moneda>select").val();
    
         if (elegido == 2 ) {
             
             buscar_fecha();
        }
            });
            

    function buscar_fecha() {
        
        $("#recoge_fecha").val();   
        var fecha_buscada = $("#recoge_fecha").val();
        
        $.ajax({
            url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/buscar_fecha',
            type: 'POST',
            data: "fecha_buscada=" + fecha_buscada,
            success: function (data) {
                if (data === 'vacio') {
                    alert('No existe ningun tipo de cambio asociado a esta fecha');
                    $("#tasa_cambio").val("ND");
                }
                else {
                  
                    var arreglo = data.split('/');
                    $("#tasa_cambio").val(arreglo[0]);
                    $("#idtasa_cambio").val(arreglo[1]);
                        
                }
            }
        });
    };

});