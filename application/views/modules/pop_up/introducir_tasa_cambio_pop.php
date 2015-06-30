<div id="intro_tasa_cambio" class="overlay-container"> 
    <div  class="window-container zoomout valor">
        <button id='cerrar_pop_tasa_cambio' class="close">Cerrar</button>
        <div class="row">
            <h4>Introducir tasa cambio</h4>
            
            <table class="table" >
                <tr>
                    <th>
                        <label>Moneda</label>
                    </th>
                    <th>
                        <?php echo form_dropdown('idmoneda_tasa', $idmoneda_extra); ?>
                    </th>
                </tr>
                <tr>
                    <th>
                        <label>Tasa de cambio</label>
                    </th>
                    <th>
                        <input type="text" id="valor_tasa_cambio_nueva" class="col-sm-offset-2">
                    </th>
                </tr>
                <tr>
                     <th>
                        <label>Fecha</label>
                    </th>
                    <th>
                         <input type="text" id="fecha_nueva_tasa_cambio" class="col-sm-offset-2">
                    </th>
                </tr>
            </table>
            
       
            <button  class="btn btn-default" id="agregar_tasa_cambio" type="button">Agregar</button>
        </div>
    </div>
</div>