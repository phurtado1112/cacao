<?php

if($inicio>0){
    echo $tabla_estilos;
    echo "<table>"
    . "<tr><th colspan='2'>Cuenta</th><th colspan='3'>Descripcion</th></tr><br>";
} 

for($i=$inicio;$i <= $final+$inicio;$i++){
    if(!empty($html[$i])){
    echo $html[$i];
    }
}
echo "</table>";

echo "<div align='center'>
        <nav>
             <ul class='pagination'>"
                .$paginacion."
            </ul>
         </nav>
    </div>";
