<?php
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Tickets.inc.php';

$titulo = 'Tickets Finalizados';

include_once 'plantillas/declaracion_documento.inc.php';
include_once 'plantillas/sidebar.inc.php';
include_once 'plantillas/navbar.inc.php';

?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
            <i class="fas fa-clipboard-check mr-3"></i>Tickets finalizados
        </h1>
    </div>
    <?php
    if (ControlSesion::sesion_iniciada_usuario()) {
        if (isset($_GET['search_end'])) {

            if (!empty($_GET['pin_end'])) {

                $result = Tickets::search_ticket_end($conexion);

                if (count($result)) {
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
                                    <div class="panel-title text-center mb-4">
                                        <h4><b>Procesos terminados</b></h4>
                                    </div>
                                </div>
                                <div class="panel-body text-justify">
                                    <div class="row">
                                        <br>
                                        <p> Señor usuario, para realizar la busqueda ingrese el codigo del ticket generado cuando realizo la solicitud</p>
                                        <br>
                                    </div>
                                    <form method="GET" role="form">
                                        <div class="input-group mb-5 col-md-4">
                                            <input type="text" name="pin_end" class="form-control bg-light small" placeholder="Codigo registro" aria-label="Buscar" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit" name="search_end">
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
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class=" text-gray-800 m-0 font-weight-bold text-primary">Informacion del mantenimiento realizado a su solicitud</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>TECNICO ENCARGADO</th>
                                <th>TIPO DE EQUIPO O DISPOSITIVO</th>
                                <th>NOVEDADES O REPUESTOS</th>
                                <th>DESCRIPCION</th>
                                <th>FECHA</th>
                                <th>OPCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($result)) {
                                foreach ($result as $filas) {
                            ?>
                                    <tr>
                                        <td><?php echo $filas->nombre; ?></td>
                                        <td><?php echo $filas->tipo; ?></td>
                                        <td><?php echo $filas->repuestos; ?></td>
                                        <td><?php echo $filas->descripcion; ?></td>
                                        <td><?php echo $filas->fecha; ?></td>
                                        <td>
                                            <a href="javascripit:void(0)" onclick="mostrarDetalles('<?php echo $filas->id; ?>')" class="d-none d-sm-inline-block btn btn-sm btn-success btn-icon-split shadow-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                                <span class="text"> Ver + </span>
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    } else {
        if (ControlSesion::sesion_iniciada_tecnico()) {
        ?>
            <?php
            $sql = "SELECT * FROM respuesta re INNER JOIN equipos eq ON re.maquina_id = eq.id INNER JOIN solicitud so ON re.soli_id = so.id INNER JOIN usuarios us ON so.autor_soli = us.id ORDER BY re.fecha DESC";
            $sentencia = $conexion->prepare($sql);
            $sentencia->execute();

            $resultado = $sentencia->fetchall(PDO::FETCH_ASSOC);
            ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class=" text-gray-800 m-0 font-weight-bold text-primary">Tickets resueltos</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>CODIGO SOLICITUD</th>
                                    <th>FUNCIONARIO</th>
                                    <th>TIPO DE EQUIPO O DISPOSITIVO</th>
                                    <th>FALLO</th>
                                    <th>DESCRIPCION</th>
                                    <th>FECHA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($resultado)) {
                                    foreach ($resultado as $filas) {
                                ?>
                                        <tr>
                                            <td><?php echo $filas['pin']; ?></td>
                                            <td><?php echo $filas['nombre_user']; ?></td>
                                            <td><?php echo $filas['tipo']; ?></td>
                                            <td><?php echo $filas['descrip']; ?></td>
                                            <td><?php echo $filas['descripcion']; ?></td>
                                            <td><?php echo $filas['fecha']; ?></td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    $_SESSION['alerta'] = "No hay registros de tickets finalizados en el sistema.";
                                    $_SESSION['estado'] = "info";
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>CODIGO SOLICITUD</th>
                                    <th>FUNCIONARIO</th>
                                    <th>TIPO DE EQUIPO O DISPOSITIVO</th>
                                    <th>FALLO</th>
                                    <th>DESCRIPCION</th>
                                    <th>FECHA</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <?php
        } else {
            if (ControlSesion::sesion_iniciada_admin()) {
            ?>
                <?php
                $sql = "SELECT * FROM respuesta re INNER JOIN tecnicos te ON re.autor_id = te.id INNER JOIN equipos eq ON re.maquina_id = eq.id INNER JOIN solicitud so ON re.soli_id = so.id INNER JOIN usuarios us ON so.autor_soli = us.id";
                $sentencia = $conexion->prepare($sql);
                $sentencia->execute();

                $resultado = $sentencia->fetchall(PDO::FETCH_ASSOC);

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
                        <h6 class=" text-gray-800 m-0 font-weight-bold text-primary">Datos solicitudes resueltas</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-condensed text-center" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>TECNICO ENCARGADO</th>
                                        <th>CODIGO SOLICITUD</th>
                                        <th>FUNCIONARIO</th>
                                        <th>FALLO</th>
                                        <th>TIPO DE EQUIPO O DISPOSITIVO</th>
                                        <th>NOVEDADES O REPUESTOS</th>
                                        <th>DESCRIPCION</th>
                                        <th>FECHA</th>
                                        <th>OPCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($resultado)) {
                                        foreach ($resultado as $filas) {
                                    ?>
                                            <tr>
                                                <td><?php echo $filas['id']; ?></td>
                                                <td><?php echo $filas['nombre']; ?></td>
                                                <td><?php echo $filas['pin']; ?></td>
                                                <td><?php echo $filas['nombre_user']; ?></td>
                                                <td><?php echo $filas['descrip']; ?></td>
                                                <td><?php echo $filas['tipo']; ?></td>
                                                <td><?php echo $filas['repuestos']; ?></td>
                                                <td><?php echo $filas['descripcion']; ?></td>
                                                <td><?php echo $filas['fecha']; ?></td>
                                                <td>
                                                    <form method="post" action="<?php echo RUTA_RESPUESTA_BORRAR; ?>">
                                                        <input type="hidden" name="id_borrar_end" value="<?php echo $filas['id']; ?>">
                                                        <button type="submit" name="borrar_proceso_end" class="d-none d-sm-inline-block btn btn-sm btn-icon-split btn-danger shadow-sm">
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
                                    } else {
                                        $_SESSION['alerta'] = "No hay registros de tickets finalizados en el sistema.";
                                        $_SESSION['estado'] = "info";
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>TECNICO ENCARGADO</th>
                                        <th>CODIGO SOLICITUD</th>
                                        <th>FUNCIONARIO</th>
                                        <th>FALLO</th>
                                        <th>TIPO DE EQUIPO O DISPOSITIVO</th>
                                        <th>NOVEDADES O REPUESTOS</th>
                                        <th>DESCRIPCION</th>
                                        <th>FECHA</th>
                                        <th>OPCIONES</th>
                                    </tr>
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
<div id="divModal"></div>
<script>
    function mostrarDetalles(id) {
        var ruta = 'plantillas/detalles_respuesta.inc.php?detalles=' + id;
        $.get(ruta, function(data) {
            $('#divModal').html(data);
            $('#informe_solicitud_respuesta').modal('show');
        });
    }
</script>

<?php
include_once 'plantillas/cierre_contenido.inc.php';
include_once 'plantillas/footer_modal.inc.php';
include_once 'plantillas/declaracion_cierre.inc.php';
?>