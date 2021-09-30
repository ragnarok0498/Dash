<?php

include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/RegistroUsuario.inc.php';

if (ControlSesion::sesion_iniciada_admin()) {
    if (isset($_POST['borrar_usuario'])) {
        $id_ticket = $_POST['id_user'];
      
        $borrado = RegistroUsuario::eliminar_usuario_historico($conexion);

        if(!empty($borrado)){
            $_SESSION['return_ms'] = "<i class='fas fa-user-slash mr-2'></i> Usuario eliminado: " . $id_ticket;
        }else{
            $_SESSION['return_ms'] = "<i class='fas fa-user-slash mr-2'></i> Usuario no eliminado: " . $id_ticket;
        }
        Redireccion::redirigir(RUTA_PANEL_USUARIOS);
    }
}
