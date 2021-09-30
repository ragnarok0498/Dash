<?php

include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';

class Contador
{


    public static function count_tecnicos($conexion)
    {

        $n_tecnicos = null;
        if (isset($conexion)) {

            try {
                $sentencia = $conexion->prepare("SELECT * FROM tecnicos");
                $sentencia->execute();
                $n_tecnicos = $sentencia->fetchAll();

                $sentencia = null;
            } catch (PDOException $ex) {
                print 'Error: ' . $ex->getMessage();
            }
        }

        return $n_tecnicos;
    }

    public static function count_usuarios($conexion)
    {
        $n_usuarios = null;
        if (isset($conexion)) {

            try {

                $sentencia = $conexion->prepare("SELECT * FROM usuarios");
                $sentencia->execute();
                $n_usuarios = $sentencia->fetchAll();

                $sentencia = null;
            } catch (PDOException $ex) {
                print 'Error: ' . $ex->getMessage();
            }
        }
        return $n_usuarios;
    }

    public static function count_equipos($conexion)
    {
        $n_equipos = null;
        if (isset($conexion)) {

            try {

                $sentencia = $conexion->prepare("SELECT * FROM equipos");
                $sentencia->execute();
                $n_equipos = $sentencia->fetchAll();

                $sentencia = null;
            } catch (PDOException $ex) {
                print 'Error: ' . $ex->getMessage();
            }
        }
        return $n_equipos;
    }

    public static function count_tickets_proceso($conexion)
    {
        $n_t_proceso = null;
        if (isset($conexion)) {

            try {

                $sentencia = $conexion->prepare("SELECT * FROM solicitud WHERE activa=0");
                $sentencia->execute();
                $n_t_proceso = $sentencia->fetchAll();

                $sentencia = null;
            } catch (PDOException $ex) {
                print 'Error: ' . $ex->getMessage();
            }
        }

        return $n_t_proceso;
    }

    public static function count_tickets_end($conexion)
    {
        $n_t_end = null;
        if (isset($conexion)) {

            try {

                $sentencia = $conexion->prepare("SELECT * FROM respuesta");
                $sentencia->execute();
                $n_t_end = $sentencia->fetchAll();

                $sentencia = null;
            } catch (PDOException $ex) {
                print 'Error: ' . $ex->getMessage();
            }
        }
        return $n_t_end;
    }

    public static function insertar_administrador($conexion)
    {

        if (isset($conexion)) {

            try {
            } catch (PDOException $ex) {
                print 'Error: ' . $ex->getMessage();
            }
        }
    }
}
