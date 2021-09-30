<?php

include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/RegistroTecnico.inc.php';



if (ControlSesion::sesion_iniciada_admin()) {
    if (isset($_POST['desactivar_tec'])) {
        $id_tec = $_POST['id_tec'];

        RegistroTecnico::desactivar_tecnico($conexion);
        $_SESSION['return_ms'] = "<i class='fas fa-times-circle mr-2'></i> Usuario desactivado: " . $id_tec;

        Redireccion::redirigir(RUTA_PANEL_TECNICOS);
    } else {
        if (isset($_POST['activar_tec'])) {
            $id_tec = $_POST['id_tec'];

            RegistroTecnico::activar_tecnico($conexion);
            $_SESSION['return_ms'] = "<i class='fas fa-check-circle mr-2'></i> Usuario activado: " . $id_tec;
            Redireccion::redirigir(RUTA_PANEL_TECNICOS);
        }
    }
}
