<div id="intro_tasa_cambio" class="overlay-container"> 
    <div  class="window-container zoomout valor">
        <button id='cerrar_pop_tasa_cambio' class="close">Cerrar</button>
        <div class="row">
            <h4>Introducir tasa cambio</h4>

<form class="form-horizontal" method="POST">
                <?php
                echo form_open();
                ?>
                <div class="alert alert-success cacao valor" role="alert" style="width: 90%; margin-left:5%;"> 
                <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Moneda</label>
                    <div class="col-lg-3"> 
                    <?php echo form_dropdown('idmoneda_tasa', $idmoneda_extra,'','class="form-control"'); ?>
                    </div> </div>                   
                    <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Tasa de cambio</label>
                    <div class="col-lg-3 dropdown"> 
                        <input class="col-lg-9 form-control" id="valor_tasa_cambio_nueva">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label col-lg-offset-2">Fecha</label>
                    <div class="col-lg-3 dropdown"> 
                        <input class="col-lg-9 form-control" id="fecha_nueva_tasa_cambio">
                    </div>
                </div>
              </div>
              <button  class="btn btn-success fa fa-check fa-lg col-lg-offset-5" id="agregar_tasa_cambio" type="button">Agregar</button>
            <?php echo form_close(); ?>
            
            </form>
        </div>
    </div>
</div>