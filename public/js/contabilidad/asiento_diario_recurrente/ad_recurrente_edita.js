$(document).ready(function () {
//    $("html").data("num_ad_original",$("#numero_asiento_diario").val());
   
    var valor_origen = $("#valor_origen_ad").val();
    $("#idorigen_asiento_diario").find("option[value="+valor_origen+"]").attr("selected","selected");
    
    var idmoneda = $("#idmoneda_actual").val();
    $("select[name=idmoneda]").find("option[value="+idmoneda+"]").attr("selected","selected");
    
      
});