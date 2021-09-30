<?php

include_once 'config.inc.php';
include_once 'Conexion.inc.php';
include_once 'ControlSesion.inc.php';

class Tickets
{

    public static function insertar_tickets($conexion)
    {

        $ticket_insertado = false;

        if (isset($conexion)) {

            try {

                $sql = "INSERT INTO solicitud (autor_soli, tipoe, descrip, horafecha, activa) VALUES (:autor_soli, :tipoe, :descrip, NOW(), 0)";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam('autor_soli', $_SESSION['id_user'], PDO::PARAM_STR);
                $sentencia->bindParam('tipoe', $_POST['tipoe'], PDO::PARAM_STR);
                $sentencia->bindParam('descrip', $_POST['descrip'], PDO::PARAM_STR);

                $ticket_insertado =  $sentencia->execute();

                $id_ticket = $conexion->lastInsertId();
                $pin = "MTS" . $id_ticket;
                $sentencia = $conexion->prepare("UPDATE solicitud SET pin = :pin WHERE id = :id_ticket");
                $sentencia->bindParam(':pin', $pin, PDO::PARAM_STR);
                $sentencia->bindParam(':id_ticket', $id_ticket, PDO::PARAM_STR);

                $sentencia->execute();
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }

        return $ticket_insertado;
    }


    public static function search_ticket_proceso($conexion)
    {
        $filas = null;
        $resultado = null;

        if (isset($conexion)) {
            try {

                $busqueda = $_GET['pin_ticket'];
                $usuario = $_SESSION['id_user'];

                $sql1 ="SELECT so.id, so.pin, so.autor_soli, so.tipoe, so.descrip, so.horafecha, us.nombre_user FROM solicitud so INNER JOIN usuarios us ON so.autor_soli = us.id WHERE so.pin = :pin AND so.autor_soli = :autor_soli";
                $sentencia = $conexion->prepare($sql1);
                $resultado = $sentencia->execute(array('pin' => $busqueda, 'autor_soli' => $usuario));
                $filas = $sentencia->fetchAll(PDO::FETCH_OBJ);

                $sql1 = null;
                $sentencia = null;
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }
        return $filas;
        return $resultado;
    }

    public static function obtener_ticket_responder($conexion)
    {

        $solicitud_ticket = null;
        if (isset($conexion)) {

            try {

                $sentencia = $conexion->prepare("SELECT so.id, so.autor_soli, so.tipoe, so.descrip, so.horafecha, us.nombre_user FROM solicitud so INNER JOIN usuarios us ON so.autor_soli = us.id WHERE so.id = :so_id");
                $sentencia->bindParam(':so_id', $_GET['id']);

                $sentencia->execute();
                $solicitud_ticket = $sentencia->fetch(PDO::FETCH_ASSOC);

                $sentencia = null;
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }
        return $solicitud_ticket;
    }

    public static function search_ticket_end($conexion)
    {
        $resultado = null;
        $filas = null;

        if ($conexion) {

            try {

                $busqueda = $_GET['pin_end'];

                $sql = "SELECT re.id, re.autor_id, re.maquina_id, re.repuestos, re.descripcion, re.fecha, te.nombre, eq.tipo  FROM respuesta re 
                INNER JOIN tecnicos te ON re.autor_id = te.id 
                INNER JOIN equipos eq ON re.maquina_id = eq.id 
                INNER JOIN solicitud so ON re.soli_id = so.id 
                WHERE so.pin = :soli_id";
                $sentencia = $conexion->prepare($sql);

                $resultado = $sentencia->execute(array('soli_id' => $busqueda));

                $filas = $sentencia->fetchAll(PDO::FETCH_OBJ);

                $sql = null;
                $sentencia = null;
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }

        return $filas;
        return $resultado;
    }


    public static function respuesta_ticket_($conexion)
    {

        $ticket_resuelto = false;
        if (isset($conexion)) {

            try {


                $sql = "INSERT INTO  respuesta (autor_id, soli_id, maquina_id, repuestos, descripcion, fecha, activa) VALUES (:autor_id, :soli_id, :maquina_id, :repuestos, :descripcion, NOW(), 1)";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam('autor_id', $_SESSION['id_tec'], PDO::PARAM_STR);
                $sentencia->bindParam('soli_id', $_POST['id_solicitud'], PDO::PARAM_STR);
                $sentencia->bindParam('maquina_id', $_POST['equipo_mac'], PDO::PARAM_STR);
                $sentencia->bindParam('repuestos', $_POST['repuestos_e'], PDO::PARAM_STR);
                $sentencia->bindParam('descripcion', $_POST['descripcion_r'], PDO::PARAM_STR);


                $ticket_resuelto = $sentencia->execute();

                $sql = null;
                $sentencia = null;
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }
        return $ticket_resuelto;
    }

    public static function count_tickets_proceso($conexion)
    {

        $notify = null;
        if (isset($conexion)) {

            try {
                $sql = "SELECT * FROM solicitud WHERE notify = 0";
                $sentencia = $conexion->prepare($sql);
                $sentencia->execute();
                $notify = $sentencia->fetchAll();

                $sql = null;
                $sentencia = null;
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }

        return $notify;
    }

    public static function modificar_activo($conexion)
    {

        $estado = null;
        if (isset($conexion)) {

            try {

                $sql = "UPDATE solicitud SET activa = 1  WHERE id = :id";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id', $_POST['id_solicitud'], PDO::PARAM_STR);


                $sentencia->execute();

                $sentencia = null;
                $sql = null;
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }
        return $estado;
    }

    public static function modificar_notificacion($conexion)
    {

        $estado = null;
        if (isset($conexion)) {

            try {

                $sql = "UPDATE solicitud SET notify = 1  WHERE id = :id";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id', $_POST['id_solicitud'], PDO::PARAM_STR);


                $sentencia->execute();

                $sentencia = null;
                $sql = null;
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }
        return $estado;
    }

    public static function filtro_ticket_tecnico($conexion)
    {

        $resultado = false;
        $filtro_tecnico = false;
        if (isset($conexion)) {

            try {

                $busqueda = $_SESSION['id_tec'];

                $sql = "SELECT * FROM respuesta re INNER JOIN equipos eq ON re.maquina_id = eq.id INNER JOIN solicitud so ON re.soli_id = so.id INNER JOIN usuarios us ON so.autor_soli = us.id WHERE re.autor_id = :autor_id ORDER BY re.fecha DESC";
                $sentencia = $conexion->prepare($sql);

                $resultado = $sentencia->execute(array('autor_id' => $busqueda));

                $filtro_tecnico = $sentencia->fetchAll(PDO::FETCH_OBJ);

                $sql = null;
                $sentencia = null;
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }
        return $filtro_tecnico;
        return $resultado;
    }

    public static function eliminar_ticket_y_respuesta($conexion)
    {

        if (isset($conexion)) {


            try {
                $conexion->beginTransaction();

                $sql1 = "DELETE FROM respuesta WHERE soli_id = :soli_id";
                $sentencia1 = $conexion->prepare($sql1);
                $sentencia1 ->bindParam(':soli_id', $_POST['id_borrar'], PDO::PARAM_STR);
                $sentencia1 ->execute();

                $sql2 = "DELETE FROM solicitud WHERE id = :id";
                $sentencia2 = $conexion->prepare($sql2);
                $sentencia2 ->bindParam(':id', $_POST['id_borrar'], PDO::PARAM_STR);
                $sentencia2->execute();

                $conexion->commit();
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
                $conexion->rollback();
            }
        }
    }

    public static function eliminar_respuesta($conexion)
    {

        if (isset($conexion)) {

            try {

                $sql = "DELETE FROM respuesta WHERE id = :id";
                $sentencia = $conexion->prepare($sql);
                $sentencia ->bindParam(':id', $_POST['id_borrar_end'], PDO::PARAM_STR);
                $sentencia->execute();

            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }
    }
}
