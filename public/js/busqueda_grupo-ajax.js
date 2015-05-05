$(document).ready(function(){
    
function busqueda(){
    var valor=$('#valor').val();
     var campo=$('#campo option:selected').val();
    
	$.ajax({
	    url:"http://localhost/cacao/index.php/contabilidad/catalogo/grupo/grupo/buscar",
	    type:"post",
	    data:"valor="+valor+"&campo="+campo,
	    success:function(data){
                            
                    $("#resultado").html(data);
            }
                        
           			});
}    
  
   $("#buscar").on('click',function () {
       busqueda();
  });
  
  $("#valor").on('keypress',function () {
       busqueda();
  });
   
});       