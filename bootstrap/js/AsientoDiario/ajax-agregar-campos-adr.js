$(document).ready(function(){
    
    $('#clone').hide();
   $("#agregar").on('click',function () {
        $('#clone').show();
                    $('#clone').clone().attr('id','none').insertAfter('tbody:last');
                    
         $('#clone').hide();            
    });
   
}); 