
<!DOCTYPE html>
<!--
 Franklin Altamirano Gonzalez 
-->
<html lang="es">
    <head>
        <title>Title</title>
   

    </head>
    <body>
        <?php
        $et = '';
        if ($etiquetas) {
            $et = explode('*//*', $etiquetas->nombre_etiquetas);
            foreach ($et as $value) {
                $val = str_replace('-', '. Puntuación de la etiqueta: ', $value);
                echo $val;
                ?><br /><?php
            }
        }
        ?>
    </body>

</html>
