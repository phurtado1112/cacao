
$(document).ready(function(){
    
 
     function scrollWin() {
    $('html,body').animate({
        scrollTop: $("#add-delete").offset().top
    }, 1);}
   
   $("#agregar").on('click',function () {
       
       scrollWin();
       
        $('#clone').show();
             $('#clone').clone().attr('id','agregado').insertAfter('tbody>tr:last');
         $('#clone').hide();       
      
    });
    
    $("#quitar").on('click',function () {
        
         $('#agregado:last').remove();    
         
          scrollWin();
    });
    
   
 $(".buscar_cuenta").on("click",function(){
   
    mostrar();
    });
    
   
     
    
  
}); 

  
$("input#buscar_c").click(function (){
    var valor =$(this).attr('name');
    var arreglo = valor.split("/");
    var id = arreglo[0];
    var descripcion =arreglo[1];
    $('#listar').fadeOut('slow');
    $(".buscar").val(id);
    $(".descripcion").val(descripcion);
    
   });  
   
  function mostrar(){
        $("#listar").fadeIn('slow');
    }
   
   
   
   
