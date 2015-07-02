function validar_pass(){
    var pass = $("#pass").val();
    var confirmar_pass = $("#confirmar_pass").val();
    var idusuario = $("input[name=idusuario]").val();

    
    if(pass === null || pass.length === 0){
        alert("Es necesario el campo contraseñia");
    } else if (pass === confirmar_pass){
        $.ajax({
           url:'http://localhost/cacao/index.php/administracion/usuario/usuario_procesar/usuario_editar_procesar_pass',
           type:'POST',
           data: "pass = " + pass + "&confirmar_pass = " + confirmar_pass + "&idusuario = " + idusuario, 
           success: function(){
                  alert("Contraseñia cambiada");
           },
            error:function(){
                    alert("Error en el proceso de cambiar contraseñia de usuario");
                }
           
        });
    }else{
        alert("Los campos no coinciden intete de nuevo");
    }
    
};

$(document).on("ready", function(){


    $(".editar").on("click", function(){
  
        
    });
});

