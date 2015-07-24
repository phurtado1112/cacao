<?php
	/*se incluse las librerias*/
//	include_once(APPPATH.'reportes\\php-jru\\php-jru.php');

	/*lista de formatos y su respectivo mime type*/     
	$formatos = array(
            PJRU_PDF => array('Documento Portable (PDF)','application/pdf'),
            PJRU_EXCEL => array('Exel','application/vnd.ms-excel'),
            PJRU_OPEN_DOCUMENT => array('OpenOffice','application/vnd.oasis.opendocument.text'),
            PJRU_RICH_TEXT => array('Documento de Texto de Microsoft (RTF)','application/rtf')
	);
        
	$valor=filter_input(INPUT_POST, 'formato');
                //filter_input(INPUT_REQUEST, 'formatos');
	/*se genera el report si se indica el formato*/
	if(filter_input(INPUT_POST, 'formato')){
		$reportManager =  new ReportManager();
			
		$result = $reportManager->RunToFile('reporte_prueba',filter_input(INPUT_POST, 'formatos'));	

		header('Content-type: '.$formatos[filter_input(INPUT_POST, 'formato')][1]);
	
		print $result;

		die(0);
	} else {
            ?>
            <div style="margin-left: auto; margin-right: auto; width: 450px;  margin-top: 100px">

<h2>Generación de reportes con PHP-JRU </h2>
Para mayor información visite:
<br/> 
<a href="http://robertbruno.wordpress.com">robertbruno.wordpress.com</a>

<br/><br/>

Indique el formato del reporte que desea ejecutar

<br/>

<form action="<?php echo filter_input(INPUT_SERVER, 'PHP_SELF')?>">

<select name="formato">
	
<?php foreach ($formatos as $ext => $descripcion):?>

<option value='<?php echo $ext?>'><?php echo $descripcion[0]?></option>

<?php endforeach;?>
	
</select>

<input type="submit"/> 

</form>

</div>	
<?php }
