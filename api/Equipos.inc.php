<?php

include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';

class Equipos
{

    public static function insertar_equipo($conexion)
    {
        $equipo_insertado = false;

        if (isset($conexion)) {

            try {

                $sentencia = $conexion->prepare("INSERT INTO equipos(tipo, marca, caracteristicas, especificaciones, mac, activo) VALUES (:tipo, :marca, :caracteristicas, :especificaciones, :mac, 0)");

                $sentencia->bindParam(':tipo', $_POST['tipo']);
                $sentencia->bindParam(':marca', $_POST['marca']);
                $sentencia->bindParam(':caracteristicas', $_POST['caracte']);
                $sentencia->bindParam(':especificaciones', $_POST['especi']);
                $sentencia->bindParam(':mac', $_POST['mac']);

                $equipo_insertado = $sentencia->execute();
            } catch (PDOException $ex) {
                print 'ERROR' . $ex->getMessage();
            }
        }
        $sentencia = null;
        return $equipo_insertado;
    }


    public static function obtener_equipo_nuevo($conexion)
    {
        $resultado = null;
        if (isset($conexion)) {

            try {

                $sql = "SELECT * FROM equipos";
                $sentencia = $conexion->prepare($sql);
                $sentencia->execute();

                $resultado = $sentencia->fetchall(PDO::FETCH_ASSOC);

                $sql = null;
                $sentencia = null;
            } catch (PDOException $ex) {
                print 'ERROR' . $ex->getMessage();
            }
        }

        return $resultado;
    }

    public static function modificar_estado($conexion)
    {
        $mod_estado = null;
        if (isset($conexion)) {

            try {


                $sql = "UPDATE equipos SET activo = 1  WHERE id = :id";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':id', $_POST['equipo_mac'], PDO::PARAM_STR);


                $sentencia->execute();

                $sentencia = null; 
                $sql = null;
            } catch (PDOException $ex) {
                print 'ERROR' . $ex->getMessage();
            }
        }

        return $mod_estado;
    }
    public static function actualizar_equipo($conexion)
    {

        $actualizar_equipo = null;
        if (isset($conexion)) {

            try {

                $id = $_GET['id'];
                $tipo = $_POST['tipo'];
                $marca = $_POST['marca'];
                $caracte = $_POST['caracte'];
                $especi = $_POST['especi'];
                $mac = $_POST['mac'];



                $sql = "UPDATE equipos SET tipo = :tipo, marca = :marca, caracteristicas = :caracteristicas, especificaciones = :especificaciones, mac = :mac WHERE id = :id AND mac = :mac";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':id', $id, PDO::PARAM_STR);
                $sentencia->bindParam(':tipo', $tipo, PDO::PARAM_STR);
                $sentencia->bindParam(':marca', $marca, PDO::PARAM_STR);
                $sentencia->bindParam(':caracteristicas', $caracte, PDO::PARAM_STR);
                $sentencia->bindParam(':especificaciones', $especi, PDO::PARAM_STR);
                $sentencia->bindParam(':mac', $mac, PDO::PARAM_STR);

                $sentencia->execute();

                $sentencia = null;
                $sql = null;
            } catch (PDOException $ex) {
                print 'ERROR' . $ex->getMessage();
            }
        }

        return $actualizar_equipo;
    }

    public static function mac_registro($conexion)
    {

        $mac_resultado = null;

        if (isset($conexion)) {

            try {

                $busqueda = $_POST['mac'];

                $sql = "SELECT * FROM equipos WHERE mac = :mac";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':mac', $busqueda);
                $sentencia->execute();
                $mac_resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $ex) {
                print 'ERROR' . $ex->getMessage();
            }
        }
        return $mac_resultado;
    }


    public static function mac_existe($conexion)
    {
        $mac_regis = null;

        if (isset($conexion)) {

            try {

                $busqueda = $_GET['id_mac'];

                $sql = "SELECT * FROM equipos WHERE mac = :mac";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':mac', $busqueda);
                $sentencia->execute();
                $mac_regis = $sentencia->fetch(PDO::FETCH_ASSOC);

            } catch (PDOException $ex) {
                print 'Error: ' . $ex->getMessage();
            }
        }
        $sql = null;
        $sentencia = null;
        return $mac_regis;
    }


    public static function mostrar_macs($conexion)
    {

        $resultado = null;

        if (isset($conexion)) {

            try {
                $sentencia = $conexion->prepare('SELECT id, mac FROM equipos');
                $sentencia->execute();

                $resultado = $sentencia->fetchall(PDO::FETCH_ASSOC);

                $sentencia = null;
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }
        $sentencia = null;
        return $resultado;
    }

    public static function filtrar_equipos($conexion)
    {

        $datos = null;
        if (isset($conexion)) {

            try {

                $busqueda = $_GET['id'];
                $sql = "SELECT *, te.nombre, eq.tipo, us.nombre_user, us.oficina FROM respuesta re INNER JOIN tecnicos te ON re.autor_id = te.id INNER JOIN equipos eq ON re.maquina_id = eq.id INNER JOIN solicitud so ON re.soli_id = so.id INNER JOIN usuarios us ON so.autor_soli = us.id WHERE re.maquina_id = :maquina_id";
                
                $sentencia = $conexion->prepare($sql);
                $sentencia->execute(array('maquina_id' => $busqueda));

                $datos = $sentencia->fetchAll(PDO::FETCH_OBJ);

                $sql = null;
                $sentencia = null;
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
            }
        }
        return $datos;
    }


    public static function eliminar_equipo_historico($conexion)
    {
        if (isset($conexion)) {

            try {
                $conexion->beginTransaction();

                $sql2 = "DELETE FROM respuesta WHERE maquina_id = :maquina_id";
                $sentencia2 = $conexion->prepare($sql2);
                $sentencia2->bindParam(':maquina_id', $_POST['id_borrar'], PDO::PARAM_STR);
                $sentencia2->execute();

                $sql1 = "DELETE FROM equipos WHERE id = :id";
                $sentencia1 = $conexion->prepare($sql1);
                $sentencia1->bindParam(':id', $_POST['id_borrar'], PDO::PARAM_STR);
                $sentencia1->execute();

                $conexion->commit();
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
                $conexion->rollback();
            }
        }
    }
}
