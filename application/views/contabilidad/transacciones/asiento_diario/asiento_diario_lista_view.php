<div class="container">

    <div class="span3 well">
        <h4 class="fa fa-server fa-lg col-lg-offset-5"> Asiento Diario</h4></br>
        <a href="<?= base_url(); ?>index.php/contabilidad/transacciones/asiento_diario/asiento_diario/asiento_diario_crear" class="btn btn-success btn-lg fa fa-file-text-o fa-lg" role="button"> Nuevo</a>
        <a href="" class="btn btn-success btn-lg fa fa-refresh fa-lg" role="button"></a>
        <div class="row">
            <div class="col-md-4 col-md-offset-8"><a class="texto">Fecha <?php echo date('d-m-Y'); ?></a></div>
        </div>

        <div class="block-content collapse in valor" id="resultado"> 

        </div>
    </div>

</div>



