$(document).on("ready",function(){
    
    var url1 = "http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/index/1";
    var url2 = "http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/index/0";
      
    $.ajax({
               url: 'http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/categorias_listar',
               type: 'POST',
               success: function(data){
                    $("#resultado").html(data);
               }
               
            });
            
        
 
function busqueda(){
    var valor=$('#valor').val();
     var campo=$('#campo option:selected').val();
	$.ajax({
	    url:"http://localhost/cacao/index.php/contabilidad/catalogo/categoria/categoria/categorias_buscar",
	    type:"post",
	    data:"valor="+valor+"&campo="+campo,
	    success:function(data){
                            
                    $("#resultado").html(data); 
            }
                        
           			});
                             
}  

/*
function confirmar() {
  var res=confirm("Esta seguro que sdesea desactivar esta categoria");
  if(res===true){
      window.location.href = ".base_url().index.php/contabilidad/catalogo/categoria/categoria/categoria_cambiar_estado/.$id./0";
  }else if(res===false){
      return 0;
  }
 
}*/

$("#buscar").on('click',function () {
     busqueda();
  });
  
$("#valor").on('keypress',function () {
      busqueda();
  });
  
$("#inactivar").on('click',function () {
      // confirmar();
  });
   
}); 

