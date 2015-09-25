<div class="container">
    <div class="row">
        <div class="span3 well">
            <h3 class=" col-lg-offset-3"> REPORTE DE ESTADO RESULTADO</h3><br><br>
            <div class="row">
                <a id="boton_pdf" class="btn btn-success col-lg-1 fa fa-file-o fa-lg" style="margin-left: 15px; margin-right: 5px;"> PDF</a> 
                <a  id="boton_excell"  class="btn btn-success col-lg-1 fa fa-list-alt fa-lg"> Excel</a>          
          
            
            <div class="col-lg-2 col-lg-offset-2">
                <input type="hidden" id="usuario" value='<?= $this->session->userdata('user') ?>'>
                <input type="hidden"  id="fecha" value='<?= date("Y-m-d") ?>'>
                <div class="col-lg-1 col-lg-offset-1">
                    <label class="col-lg-4">Presentacion</label>
                    <select id="presentacion" class="dropdown-toggle col-lg-6 form-control" style="width: 125px">
                        <option value="general">General</option>
                         <option value="detalle">Por detalle</option>
                    </select>
                </div> </div>
                <div class="col-lg-2">
                    <label class="col-lg-4">Moneda</label>
                    <select id="moneda" class="dropdown-toggle col.lg-6 form-control" style="width: 125px">
                        
                        <?php foreach ($idmoneda as $mo) { ?>
                            <option value="<?= $mo['idmoneda'] ?>"><?= $mo['descripcion_moneda'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <label class="col-lg-4">Perido</label>
                    <select id="periodo" class="dropdown-toggle col-lg-6 form-control" style="width: 125px">
                        <?php for ($i = 1; $i < 13; $i++) { ?>
                            <option value="<?= $i ?>">periodo<?= $i ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-1">
                    <label class="col-lg-4">Año</label>
                    <input id="anio" value="<?= date("Y"); ?>" class="dropdown-toggle form-control col-lg-6" style="width: 60px" maxlength="4">
                </div>
            </div><br>
          
            <div class="container-fluid valor valor" id="resultado" style="padding: 15px; margin-bottom: 30px ;width:900px;"> 

            </div>
        </div>
            
    </div>
    </div>


