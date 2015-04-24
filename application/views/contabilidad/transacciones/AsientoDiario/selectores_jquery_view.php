<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>bootstrap/css/960.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>bootstrap/css/text.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>bootsrap/css/reset.css" media="screen" />
                <script type="text/javascript" src="<?= base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
                
        <script type="text/javascript" src="<?= base_url(); ?>bootstrap/js/jquery-2.1.3.min.js"></script>
        <title><?=$titulo?></title> 
        <script type="text/javascript">
            
        	$(document).ready(function(){
               
            /*al pulsar sobre le último añadir selector comprobamos
            si el input y el select anteriores no están vacíos
            con $(this).prevAll(selector).val()*/
 
        		$("#nuevo").find("#add_selector:last").on('click',function(){	
                    
        			if($(this).prevAll("#nombre").val() == '')	
        			{
        				alert('No puedes dejar un campo vacío');
        			}
        			else if($(this).prevAll("#puntos:last").val() == '')
        			{
        				alert('Debes dar una puntuacion');
        			}else{
 
                        /*si los campos no están vacíos creamos otros campos para
                        colocar una nueva etiqueta*/
 
        				$("#nuevo").html('<div style="margin:10px 0px 0px -10px; border:0"'+
        				'<div id="nuevo" class="grid_12">'+
						'<input type="text" id="nombre" name="nombre[]" />&nbsp;'+
						'<select name="puntos[]" id="puntos">'+	
						'<option value="">Escoge una puntuación</option><option value="1">1 punto</option>'+
						'<option value="2">2 puntos</option><option value="3">3 puntos</option>'+
						'<option value="4">4 puntos</option></select>'+
						'<span class="grid_2" id="add_selector">Añadir etiqueta</span></div><div class="grid_2"'+
	        			'id="eliminar">Eliminar</div>');
        			}      			
        		});
 
                   //al pulsar sobre eliminar localizamos cúal ha sido con find y la ayuda de live
 
        		$('#nuevo').find("#eliminar").on('click',function(){
 
                   //localizamos el div nuevo y le ponemos el fondo amarillo
 
        			$(this).prevAll().eq(0).css('background','yellow');
 
                  //con esta línea localizamos el valor del input del div sobre el que hemos pulsado
 
        			valor_input = $(this).prevAll().eq(0).find('input').val();
 
                  //con esta línea localizamos el valor del select del div sobre el que hemos pulsado
 
        			valor_select = $(this).prevAll().eq(0).find('select').val();
        			if(confirm('¿Quieres eliminar la etiqueta con nombre '+valor_input+' y puntuación '+valor_select+'?' ))
        			{
        				$(this).prev("#nuevo").remove();
        				$(this).remove();
        			}else{
        				alert('No se hicieron cambios');
        				$(this).prevAll().eq(0).css('background','#2792bd');
        			}   			
        		})
        	});
        </script>   
        <style type="text/css">
        	#nuevo{
        		border: 3px solid #fff;
        		background: #2792bd;
        		color: #fff;
        		font-size: 12px;
        		padding: 9px 10px;
        		border: 8px solid #e4e8ee;
        	}
        	#add_selector{
        		font-size: 14px;
        		margin-top: 1px;
        		padding: 1px 5px;
        		border-radius: 4px;
        		background: #111;
        		text-align: center;
        		cursor: pointer;
        	}
        	#eliminar{
        		font-size: 14px;
        		margin: -34px 0px 0px 650px;
        		padding: 1px 5px;
        		border-radius: 4px;
        		background: #111;
        		text-align: center;
        		cursor: pointer;
        	}
        	#boton{
        		text-align: center;
        		background: #fff;
        		color: #111;
        		cursor: pointer;
        		font-weight: bold;
        		padding: 7px 10px;
        	}
        </style>   
    </head>
	    <body style="background-color: #111; color:#fff">
			<div class="container_12"> 
				<?php $atributos = array('name' => 'formulario', 'id' => 'formulario'); ?>
				<?=form_open(base_url().'AsientoDiario/selectores_jquery/array_selectores',$atributos)?>
	
					<div id="nuevo" class="grid_12">
						<input type="text" value="" id="nombre" name="nombre[]" />
						<select name="puntos[]" id="puntos">	
								<option value="">Escoge una puntuación</option>
								<option value="1">1 punto</option>
								<option value="2">2 puntos</option>
								<option value="3">3 puntos</option>
								<option value="4">4 puntos</option>
						</select>
						<span class="grid_2" id="add_selector">Añadir etiqueta</span>	
					</div><br /><br />
 
                  <!--al pulsar el div se envía el formulario con el onclick-->
 
					<div class="grid_4" id="boton" onclick="document.forms.formulario.submit()">
						Enviar datos
					</div>						
				<?=form_close()?>			
			</div>
    </body>
</html>   