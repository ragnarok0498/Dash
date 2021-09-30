<?php

include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/RegistroTecnico.inc.php';

if (ControlSesion::sesion_iniciada_admin()) {
    if (isset($_POST['borrar_tecnico'])) {
        $id_ticket = $_POST['id_tec'];

        $borrado = RegistroTecnico::eliminar_tecnico_historico($conexion);

        $_SESSION['return_ms'] = "<i class='fas fa-user-slash mr-2'></i> Tecnico eliminado: " . $id_ticket;
        Redireccion::redirigir(RUTA_PANEL_TECNICOS);
    }
}