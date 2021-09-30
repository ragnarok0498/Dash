<?php
include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/RegistroUsuario.inc.php';

include_once 'plantillas/declaracion_documento.inc.php';
include_once 'plantillas/sidebar.inc.php';
include_once 'plantillas/navbar.inc.php';

if (ControlSesion::sesion_iniciada_admin()) {
    if (isset($_GET['id'])) {

        $sentencia = $conexion->prepare("SELECT * FROM usuarios WHERE id = :id");
        $sentencia->bindParam(':id', $_GET['id']);

        $sentencia->execute();
        $user = $sentencia->fetch(PDO::FETCH_ASSOC);

        if (count($user) > 0) {

            $nombre = $user['nombre_user'];
            $apellido = $user['apellido_user'];
            $secretaria = $user['secretaria'];
            $oficina = $user['oficina'];
            $email = $user['email_user'];
            $fecha_registro = $user['datatime'];
            $activo = $user['activo'];
        } else {
            die('Conexion fallida');
        }
    } else {
        $_SESSION['alerta'] = "No se obtuvo los datos del registro";
        $_SESSION['estado'] = "info";
    }


    if (isset($_POST['update_registro_user'])) {

        if (
            !empty($_POST['nombre_u']) && !empty($_POST['apellido_u']) && !empty($_POST['secretaria']) && !empty($_POST['oficina']) && !empty($_POST['email_u']) &&
            !empty($_POST['password_u']) && !empty($_POST['password1_u']) && !empty($_POST['fecha_registro_u']) &&
            !empty($_POST['password_admin'])
        ) {
            if ($_POST['password_u'] == $_POST['password1_u']) {

                $stn = $conexion->prepare('SELECT * FROM admin  WHERE email = :email');
                $stn->bindParam(':email', $_SESSION['email_admin']);
                $stn->execute();

                $datos = $stn->fetch(PDO::FETCH_ASSOC);

                $stn = null;
                if ($datos) {
                    if (count($datos) > 0 && password_verify($_POST['password_admin'], $datos['password'])) {
                        $usuario_actualizado = RegistroUsuario::actualizar_usuario($conexion);

                        $_SESSION['alerta'] = "Actualizacion registro completa";
                        $_SESSION['estado'] = "success";
                    } else {

                        $_SESSION['alerta'] = "Contraseña administrador incorrecta.";
                        $_SESSION['estado'] = "info";
                    }
                }
            } else {
                $_SESSION['alerta'] = "Las contraseñas nueva no coinciden.";
                $_SESSION['estado'] = "info";
            }
        } else {
            $_SESSION['alerta'] = "Debe completar todos los campos del formulario";
            $_SESSION['estado'] = "warning";
        }
    }


?>
    <?php
    if (isset($usuario_actualizado)) {
    ?>
        <div class="container-fluid">
            <div class="col-md-8 mx-auto">
                <div class="card shadow mb-4">
                    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary text-gray-800">Usuario actualizado </h6>
                    </a>
                    <div class="collapse show" id="collapseCardExample">
                        <div class="card-body">
                            <div class="text-center">
                                <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_send.svg" alt="">
                            </div>
                            <p> Se ha guardo las modificaciones al registro correctamente, <?php  ?> .</p>
                            <p> Regresa al menu <a href="<?php echo RUTA_ADMINISTRADOR;  ?>">&larr; administrador</a> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 mx-auto">
                    <div class="card card-header">
                        <h6 class="m-0 font-weight-bold text-primary text-gray-800 text-center">Editar perfil de funcionario</h6>
                    </div>
                    <div class="card card-body">
                        <form action="<?php echo RUTA_USUARIO_EDITAR . $_GET['id']; ?>" method="post">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control " name="nombre_u" placeholder="Nombre usuario" readonly="readonly" value="<?php echo $nombre ?>">
                            </div>
                            <div class="form-group">
                                <label>Apellido</label>
                                <input type="text" class="form-control " name="apellido_u" placeholder="Apellido usuario" readonly="readonly" value="<?php echo $apellido ?>">
                            </div>
                            <div class="form-group">
                                <label>Secretaria</label>
                                <input type="text" class="form-control " name="secretaria" placeholder="Secretaria usuario" readonly="readonly" required value="<?php echo $secretaria ?>">
                            </div>
                            <div class="form-group">
                                <label>Oficina</label>
                                <input type="text" class="form-control " name="oficina" placeholder="Apellido usuario" value="<?php echo $oficina ?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control " name="email_u" placeholder="Correo electronico usuario" readonly="readonly" required value="<?php echo $email ?>">
                            </div>
                            <div class="form-group">
                                <label>Nueva contraseña</label>
                                <input type="password" class="form-control " name="password_u" placeholder="Ingrese la nueva contraseña">
                            </div>
                            <div class="form-group">
                                <label>Confirmar contraseña</label>
                                <input type="password" class="form-control " name="password1_u" placeholder="Confirme la nueva contraseña">
                            </div>
                            <div class="form-group">
                                <label>fecha registro</label>
                                <input type="text" class="form-control " name="fecha_registro_u" placeholder="Fecha registro usuario" readonly="readonly" required value="<?php echo $fecha_registro ?>">
                            </div>
                            <div class="form-group">
                                <label>Ingrese contraseña administrado</label>
                                <input type="password" class="form-control " name="password_admin" placeholder="Debe ingresar la contraseña del administrador">
                            </div>
                            <button class="btn btn-success" name="update_registro_user">
                                <i class="fa fa-paper-plane mr-2"></i> Actualizar registro
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow mb-4">
                        <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                            <h6 class="m-0 font-weight-bold text-primary text-gray-800">Informacion: </h6>
                        </a>
                        <div class="collapse show" id="collapseCardExample">
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_profile_settings.svg" alt="">
                                </div>
                                <p> Para enviar la actualizacion del perfil ingrese la contraseña del administrador del sistema al final del formulario.</p>
                                <p> Si ya actualizo los datos, vuelva al <br><a href="<?php echo RUTA_PANEL_USUARIOS;  ?>">&larr; panel opciones de usuario</a> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
}else {
    include_once 'plantillas/error.inc.php';
}
include_once 'plantillas/cierre_contenido.inc.php';
include_once 'plantillas/footer_modal.inc.php';
include_once 'plantillas/declaracion_cierre.inc.php';
?>