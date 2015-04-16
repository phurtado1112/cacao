$(document).ready(function(){
    
    $("#modulo").change(function () {
        
         var elegido=$(this).val();
        
        if( elegido == 1){
            window.location=('http://localhost/Proyects/cacao/index.php/contabilidad/contabilidad');
    }else if(elegido == 2){
         window.location=('http://localhost/Proyects/cacao/index.php/administracion/administracion');
    }else if(elegido == 3){
         window.location=('http://localhost/Proyects/cacao/index.php/bancos/banco');
    }
        
    });
}); 

       