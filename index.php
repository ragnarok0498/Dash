<?php
include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';

$titulo = 'Dashboard';
include_once 'plantillas/declaracion_documento.inc.php';
include_once 'plantillas/sidebar.inc.php';
include_once 'plantillas/navbar.inc.php';
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Bienvenidos al aplicativo web</h1>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary text-gray-800 text-center">Notificacion</h6>
                </a>
                <div class="collapse show" id="collapseCardExample">
                    <div class="card-body">
                        <div class="text-center">
                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_resume.svg" alt="">
                        </div>
                        <p>Este aplicativo es para solicitar visitas tecnicas del area de sistema para los equipos o dispositivos
                            internos de la alcaldia municipal de tocaima es de uso exclusivo para funcionarios.</p>
                        <p class="mb-0">Si desea solicitar un ticket para el mantenimiento de un equipo o dispositivo dirigase
                            al apartado izquierdo en opciones de usuario click en control de sesion, si ya esta registrado inicie
                            de lo contrario registrece.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
        <div class="text-center">
            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/logo.png" alt="">
        </div>
        </div>
    </div>
</div>
<?php
include_once 'plantillas/cierre_contenido.inc.php';
include_once 'plantillas/footer_modal.inc.php';
include_once 'plantillas/declaracion_cierre.inc.php';
?>