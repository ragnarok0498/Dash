<?php

include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/RegistroUsuario.inc.php';


if (ControlSesion::sesion_iniciada_admin()) {
    if (isset($_POST['desactivar_user'])) {
        $id_tec = $_POST['id_user'];

        RegistroUsuario::desactivar_usuario($conexion);
        $_SESSION['return_ms'] = "<i class='fas fa-times-circle mr-2'></i> Usuario desactivado: " . $id_tec;
        Redireccion::redirigir(RUTA_PANEL_USUARIOS);
    } else {
        if (isset($_POST['activar_user'])) {
            $id_tec = $_POST['id_user'];

            RegistroUsuario::activar_usuario($conexion);
            $_SESSION['return_ms'] = "<i class='fas fa-check-circle mr-2'></i> Usuario activado: " . $id_tec;
            Redireccion::redirigir(RUTA_PANEL_USUARIOS);
        }
    }
}
