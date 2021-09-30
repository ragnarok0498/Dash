<?php
include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/Equipos.inc.php';

if (ControlSesion::sesion_iniciada_admin()) {
    if (isset($_POST['borrar_proceso'])) {
        $id_ticket = $_POST['id_borrar'];

        $borrado = Equipos::eliminar_equipo_historico($conexion);

        $_SESSION['return_ms'] = "<i class='far fa-trash-alt mr-2'></i> Se elimino el equipo o dispositivo: " . $id_ticket;

        Redireccion::redirigir(RUTA_EQUIPOS_DISPOSITIVOS);
    }
}
