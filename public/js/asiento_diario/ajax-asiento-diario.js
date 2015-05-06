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
    
    $("#select1").change(function(event){
            var id = $("#select1").find(':selected').val();
            $("#select2").load('genera-select.php?id='+id);
        });
    
    
    
    
    $("#guardar").on("click",function(){
        open("http://localhost/cacao/index.php/bancos/banco",'Sizewindow',"width=200,height=200,scrollbars=no,toolbar=no,directories=no");
    });
   
}); 