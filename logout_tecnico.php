<?php 

include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/config.inc.php';

ControlSesion:: cerrar_sesion_tecnico();
Redireccion:: redirigir(SERVIDOR);