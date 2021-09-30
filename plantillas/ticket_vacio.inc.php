<?php
include_once 'api/Redireccion.inc.php';
?>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Equipo o dispositivo</label>
            <input type="text" class="form-control " name="tipoe" placeholder="Computacion, audio, video, impresoras etc.">
        </div>
    </div>
    <div class="col-md-8">
        <div class="form-group">
            <label>Descripcion fallo </label>
            <textarea name="descrip" class="form-control" maxlength="200" id="areadescripcion" cols="50" rows="6" placeholder="Especifique en un maximo de 200 caracteres cual es el fallo del dispositivo"></textarea>
        </div>
    </div>
    <div class="card shadow mb-4">
        <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary text-gray-800">Informacion: </h6>
        </a>
        <div class="collapse show" id="collapseCardExample">
            <div class="card-body">
                <p>Señor usuario evite generar mas de una solicitud de un mismo equipo hasta que haya obtenido la visita
                    tecnica y posteriormente la solucion de su problema. Si quiere consultar, si la solucitud ya fue
                    resuelta ingrese al siguiente enlace</p>
                <a href="<?php echo RUTA_PROCESOS_TICKETS;  ?>" class="text-center"> Consultar estado ticket </a>
            </div>
        </div>
    </div>
</div>
<button type='submit' class="btn btn-default btn-success btn-icon-split" name="enviar_ticket">
    <span class="icon text-white-50">
        <i class="fa fa-paper-plane mr-2"></i>
    </span>
    <span class="text">Enviar solicitud</span>
</button>