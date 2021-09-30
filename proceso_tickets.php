<?php
include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Tickets.inc.php';
include_once 'api/Redireccion.inc.php';

$titulo = 'Tickets en proceso';

include_once 'plantillas/declaracion_documento.inc.php';
include_once 'plantillas/sidebar.inc.php';
include_once 'plantillas/navbar.inc.php';
?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            <i class="fas fa-clipboard-list mr-3"></i>Tickets sin responder
        </h1>
    </div>

    <?php
    if (ControlSesion::sesion_iniciada_usuario()) {
        $mensaje = '';
        if (isset($_GET['search_ticket'])) {

            if (!empty($_GET['pin_ticket'])) {

                $filas = Tickets::search_ticket_proceso($conexion);

                if (count($filas)) {
                } else {
                    $_SESSION['alerta'] = "No existe ningun registro con el codigo ingresado.";
                    $_SESSION['estado'] = "info";
                }
            } else {
                $_SESSION['alerta'] = "Debe ingresar el codigo de la solicitud.";
                $_SESSION['estado'] = "error";
            }
        }
    ?>

        <div class="row">
            <section>
                <div class="container ubicacion ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title text-center mb-3">
                                       <h3> <strong> Buscar solicitud. </strong> </h3>
                                    </div>
                                </div>
                                <div class="panel-body text-justify">
                                    <div class="row">
                                        <p>Señor usuario para realizar la busqueda digite el codigo
                                            generado cuando finalizo su solicitud</p>
                                        <div class="col-md-2">
                                            <img class="img-fluid px-3 px-sm-4 mt-3" style="width: 25rem;" src="img/undraw_busqueda.svg" alt="">
                                        </div>
                                    </div>
                                    <form method="GET" role="form">
                                        <div class="input-group mb-5 col-md-4">
                                            <input type="text" name="pin_ticket" class="form-control bg-light small" placeholder="Codigo registro" aria-label="Buscar" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit" name="search_ticket">
                                                    <i class="fas fa-search fa-sm"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <br>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class=" text-gray-800 m-0 font-weight-bold text-primary"> Informacion del ticket buscado</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>AUTOR SOLICITUD</th>
                                <th>TIPO DE EQUIPO O DISPOSITIVO</th>
                                <th>DESCRIPCION</th>
                                <th>FECHA</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($filas)) {
                                foreach ($filas as $resul) {
                            ?>
                                    <tr>
                                        <td><?php echo $resul->id; ?></td>
                                        <td><?php echo $resul->nombre_user; ?></td>
                                        <td><?php echo $resul->tipoe; ?></td>
                                        <td><?php echo $resul->descrip; ?></td>
                                        <td><?php echo $resul->horafecha; ?></td>
                                        <td>
                                            <?php
                                            $sql3 = "SELECT * FROM solicitud WHERE pin = :pin AND autor_soli = :autor_soli AND activa = 1";
                                            $sentencia = $conexion->prepare($sql3);
                                            $resultado = $sentencia->execute(array('pin' => $_GET['pin_ticket'], 'autor_soli' => $_SESSION['id_user']));
                                            $dato = $sentencia->fetchAll(PDO::FETCH_OBJ);
                                            if (count($dato) > 0) {
                                            ?>
                                                <a class="btn  btn-success btn-circle btn-sm">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a class="btn btn-secondary  btn-sm ">
                                                    <i class="fas fa-exclamation-triangle mr-2"></i>Espera
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    if (!empty($dato)) {
                        if (count($dato) > 0) {
                    ?>
                            <a class="btn  btn-success btn-circle btn-sm">
                                <i class="fas fa-check"></i>
                            </a>
                            <strong> Su solicitud ya fue contestada</strong>
                    <?php
                        }
                    }
                    ?>
                    <br>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <?php
            if (!empty($dato)) {
            ?>
                <p>
                    Para mayor informacion de su ticket contestado haga click en el siguiente <a href="<?php echo RUTA_TICKETS_FINALIZADOS; ?>">enlace</a> y digite el codigo de su ticket
                    <strong> <?php echo $_GET['pin_ticket']; ?> </strong>
                </p>
            <?php
            }
            ?>
        </div>
        <?php
    } else {
        if (ControlSesion::sesion_iniciada_tecnico()) {
            $sql1 = "SELECT so.id, so.autor_soli, so.tipoe, so.descrip, so.horafecha, us.nombre_user, us.oficina FROM solicitud so INNER JOIN usuarios us ON so.autor_soli = us.id WHERE so.activa=0";
            $sentencia = $conexion->prepare($sql1);
            $sentencia->execute();
            $resultado = $sentencia->fetchall(PDO::FETCH_ASSOC);
        ?>
            <br>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="text-gray-800 m-0 font-weight-bold text-primary">Los registros en proceso se visualizaran en esta
                        tabla</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>AUTOR SOLICITUD</th>
                                    <th>OFICINA</th>
                                    <th>TIPO DE EQUIPO O DISPOSITIVO</th>
                                    <th>DESCRIPCION</th>
                                    <th>FECHA</th>
                                    <th>OPCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($resultado as $filas) {
                                ?>
                                    <tr>
                                        <td><?php echo $filas['id']; ?></td>
                                        <td><?php echo $filas['nombre_user']; ?></td>
                                        <td><?php echo $filas['oficina']; ?></td>
                                        <td><?php echo $filas['tipoe']; ?></td>
                                        <td><?php echo $filas['descrip']; ?></td>
                                        <td><?php echo $filas['horafecha']; ?></td>
                                        <td>
                                            <a href="<?php echo RUTA_TICKET_RESPONDER . $filas['id'];  ?>" class="d-none d-sm-inline-block btn btn-sm btn-success btn-icon-split shadow-sm mb-5">
                                                <span class="icon text-white-50">
                                                    <i class="fa fa-paper-plane"></i>
                                                </span>
                                                <span class="text">Responder</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <?php
                                if (!empty($resultado)) {
                                ?>
                                    <tr>
                                        <th>ID</th>
                                        <th>AUTOR SOLICITUD</th>
                                        <th>OFICINA</th>
                                        <th>TIPO DE EQUIPO O DISPOSITIVO</th>
                                        <th>DESCRIPCION</th>
                                        <th>FECHA</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                <?php
                                } else {
                                    $_SESSION['alerta'] = "No hay solicitudes pendientes en el sistema.";
                                    $_SESSION['estado'] = "success";
                                }
                                ?>

                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <?php
        } else {
            if (ControlSesion::sesion_iniciada_admin()) {

                $sql = "SELECT so.id, so.autor_soli, so.tipoe, so.descrip, so.horafecha, us.nombre_user, us.oficina FROM solicitud so INNER JOIN usuarios us ON so.autor_soli = us.id WHERE so.activa=0";
                $sentencia = $conexion->prepare($sql);
                $sentencia->execute();
                $resultado = $sentencia->fetchall(PDO::FETCH_ASSOC);
            ?>
                <br>
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
                        <h6 class="text-gray-800 m-0 font-weight-bold text-primary">Los registros en proceso se visualizaran en esta
                            tabla</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-condensed text-center" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>AUTOR SOLICITUD</th>
                                        <th>OFICINA</th>
                                        <th>TIPO DE EQUIPO O DISPOSITIVO</th>
                                        <th>DESCRIPCION</th>
                                        <th>FECHA</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($resultado as $filas) {
                                    ?>
                                        <tr>
                                            <td><?php echo $filas['id']; ?></td>
                                            <td><?php echo $filas['nombre_user']; ?></td>
                                            <td><?php echo $filas['oficina']; ?></td>
                                            <td><?php echo $filas['tipoe']; ?></td>
                                            <td><?php echo $filas['descrip']; ?></td>
                                            <td><?php echo $filas['horafecha']; ?></td>
                                            <td>
                                                <form method="post" action="<?php echo RUTA_PROCESOS_BORRAR; ?>">
                                                    <input type="hidden" name="id_borrar" value="<?php echo $filas['id']; ?>">
                                                    <button type="submit" name="borrar_proceso" class="d-none d-sm-inline-block btn btn-sm btn-icon-split btn-danger shadow-sm">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-trash"></i>
                                                        </span>
                                                        <span class="text">Eliminar </span>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <?php
                                    if (!empty($resultado)) {
                                    ?>
                                        <tr>
                                            <th>ID</th>
                                            <th>AUTOR SOLICITUD</th>
                                            <th>OFICINA</th>
                                            <th>TIPO DE EQUIPO O DISPOSITIVO</th>
                                            <th>DESCRIPCION</th>
                                            <th>FECHA</th>
                                            <th>OPCIONES</th>
                                        </tr>
                                    <?php
                                    } else {
                                        $_SESSION['alerta'] = "No hay solicitudes pendientes en el sistema.";
                                        $_SESSION['estado'] = "success";
                                    }
                                    ?>

                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
    <?php
            } else {
                include_once 'plantillas/error.inc.php';
            }
        }
    }
    ?>
</div>
<?php
include_once 'plantillas/cierre_contenido.inc.php';
include_once 'plantillas/footer_modal.inc.php';
include_once 'plantillas/declaracion_cierre.inc.php';
?>