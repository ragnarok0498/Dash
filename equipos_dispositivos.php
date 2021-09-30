<?php
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/Equipos.inc.php';

$titulo = 'Equipos o dispositivos';

include_once 'plantillas/declaracion_documento.inc.php';
include_once 'plantillas/sidebar.inc.php';
include_once 'plantillas/navbar.inc.php';

if (ControlSesion::sesion_iniciada_tecnico()) {
    $mensaje = '';
    if (isset($_GET['send_mac'])) {

        if (!empty($_GET['id_mac'])) {

            $mac_regis = Equipos::mac_existe($conexion);

            if (!empty($mac_regis)) {

                $id = $mac_regis['id'];

                $_SESSION['alerta'] = "La mac se encuentra registrada, por favor continue.";
                $_SESSION['estado'] = "success";
            } else {
                $_SESSION['alerta'] = "La mac ingresada no se encuentra.";
                $_SESSION['estado'] = "warning";
            }
        } else {
            $_SESSION['alerta'] = "Debe ingresar un Numero mac para realizar la busqueda.";
            $_SESSION['estado'] = "info";
        }
    }
?>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h4><b class="text-gray-800 m-0 font-weight-bold text-primary">Equipos o dispositivos</b></h4>
            <form role="form" method="GET">
                <div class="input-group mb-5 col-md-12">
                    <input type="text" name="id_mac" class="form-control bg-light small" placeholder="Ingrese MAC para  validar" aria-label="Buscar" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" name="send_mac">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <p class="mb-4">Debe verificar si el equipo de la solicitud que desea responder este registrado, en caso contrario
            procesa con su registro.</p>
        <?php
        if (!empty($mac_regis)) {
        ?>
            <div class="alert alert-success text-md-center" role="alert">
                <i class="fas fa-check-circle"></i> La mac se encuentra registrada, con la ID: <strong> <?php echo $id; ?>
                </strong> memoricela
                para continuar con la respuesta de la <a href="<?php echo RUTA_PROCESOS_TICKETS; ?>"> solicitud</a>
            </div>
        <?php
        }
        ?>
        <a class="d-none d-sm-inline-block btn btn-sm btn-primary btn-icon-split shadow-sm" data-toggle="modal" data-target="#RegistroEquiposModal">
            <span class="icon text-white-50">
                <i class="fa fa-search-plus"></i>
            </span>
            <span class="text"> Registrar nuevo equipo o dispositivo</span>
        </a>
        <a href=" <?php echo RUTA_EQUIPOS_DISPOSITIVOS; ?>" class="d-none d-sm-inline-block btn btn-sm btn-success btn-icon-split shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-sync-alt"></i>
            </span>
            <span class="text">Recargar tabla. </span>
        </a> <br>
        <?php
        $resultado = Equipos::obtener_equipo_nuevo($conexion);
        ?><br>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class=" text-gray-800 m-0 font-weight-bold text-primary">Registros</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>TIPO</th>
                                <th>MARCA</th>
                                <th>CARACTERISTICAS</th>
                                <th>ESPECIFICACIONES</th>
                                <th>MAC</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($resultado)) {
                                foreach ($resultado as $filas) {
                            ?>
                                    <tr>
                                        <td> <?php echo $filas['id']; ?></td>
                                        <td> <?php echo $filas['tipo']; ?></td>
                                        <td> <?php echo $filas['marca']; ?></td>
                                        <td> <?php echo $filas['caracteristicas']; ?></td>
                                        <td> <?php echo $filas['especificaciones']; ?></td>
                                        <td> <?php echo $filas['mac']; ?></td>
                                        <td>
                                            <a href="<?php echo RUTA_EQUIPOS_EDITAR . $filas['id']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary btn-icon-split shadow-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text"> Editar </span>
                                            </a>
                                            <a href="<?php echo RUTA_EQUIPOS_HISTORIAL . $filas['id']; ?>" class="d-none d-sm-inline-block btn btn-sm btn-success btn-btn-icon-split shadow-sm">
                                                <span class="icon text-text-white-50">
                                                    <i class="fa fa-server mr-2"></i>
                                                </span>
                                                <span class="text"> historial </span>
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                $_SESSION['alerta'] = "No hay equipos registrados en el sistema.";
                                $_SESSION['estado'] = "info";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>TIPO</th>
                                <th>MARCA</th>
                                <th>CARACTERISTICAS</th>
                                <th>ESPECIFICACIONES</th>
                                <th>MAC</th>
                                <th>OPCIONES</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    if (ControlSesion::sesion_iniciada_admin()) {
        $resultado = Equipos::obtener_equipo_nuevo($conexion);
    ?>
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Opciones equipos o dispositivos</h1>
            </div>
            <a class="d-none d-sm-inline-block btn btn-sm btn-primary btn-icon-split shadow-sm" data-toggle="modal" data-target="#RegistroEquiposModal">
                <span class="icon text-white-50">
                    <i class="fa fa-search-plus"></i>
                </span>
                <span class="text"> Registrar nuevo equipo o dispositivo </span>
            </a>
            <a href=" <?php echo RUTA_EQUIPOS_DISPOSITIVOS; ?>" class="d-none d-sm-inline-block btn-icon-split btn btn-sm btn-success shadow-sm">
                <span class="icon text-white-50">
                    <i class="fas fa-sync-alt"></i>
                </span>
                <span class="text">Recargar tabla </span>
            </a> <br><br>
            <?php
            if (isset($_SESSION['return_ms'])) {
            ?>
                <div class="col-md-5 alert alert-danger alert-dismissible fade show border-left-0" role="alert">
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
                    <h6 class=" text-gray-800 m-0 font-weight-bold text-primary">Registros</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>TIPO</th>
                                    <th>MARCA</th>
                                    <th>CARACTERISTICAS</th>
                                    <th>ESPECIFICACIONES</th>
                                    <th>MAC</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($resultado)) {
                                    foreach ($resultado as $filas) {
                                ?>
                                        <tr>
                                            <td> <?php echo $filas['id']; ?></td>
                                            <td> <?php echo $filas['tipo']; ?></td>
                                            <td> <?php echo $filas['marca']; ?></td>
                                            <td> <?php echo $filas['caracteristicas']; ?></td>
                                            <td> <?php echo $filas['especificaciones']; ?></td>
                                            <td> <?php echo $filas['mac']; ?></td>
                                            <td>
                                                <a href="<?php echo RUTA_EQUIPOS_EDITAR . $filas['id']; ?>" class="d-none d-sm-inline-block btn-icon-split btn btn-sm btn-primary shadow-sm">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                    <span class="text">Editar</span>
                                                </a>
                                                <form method="post" action="<?php echo RUTA_EQUIPOS_BORRAR; ?>">
                                                    <input type="hidden" name="id_borrar" value="<?php echo $filas['id']; ?>">
                                                    <button type="submit" name="borrar_proceso" class="d-none d-sm-inline-block btn btn-sm btn-icon-split btn-danger shadow-sm">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-trash"></i>
                                                        </span>
                                                        <span class="text">Eliminar </span>
                                                    </button>
                                                </form>
                                                <a href="<?php echo RUTA_EQUIPOS_HISTORIAL . $filas['id']; ?>" class="d-none d-sm-inline-block btn-icon-split btn btn-sm btn-success shadow-sm">
                                                    <span class="icon text-white-50">
                                                        <i class="fa fa-server"></i>
                                                    </span>
                                                    <span class="text"> historial </span>
                                                </a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    $_SESSION['alerta'] = "No hay equipos registrados en el sistema.";
                                    $_SESSION['estado'] = "info";
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>TIPO</th>
                                    <th>MARCA</th>
                                    <th>CARACTERISTICAS</th>
                                    <th>ESPECIFICACIONES</th>
                                    <th>MAC</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </tfoot>
                        </table>
                        <a href="<?php ?>" class="d-none d-sm-inline-block btn btn-sm btn-info btn-icon-split shadow-sm">
                            <span class="icon text-white-50">
                                <i class="fas fa-download"></i>
                            </span>
                            <span class="text">Descargar registros </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        include_once 'plantillas/error.inc.php';
    }
}
?>
<?php
include_once 'plantillas/cierre_contenido.inc.php';
include_once 'plantillas/footer_modal.inc.php';
include_once 'plantillas/declaracion_cierre.inc.php';
?>
