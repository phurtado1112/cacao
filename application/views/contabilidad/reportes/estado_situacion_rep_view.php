<div class="container">
    <div class="row">
        <div class="span3 well">
            <h3 class=" col-lg-offset-3"> REPORTE DE ESTADO SITUACION</h3><br><br>
            <div class="navbar navbar-inner block-header">
                <a id="boton_pdf" class="btn btn-success fa fa-file-o fa-lg"> PDF</a> 
                <a id="boton_excell" class="btn btn-success fa fa-list-alt fa-lg"> Excel</a>
            </div>
            <div class="row col-lg-offset-8">
                <div class="col-lg-1">
                    <input type="hidden" id="usuario" value='<?= $this->session->userdata('user') ?>'>
                     <input type="hidden"  id="fecha" value='<?= date("Y-m-d")?>'>
                    <label>Moneda</label>
                    <select id="moneda" class="dropdown-toggle form-control" style="width: 115px">
                        <?php foreach ($idmoneda as $mo) { ?>
                            <option value="<?= $mo['idmoneda'] ?>"><?= $mo['descripcion_moneda'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-1  col-lg-offset-3">
                    <label>Perido</label>
                    <select id="periodo" class="dropdown-toggle form-control" style="width: 115px">
                        <?php for ($i = 1; $i < 13; $i++) { ?>
                            <option value="<?= $i ?>">periodo<?= $i ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-2 col-lg-offset-3">
                    <label>Año</label>
                    <input id="anio" value="<?= date("Y"); ?>" class="dropdown-toggle form-control" style="width: 60px" maxlength="4">
                </div>
            </div>
            <div class="block-content collapse in valor" id="resultado" style="padding: 15px; margin-bottom: 30px"> 

            </div>
        </div>
    </div>
</div>


