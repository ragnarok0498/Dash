<?php

include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/Tickets.inc.php';

if (ControlSesion::sesion_iniciada_admin()) {
    if (isset($_POST['borrar_proceso_end'])) {
        $id_ticket = $_POST['id_borrar_end'];

        $borrado = Tickets::eliminar_respuesta($conexion);

        if ($borrado) {
            $_SESSION['return_ms'] = "<i class='far fa-trash-alt mr-2'></i> Respuesta de mantenimiento eliminada: " . $id_ticket;
        } else {
            $_SESSION['return_ms'] = "<i class='far fa-trash-alt mr-2'></i> Respuesta de mantenimiento no eliminada: " . $id_ticket;
        }

        Redireccion::redirigir(RUTA_TICKETS_FINALIZADOS);
    }
}
