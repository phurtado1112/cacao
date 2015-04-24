$(document).ready(function(){
    
  //alert($('#descripcion_cuenta_contable:last').attr('name').charAt('28'));
    
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
   
}); 