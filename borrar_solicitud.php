<?php

include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/Tickets.inc.php';

if (ControlSesion::sesion_iniciada_admin()) {
    if (isset($_POST['borrar_proceso'])) {
        $id_ticket = $_POST['id_borrar'];

        $borrado = Tickets::eliminar_ticket_y_respuesta($conexion);


        $_SESSION['return_ms'] = "<i class='far fa-trash-alt mr-2'></i> Solicitud de mantenimiento eliminada: " . $id_ticket;


        Redireccion::redirigir(RUTA_PROCESOS_TICKETS);
    }
}
