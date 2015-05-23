$(document).on("ready", function () {
    
    $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_listar',
        type: 'POST',
        success: function (data) {
            $("#resultado").html(data);
        },
        error:function(){
            alert("Error al intentar listar");
        }

    });
        });