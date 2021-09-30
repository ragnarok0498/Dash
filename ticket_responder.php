<?php
include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/Tickets.inc.php';
include_once 'api/Equipos.inc.php';

if (!ControlSesion::sesion_iniciada_tecnico()) {
    Redireccion::redirigir(SERVIDOR);
}
$mensaje = '';
if (isset($_GET['id'])) {

    $solicitud_ticket = Tickets::obtener_ticket_responder($conexion);

    if (count($solicitud_ticket) > 0) {
        $fila = $solicitud_ticket;

        $id =  $fila['id'];
        $usuario =  $fila['nombre_user'];
        $equipo_t =  $fila['tipoe'];
        $descripcion_f = $fila['descrip'];
        $datatime = $fila['horafecha'];
    } else {
        die('Conexion fallida');
    }
} else {
    $mensaje = "<br><div class='alert alert-danger text-md-center' role='alert'>
    <i class='fas fa-exclamation-triangle'></i> No se obtuvo los datos de la solicitud
  </div>";
}

if (isset($_POST['send_ticket'])) {

    if (!empty($_POST['id_solicitud']) && !empty($_POST['equipo_mac']) && !empty($_POST['repuestos_e']) && !empty($_POST['descripcion_r'])) {
        $respuesta = Tickets::respuesta_ticket_($conexion);

        if ($respuesta) {

            $status_soli = Tickets::modificar_activo($conexion);
            $status_notify = Tickets::modificar_notificacion($conexion);
            $status_equipo = Equipos::modificar_estado($conexion);

            $_SESSION['alerta'] = "Registro de la respuesta a la solicitud completa";
            $_SESSION['estado'] = "success";
        } else {
            $mensaje = "<br><div class='alert alert-danger text-md-center' role='alert'>
                                <i class='fas fa-exclamation-triangle'></i> No se enviaron los datos.
                                </div>";
        }
    } else {
        $mensaje = "<br><div class='alert alert-warning text-md-center' role='alert'>
                            <i class='fas fa-exclamation-triangle'></i> Debe completar el formulario 
                            </div>";
    }
}

include_once 'plantillas/declaracion_documento.inc.php';
include_once 'plantillas/sidebar.inc.php';
include_once 'plantillas/navbar.inc.php';
?>

<?php
if (isset($respuesta)) {
?>
    <div class="container-fluid">
        <div class="col-md-8 mx-auto">
            <div class="card shadow mb-4">
                <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary text-gray-800">Respuesta enviada </h6>
                </a>
                <div class="collapse show" id="collapseCardExample">
                    <div class="card-body">
                        <div class="text-center">
                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_send.svg" alt="">
                        </div>

                        <?php

                        $sql_id = ("SELECT LAST_INSERT_ID() FROM respuesta WHERE activa = 1");
                        $sentencia = $conexion->prepare($sql_id);
                        $sentencia->execute();

                        $last_id = $sentencia->fetchColumn();

                        $sql_id = null;
                        $sentencia = null;
                        ?>

                        <p> Para buscar los detalles de la respuesta guarde el siguiente codigo: <strong> <?php echo $last_id  ?> </strong>.</p>
                        <p> Si ya actualizo los datos, vuelva a su <a href="<?php echo RUTA_ACTIVIDAD_TECNICOS;  ?>">&larr; Perfil </a> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Solicitud de mantenimiento</h1>
                        </div>

                        <p>
                        <h6>Tecnico(@) recuerde antes de responder un ticket valide el registro del equipo a manipular haga
                            click en el siguiente enlace para realizar la busqueda.
                            <a href="<?php echo RUTA_EQUIPOS_DISPOSITIVOS; ?>">equipos o dispositivos </a>
                        </h6>
                        </p>
                    </div>
                    <div class="panel-body">

                        <h4><b class=" text-gray-800 m-0 font-weight-bold text-primary">Datos del ticket</b></h4>
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Nombre funcionario</label>
                                    <input type="text" class="form-control " name="id_usuario" readonly="readonly" value="<?php echo $usuario; ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Equipo o dispositivo </label>
                                    <input type="text" class="form-control " name="equipo_repair" readonly="readonly" value="<?php echo $equipo_t; ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label> Fecha solicitud </label>
                                    <input type="text" class="form-control " name="date_solicitud" readonly="readonly" value="<?php echo $datatime; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Descripcion fallo </label>
                                    <textarea class="form-control" maxlength="200" cols="50" rows="6" readonly="readonly" name="fallo_equipo"><?php echo $descripcion_f; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <h4><b class=" text-gray-800 m-0 font-weight-bold text-primary">Formulario de mantenimiento</b></h4>
                        <br>


                        <form role="form" method="POST">
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Solicitud</label>
                                        <input type="text" class="form-control " name="id_solicitud" readonly="readonly" value="<?php echo $id; ?>">
                                    </div>
                                </div>
                                <?php
                                $resultado = Equipos::mostrar_macs($conexion);
                                ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Equipos registrados</label>
                                        <select class="form-control" id="forsecretarias" name="equipo_mac">
                                            <?php
                                            foreach ($resultado as $macs) {
                                            ?>
                                                <option value="<?php echo $macs['id']; ?>">
                                                    <?php echo $macs['id'] . ') Mac '  . $macs['mac']; ?></option>

                                                <?php echo $macs['id']; ?>
                                                <?php echo $macs['tipo']; ?>
                                                <?php echo $macs['marca']; ?>
                                                <?php echo $macs['mac']; ?>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Repuestos o novedades </label>
                                        <input type="text" class="form-control " name="repuestos_e" placeholder="Ingrese los repuestos incluidos" required autofocus>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Descripcion del arreglo </label>
                                        <textarea class="form-control" maxlength="200" cols="50" rows="6" name="descripcion_r" placeholder="Describa max 200 caracteres la solucion al fallo del equipo" required autofocus></textarea>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type='submit' class="btn btn-default btn-success btn-icon-split text-center" name="send_ticket">
                                        <span class="icon text-white-50">
                                            <i class="fa fa-paper-plane"></i>
                                        </span>
                                        <span class="text">Enviar</span>
                                    </button>
                                    <br>
                                    <?php
                                    if (!empty($mensaje)) {
                                        echo $mensaje;
                                    }
                                    ?>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<?php
include_once 'plantillas/cierre_contenido.inc.php';
include_once 'plantillas/footer_modal.inc.php';
include_once 'plantillas/declaracion_cierre.inc.php';

?>