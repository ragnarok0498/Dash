<?php

include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/ValidarTicket.inc.php';
include_once 'api/Tickets.inc.php';


$titulo = 'Generar Ticket';

include_once 'plantillas/declaracion_documento.inc.php';
include_once 'plantillas/sidebar.inc.php';
include_once 'plantillas/navbar.inc.php';

if (ControlSesion::sesion_iniciada_usuario()) {
    if (isset($_POST['enviar_ticket'])) {

        $validador = new ValidarTicket(
            $_POST['tipoe'],
            $_POST['descrip']
        );

        if ($validador->registro_valido_ticket()) {

            $ticket_insertado = Tickets::insertar_tickets($conexion);

            if ($ticket_insertado) {
                $_SESSION['alerta'] = "Se ha enviado su solicitud";
                $_SESSION['estado'] = "success";
            } else {
                $_SESSION['alerta'] = "fallo al enviar su solicitud";
                $_SESSION['estado'] = "warning";
            }
        }
    }
?>
 <div class="container-fluid">
        <?php
        if (isset($ticket_insertado)) {
        ?>
            <div class="col-md-8 mx-auto">
                <div class="card shadow mb-4">
                    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary text-gray-800">Solicitud enviada </h6>
                    </a>
                    <div class="collapse show" id="collapseCardExample">
                        <div class="card-body">
                            <div class="text-center">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_send.svg" alt="">
                            </div>
                            <?php

                            $sql_id = ("SELECT LAST_INSERT_ID() FROM solicitud WHERE activa = 0");
                            $sentencia = $conexion->prepare($sql_id);
                            $sentencia->execute();

                            $last_id = $sentencia->fetchColumn();


                            $sentencia = $conexion->prepare("SELECT * FROM solicitud WHERE id = :last_id");
                            $sentencia->bindParam(':last_id', $last_id);
                            $sentencia->execute();
                            $fila = $sentencia->fetch(PDO::FETCH_ASSOC);

                            if (count($fila) > 0) {

                                $id = $fila['id'];
                                $pin = $fila['pin'];
                            } else {
                                die('Conexion fallida');
                            }
                            $sql_id = null;
                            $sentencia = null;
                            ?>
                            <p> Para buscar el estado de su solicitud guarde el siguiente codigo, uselo tambien para buscar la respuesta a su solicitud: <strong><?php echo $pin;?></strong></p>
                            <p> Desea buscar el estado de su ticket haga click <a href="<?php echo RUTA_PROCESOS_TICKETS;  ?>">&larr; en el enlace</a> </p>
                            <p> Si ya realizo la solicitud, vuelva al <a href="<?php echo SERVIDOR;  ?>">&larr; Dashboard</a> </p>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
                <i class="fas fa-ticket-alt mr-3"></i>Generar nuevo ticket
                </h1>
            </div>
            <p class="lead text-muted">Para solicitar una visita tecnica complete todo el formulario</p>
            <div class="row">
                <section>
                    <div class="container ubicacion ">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-title text-center mb-4">
                                            <h4><b> Completa el formulario</b></h4>
                                        </div>
                                    </div>
                                    <div class="panel-body text-justify">
                                        <form role="form" method="POST">

                                            <?php
                                            if (isset($_POST['enviar_ticket'])) {
                                                include_once 'plantillas/ticket_validado.inc.php';
                                            } else {
                                                include_once 'plantillas/ticket_vacio.inc.php';
                                            }
                                            ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        <?php
        }
        ?>

    </div>
  
<?php
} else {
    include_once 'plantillas/error.inc.php';
}
include_once 'plantillas/cierre_contenido.inc.php';
include_once 'plantillas/footer_modal.inc.php';
include_once 'plantillas/declaracion_cierre.inc.php';
?>