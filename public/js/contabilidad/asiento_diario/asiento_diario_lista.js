function confirmar(val) {

    var res = confirm("¿Esta seguro que desea eliminar este asiento de diario?");
    if (res === true) {
        window.location.href = "http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_eliminar/" + val;
    } else if (res === false) {
        return 0;
    }

}

$(document).on("ready", function () {

    $.ajax({
        url: 'http://localhost/cacao/index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_listar',
        type: 'POST',
        success: function (data) {
            $("#resultado").html(data);
        },
        error: function () {
            alert("Error al intentar listar");
        }

    });
    $("#resultado").on("click", ".eliminar_ad", function () {
        confirmar($(this).attr("value"));
    });
});

