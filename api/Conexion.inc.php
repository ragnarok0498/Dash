<?php

include_once 'config.inc.php';

try {
    $conexion = new PDO ('mysql:host=' . NOMBRE_SERVIDOR . '; dbname=' . NOMBRE_BD, NOMBRE_USUARIO, PASSWORD);
} catch (PDOException $ex) {
    die('Conexion fallida: '. $ex -> getMessage());
}