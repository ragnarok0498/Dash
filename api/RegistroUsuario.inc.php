<?php

include_once 'api/Conexion.inc.php';

class RegistroUsuario
{

    public static function insertar_usuario($conexion)
    {
        $usuario_insertado = false;

        if (isset($conexion)) {

            try {

                $nombreuser = $_POST['nombre_user'];
                $apellidouser = $_POST['apellido_user'];
                $secretaria = $_POST['secretaria_user'];
                $oficina = $_POST['oficina_user'];
                $emailuser = $_POST['email_user'];
                $passworduser = password_hash($_POST['password_user'], PASSWORD_BCRYPT);

                $sql = "INSERT INTO usuarios(nombre_user, apellido_user, secretaria, oficina, email_user, password, datatime, activo) VALUES (:nombre, :apellido, :secretaria, :oficina, :email, :password, NOW(), 1)";

                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':nombre', $nombreuser, PDO::PARAM_STR);
                $sentencia->bindParam(':apellido', $apellidouser, PDO::PARAM_STR);
                $sentencia->bindParam(':secretaria', $secretaria, PDO::PARAM_STR);
                $sentencia->bindParam(':oficina', $oficina, PDO::PARAM_STR);
                $sentencia->bindParam(':email', $emailuser, PDO::PARAM_STR);
                $sentencia->bindParam(':password', $passworduser, PDO::PARAM_STR);

                $usuario_insertado = $sentencia->execute();
            } catch (PDOException $ex) {
                print 'ERROR' . $ex->getMessage();
            }
        }
        return $usuario_insertado;
    }

    public static function usuario_existe($conexion)
    {
        $usuario_existe = true;

        if (isset($conexion)) {

            try {

                $nombreuser = $_POST['nombre'];

                $sql = "SELECT * FROM usuarios WHERE nombre_user = :nombre";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':nombre', $nombreuser, PDO::PARAM_STR);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado)) {
                    $usuario_existe = true;
                } else {
                    $usuario_existe = false;
                }
            } catch (PDOException $ex) {
                print "Error" . $ex->getMessage();
            }
        }

        return $usuario_existe;
    }

    public static function email_usuario_existe($conexion)
    {
        $email_existe = true;

        if (isset($conexion)) {

            try {

                $emailuser = $_POST['email_user'];

                $sql = "SELECT * FROM usuarios WHERE email_user = :email";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':email', $emailuser, PDO::PARAM_STR);
                $sentencia->execute();
                $resultado = $sentencia->fetchAll();

                if (count($resultado)) {
                    $email_existe = true;
                } else {
                    $email_existe = false;
                }
            } catch (PDOException $ex) {
                print "Error" . $ex->getMessage();
            }
        }

        return $email_existe;
    }

    public static function obtener_usuarios($conexion)
    {

        $resultado = null;
        if (isset($conexion)) {

            try {

                $sql = "SELECT * FROM usuarios";
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

    public static function actualizar_usuario($conexion)
    {

        $update_usuario = null;

        if (isset($conexion)) {
            try {

                $id = $_GET['id'];
                $nombre = $_POST['nombre_u'];
                $apellido = $_POST['apellido_u'];
                $secretaria = $_POST['secretaria'];
                $oficina = $_POST['oficina'];
                $email = $_POST['email_u'];
                $password = password_hash($_POST['password_u'], PASSWORD_BCRYPT);

                $sql = " UPDATE usuarios SET nombre_user = :nombre, apellido_user = :apellido, secretaria = :secretaria, oficina = :oficina, email_user = :email, password = :password WHERE id = :id AND email_user = :email";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':id', $id, PDO::PARAM_STR);
                $sentencia->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $sentencia->bindParam(':apellido', $apellido, PDO::PARAM_STR);
                $sentencia->bindParam(':secretaria', $secretaria, PDO::PARAM_STR);
                $sentencia->bindParam(':oficina', $oficina, PDO::PARAM_STR);
                $sentencia->bindParam(':email', $email, PDO::PARAM_STR);
                $sentencia->bindParam(':password', $password, PDO::PARAM_STR);

                $sentencia->execute();

                $sentencia = null;
                $sql = null;
            } catch (PDOException $ex) {

                print 'Error: ' . $ex->getMessage();
            }
        }

        return $update_usuario;
    }

    public static function desactivar_usuario($conexion)
    {

        if (isset($conexion)) {

            try {

                $sql = " UPDATE usuarios SET activo = 0 WHERE id = :id";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':id', $_POST['id_user'], PDO::PARAM_STR);

                $sentencia->execute();

                $sentencia = null;
                $sql = null;
            } catch (PDOException $ex) {
                print 'Error: ' . $ex->getMessage();
            }
        }
    }

    public static function activar_usuario($conexion)
    {

        if (isset($conexion)) {

            try {

                $sql = " UPDATE usuarios SET activo = 1 WHERE id = :id";
                $sentencia = $conexion->prepare($sql);

                $sentencia->bindParam(':id', $_POST['id_user'], PDO::PARAM_STR);

                $sentencia->execute();

                $sentencia = null; 
                $sql = null;
            } catch (PDOException $ex) {
                print 'Error: ' . $ex->getMessage();
            }
        }
    }

    public static function eliminar_usuario_historico($conexion)
    {
        if (isset($conexion)) {

            try {
                $conexion->beginTransaction();
                
                /*
                $sql1 = "DELETE FROM respuesta re INNER JOIN solicitud so ON re.soli_id = so.id WHERE so.autor_soli = :autor_soli";
                $sentencia1 = $conexion->prepare($sql1);
                $sentencia1 ->bindParam(':autor_soli', $_POST['id_user'], PDO::PARAM_STR);
                $sentencia1 ->execute();
*/
                $sql2 = "DELETE FROM solicitud WHERE autor_soli = :autor_soli";
                $sentencia2 = $conexion->prepare($sql2);
                $sentencia2->bindParam(':autor_soli', $_POST['id_user'], PDO::PARAM_STR);
                $sentencia2->execute();

                $sql3 = "DELETE FROM usuarios WHERE id = :id";
                $sentencia3 = $conexion->prepare($sql3);
                $sentencia3->bindParam(':id', $_POST['id_user'], PDO::PARAM_STR);
                $sentencia3->execute();

                $conexion->commit();
            } catch (PDOException $ex) {
                print 'ERROR: ' . $ex->getMessage();
                $conexion->rollback();
            }
        }
    }
}
