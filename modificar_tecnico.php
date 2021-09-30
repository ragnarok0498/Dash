<?php
include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/RegistroTecnico.inc.php';


include_once 'plantillas/declaracion_documento.inc.php';
include_once 'plantillas/sidebar.inc.php';
include_once 'plantillas/navbar.inc.php';

if (ControlSesion::sesion_iniciada_admin()) {
    if (isset($_GET['id'])) {

        $sentencia = $conexion->prepare("SELECT * FROM tecnicos WHERE id = :id");
        $sentencia->bindParam(':id', $_GET['id']);

        $sentencia->execute();
        $tec = $sentencia->fetch(PDO::FETCH_ASSOC);

        if (count($tec) > 0) {

            $nombre = $tec['nombre'];
            $apellido = $tec['apellido'];
            $email = $tec['email'];
            $fecha_registro = $tec['fecha_registro'];
            $activo = $tec['activo'];
        } else {
            die('Conexion fallida');
        }
    } else {
        $_SESSION['alerta'] = "No se obtuvo los datos del registro";
        $_SESSION['estado'] = "info";
    }


    if (isset($_POST['update_registro'])) {

        if (
            !empty($_POST['nombre_t']) && !empty($_POST['apellido_t']) && !empty($_POST['email_t']) &&
            !empty($_POST['password_t']) && !empty($_POST['password1_t']) && !empty($_POST['fecha_registro_t']) &&
            !empty($_POST['password_admin'])
        ) {
            if ($_POST['password_t'] == $_POST['password1_t']) {

                $stn = $conexion->prepare('SELECT * FROM admin  WHERE email = :email');
                $stn->bindParam(':email', $_SESSION['email_admin']);
                $stn->execute();

                $datos = $stn->fetch(PDO::FETCH_ASSOC);

                $stn = null;
                if ($datos) {
                    if (count($datos) > 0 && password_verify($_POST['password_admin'], $datos['password'])) {
                        $tecnico_actualizado = RegistroTecnico::actualizar_tecnico($conexion);

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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <div class="card card-header">
                    <h6 class="m-0 font-weight-bold text-primary text-gray-800 text-center">Editar perfil de usuario tecnico</h6>
                </div>
                <div class="card card-body">
                    <form action="<?php echo RUTA_TECNICO_EDITAR . $_GET['id']; ?>" method="post">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" class="form-control " name="nombre_t" placeholder="Nombre tecnico" readonly="readonly" value="<?php echo $nombre ?>">
                        </div>
                        <div class="form-group">
                            <label>Apellido</label>
                            <input type="text" class="form-control " name="apellido_t" placeholder="Apellido tecnico" readonly="readonly" value="<?php echo $apellido ?>">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control " name="email_t" placeholder="Correo electronico tecnico" readonly="readonly" required value="<?php echo $email ?>">
                        </div>
                        <div class="form-group">
                            <label>Nueva contraseña</label>
                            <input type="password" class="form-control " name="password_t" placeholder="Ingrese la nueva contraseña">
                        </div>
                        <div class="form-group">
                            <label>Confirmar contraseña</label>
                            <input type="password" class="form-control " name="password1_t" placeholder="Confirme la nueva contraseña">
                        </div>
                        <div class="form-group">
                            <label>fecha registro</label>
                            <input type="text" class="form-control " name="fecha_registro_t" placeholder="Fecha registro tecnico" readonly="readonly" required value="<?php echo $fecha_registro ?>">
                        </div>
                        <div class="form-group">
                            <label>Ingrese contraseña administrador</label>
                            <input type="password" class="form-control " name="password_admin" placeholder="Debe ingresar la contraseña del administrador">
                        </div>
                        <button class="btn btn-success" name="update_registro">
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
                            <p> Para enviar la actualizacion del perfil usuario tecnico ingrese la contraseña del administrador del sistema al final del formulario.</p>
                            <p> Si ya actualizo los datos, vuelva al <br><a href="<?php echo RUTA_PANEL_TECNICOS;  ?>">&larr; panel opciones de tecnico</a> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
} else {
    include_once 'plantillas/error.inc.php';
}

include_once 'plantillas/cierre_contenido.inc.php';
include_once 'plantillas/footer_modal.inc.php';
include_once 'plantillas/declaracion_cierre.inc.php';
?>