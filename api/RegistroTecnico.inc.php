<?php

include_once 'api/Conexion.inc.php';

class RegistroTecnico
{

    public static function insertar_tecnico($conexion)
    {
        $tecnico_insertado = false;

        if (isset($conexion)) {

            try {

                $nombretec = $_POST['nombre_tec'];
                $apellidotec = $_POST['apellido_tec'];
                $emailtec = $_POST['email_tec'];
                $passwordtec = password_hash($_POST['password_tec'], PASSWORD_BCRYPT);

                $sql = "INSERT INTO tecnicos(nombre, apellido, email, password, fecha_registro, activo) VALUES (:nombre, :apellido, :email, :password, NOW(), 1)";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':nombre', $nombretec, PDO::PARAM_STR);
                $sentencia->bindParam(':apellido', $apellidotec, PDO::PARAM_STR);
                $sentencia->bindParam(':email', $emailtec, PDO::PARAM_STR);
                $sentencia->bindParam(':password', $passwordtec, PDO::PARAM_STR);

                $tecnico_insertado = $sentencia->execute();

                $sentencia = null;
                $sql = null;
            } catch (PDOException $ex) {
                print 'ERROR' . $ex->getMessage();
            }
        }
        return $tecnico_insertado;
    }

    public static function tecnico_existe($conexion)
    {
        $tecnico_existe = true;

        if (isset($conexion)) {

            try {

                $nombretec = $_POST['nombre_tec'];

                $sql = "SELECT * FROM tecnicos WHERE nombre = :nombre";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':nombre', $nombretec, PDO::PARAM_STR);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado)) {
                    $tecnico_existe = true;
                } else {
                    $tecnico_existe = false;
                }

                $sentencia = null;
                $sql = null;
            } catch (PDOException $ex) {
                print "Error" . $ex->getMessage();
            }
        }

        return $tecnico_existe;
    }

    public static function email_tecnico_existe($conexion)
    {
        $email_existe = true;

        if (isset($conexion)) {

            try {

                $emailtec = $_POST['email_tec'];

                $sql = "SELECT * FROM tecnicos WHERE email = :email";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':email', $emailtec, PDO::PARAM_STR);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado)) {
                    $email_existe = true;
                } else {
                    $email_existe = false;
                }

                $sentencia = null;
                $sql = null;
            } catch (PDOException $ex) {
                print "Error" . $ex->getMessage();
            }
        }

        return $email_existe;
    }



    public static function obtener_tecnico_por_email($conexion, $emailtec, $passtec)
    {
        $tecnico = null;

        if (isset($conexion)) {
            try {

                $sql = "SELECT * FROM tecnicos WHERE email = :email AND password = :clave";
                $sentencia = $conexion->prepare($sql);
                $sentencia->bindParam(':email', $emailtec, PDO::PARAM_STR);
                $sentencia->bindParam(':clave', $passtec, PDO::PARAM_STR);
                $sentencia->execute();

                $resultado = $sentencia->fetch();

                if (!empty($resultado)) {
                } else {
                }

                $sentencia = null;
                $sql = null;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
            }
        }

        return $tecnico;
    }


    public static function obtener_tecnicos($conexion)
    {

        $resultado = null;
        if (isset($conexion)) {

            try {

                $sql = "SELECT * FROM tecnicos";
                $sentencia = $conexion->prepare($sql);
                $sentencia->execute();
                $resultado = $sentencia->fetchall(PDO::FETCH_ASSOC);

                $sql = null;
                $sentencia = null;
            } catch (PDOException $ex) {
                print 'Error: ' . $ex->getMessage();
            }
        }

        return $resultado;
    }

    public static function actualizar_tecnico($conexion)
    {

        $update_tecnico = null;

        if (isset($conexion)) {
            try {

                $id = $_GET['id'];
                $nombre = $_POST['nombre_t'];
                $apellido = $_POST['apellido_t'];
                $email = $_POST['email_t'];
                $password = password_hash($_POST['password_t'], PASSWORD_BCRYPT);

                $sql = " UPDATE tecnicos SET nombre = :nombre, apellido = :apellido, email = :email, password = :password WHERE id = :id AND email = :email";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':id', $id, PDO::PARAM_STR);
                $sentencia->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $sentencia->bindParam(':apellido', $apellido, PDO::PARAM_STR);
                $sentencia->bindParam(':email', $email, PDO::PARAM_STR);
                $sentencia->bindParam(':password', $password, PDO::PARAM_STR);

                $sentencia->execute();

                $sentencia = null;
                $sql = null;
            } catch (PDOException $ex) {

                print 'Error: ' . $ex->getMessage();
            }
        }

        return $update_tecnico;
    }

    public static function desactivar_tecnico($conexion)
    {

        if (isset($conexion)) {

            try {

                $sql = " UPDATE tecnicos SET activo = 0 WHERE id = :id";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':id', $_POST['id_tec'], PDO::PARAM_STR);

                $sentencia->execute();

                $sentencia = null;
                $sql = null;
            } catch (PDOException $ex) {
                print 'Error: ' . $ex->getMessage();
            }
        }
    }

    public static function activar_tecnico($conexion)
    {

        if (isset($conexion)) {

            try {

                $sql = " UPDATE tecnicos SET activo = 1 WHERE id = :id";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':id', $_POST['id_tec'], PDO::PARAM_STR);

                $sentencia->execute();

                $sentencia = null;
                $sql = null;
            } catch (PDOException $ex) {
                print 'Error: ' . $ex->getMessage();
            }
        }
    }

    public static function eliminar_tecnico_historico($conexion)
    {

        if (isset($conexion)) {


            try {
                $conexion->beginTransaction();

                $sql1 = "DELETE FROM respuesta WHERE autor_id = :autor_id";
                $sentencia1 = $conexion->prepare($sql1);
                $sentencia1->bindParam(':autor_id', $_POST['id_tec'], PDO::PARAM_STR);
                $sentencia1->execute();


                $sql3 = "DELETE FROM tecnicos WHERE id = :id";
                $sentencia3 = $conexion->prepare($sql3);
                $sentencia3->bindParam(':id', $_POST['id_tec'], PDO::PARAM_STR);
                $sentencia3->execute();

                $conexion->commit();

                $sentencia1 = null;
                $sql1 = null;
                $sentencia3 = null;
                $sql3 = null;
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
                $conexion->rollback();
            }
        }
    }
}
