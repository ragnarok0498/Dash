<?php
include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/Contador.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/RegistroUsuario.inc.php';

$titulo = 'Panel usuarios';

include_once 'plantillas/declaracion_documento.inc.php';
include_once 'plantillas/sidebar.inc.php';
include_once 'plantillas/navbar.inc.php';

if (ControlSesion::sesion_iniciada_admin()) {
   $resultado = RegistroUsuario::obtener_usuarios($conexion);
?>
    <div class="container-fluid">

        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h2><b class="text-gray-800 m-0 font-weight-bold text-primary">Opciones de usuario</b></h2>
            <a href="<?php echo RUTA_REGISTRO_USUARIO; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary btn-icon-split shadow-sm">
                <span class="icon text-white-50">
                    <i class="fas fa-user-plus mr-2"></i>
                </span>
                <span class="text"> Registrar usuario. </span>
            </a>
        </div>
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                    <h6 class="m-0 font-weight-bold text-primary text-gray-800"><i class="fas fa-info-circle mr-2"></i>Información: </h6>
                </a>
                <div class="collapse show" id="collapseCardExample">
                    <div class="card-body">
                        <p> Precaución: Evite eliminar cuentas que ya tengan un historial de registro para prevenir fallas en el sistema y borrar informacion importante, puede optar por desactivar la cuenta. </p>
                        <p> <strong>Estado 0 </strong> = Desactivado - <strong>Estado 1 </strong> = Activo</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if (isset($_SESSION['return_ms'])) {
        ?>
            <div class="col-md-3 alert alert-info alert-dismissible fade show border-left-0" role="alert">
                <strong><?php echo $_SESSION['return_ms']; ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php
            unset($_SESSION['return_ms']);
        }
        ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class=" text-gray-800 m-0 font-weight-bold text-primary">Datos de los funcionarios registrados</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                <th>APELLIDO</th>
                                <th>SECRETARIA</th>
                                <th>OFICINA</th>
                                <th>EMAIL</th>
                                <th>FECHA REGISTRO</th>
                                <th>ESTADO</th>
                                <th>OPCIONES</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($resultado)) {
                                foreach ($resultado as $user) {
                            ?>
                                    <tr>
                                        <td><?php echo $user['id']; ?></td>
                                        <td><?php echo $user['nombre_user']; ?></td>
                                        <td><?php echo $user['apellido_user']; ?></td>
                                        <td><?php echo $user['secretaria']; ?></td>
                                        <td><?php echo $user['oficina']; ?></td>
                                        <td><?php echo $user['email_user']; ?></td>
                                        <td><?php echo $user['datatime']; ?></td>
                                        <td><?php echo $user['activo']; ?></td>
                                        <td>
                                            <a href="<?php echo RUTA_USUARIO_EDITAR . $user['id']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                                <i class="fas fa-user-edit mr-2"></i>Editar
                                            </a>
                                            <form method="post" action="<?php echo RUTA_USUARIO_BORRAR; ?>">
                                                <input type="hidden" name="id_user" value="<?php echo $user['id']; ?>">
                                                <button type="submit" name="borrar_usuario" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form method="post" action="<?php echo RUTA_USUARIO_ESTADO; ?>">
                                                <input type="hidden" name="id_user" value="<?php echo $user['id']; ?>">
                                                <button type="submit" class="btn-circle btn-info btn-sm" name="desactivar_user">
                                                    <i class="fas fa-user-times"></i>
                                                </button>
                                                <button type="submit" class="btn-circle btn-success btn-sm" name="activar_user">
                                                    <i class="fas fa-user-check"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                $_SESSION['alerta'] = "No hay usuarios registrados en el sistema.";
                                $_SESSION['estado'] = "info";
                            }

                            ?>
                        </tbody>
                        <tfoot>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>APELLIDO</th>
                            <th>SECRETARIA</th>
                            <th>OFICINA</th>
                            <th>EMAIL</th>
                            <th>FECHA REGISTRO</th>
                            <th>ESTADO</th>
                            <th>OPCIONES</th>
                            <th></th>
                        </tfoot>
                    </table>
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