<?php
include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/Equipos.inc.php';

include_once 'plantillas/declaracion_documento.inc.php';
include_once 'plantillas/sidebar.inc.php';
include_once 'plantillas/navbar.inc.php';

if (ControlSesion::sesion_iniciada_tecnico() || ControlSesion::sesion_iniciada_admin()) {
    $mensaje = '';

    if (isset($_GET['id'])) {

        $sentencia = $conexion->prepare("SELECT * FROM equipos WHERE id = :id");
        $sentencia->bindParam(':id', $_GET['id']);

        $sentencia->execute();
        $equipo_editado = $sentencia->fetch(PDO::FETCH_ASSOC);

        if (count($equipo_editado) > 0) {

            $fila = $equipo_editado;

            $tipo = $fila['tipo'];
            $marca  = $fila['marca'];
            $caracte = $fila['caracteristicas'];
            $especifi = $fila['especificaciones'];
            $mac  = $fila['mac'];
        } else {
            die('Conexion fallida');
        }
    } else {
        $_SESSION['alerta'] = "No se actuvo los datos del registro";
        $_SESSION['estado'] = "info";
    }

    if (isset($_POST['update_registro_equipo'])) {

        if (!empty($_POST['tipo']) && !empty($_POST['marca']) && !empty($_POST['mac']) && !empty($_POST['caracte'] && !empty($_POST['especi']))) {

            Equipos::actualizar_equipo($conexion);

            $_SESSION['alerta'] = "Equipo actualizado";
            $_SESSION['estado'] = "success";
        } else {

            $_SESSION['alerta'] = "Error al actualizar el registro";
            $_SESSION['estado'] = "warning";
        }
    }


    $sentencia = null;



?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <div class="card card-header">
                    <h6 class="m-0 font-weight-bold text-primary text-gray-800 text-center">Modificar equipo o dispositivo registrado</h6>
                </div>
                <div class="card card-body">
                    <form action="<?php echo RUTA_EQUIPOS_EDITAR . $_GET['id']; ?>" method="post">
                        <div class="form-group">
                            <label>Tipo de equipo o dispositivo</label>
                            <input type="text" class="form-control " name="tipo" placeholder="Computacion, audio, video, impresoras etc." required value="<?php echo $tipo ?>">
                        </div>
                        <div class="form-group">
                            <label>Marca del equipo o dispositivo</label>
                            <input type="text" class="form-control " name="marca" placeholder="Marca fabricante del equipo o dispositivo" required value="<?php echo $marca ?>">
                        </div>
                        <div class="form-group">
                            <label>Caracteristicas del equipo o dispositivo</label>
                            <input type="text" class="form-control " name="caracte" placeholder="Caracteristicas del equipo" required value="<?php echo $caracte ?>">
                        </div>

                        <div class="form-group">
                            <label>Especificaciones del equipo o dispositivo</label>
                            <textarea class="form-control" maxlength="255" cols="50" rows="6" name="especi" placeholder="Especificaciones del equipo, maximo 255 caracteres" required><?php echo $especifi ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Numero MAC</label>
                            <input type="text" class="form-control" name="mac" readonly="readonly" placeholder="Numero identificacion MAC" required value="<?php echo $mac ?>">
                        </div>
                        <button class="btn btn-success" name="update_registro_equipo">
                            <i class="fa fa-paper-plane mr-2"></i> Actualizar registro
                        </button>
                    </form>
                </div>
                <div class="card-footer">
                    <?php
                    if (!empty($mensaje)) {
                        echo $mensaje;
                    }
                    ?>
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
                            <p> Señor usuario despues de realizar la modificacion de registro y de recibir la confirmacion por una alerta.</p>
                            <p> vuelva al <a href="<?php echo RUTA_EQUIPOS_DISPOSITIVOS;  ?>">&larr; menu de equipos o dispositivos</a> </p>
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