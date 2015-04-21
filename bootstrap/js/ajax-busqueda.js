$(document).ready(function(){
  
   $("#buscar").on('click',function () {
 var valor=$('#valor').val();
 var campo=$('#campo option:selected').val();
 
	$.ajax({
	    url:"http://localhost/Proyects/cacao/index.php/contabilidad/catalogo/categoria/c_categoria/buscar",
	    type:"post",
	    data:"valor="+valor+"&campo="+campo,
	    success:function(data){
                            
                    $("#resultado").html(data);
            }
                        
           			});   
  });
   
}); 

       