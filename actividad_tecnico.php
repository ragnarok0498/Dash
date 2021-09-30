<?php
include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Tickets.inc.php';

$titulo = 'Actividad tecnico';

include_once 'plantillas/declaracion_documento.inc.php';
include_once 'plantillas/sidebar.inc.php';
include_once 'plantillas/navbar.inc.php';


if (ControlSesion::sesion_iniciada_tecnico()) {
?>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold"> Perfil </h1>
            <hr class="sidebar-divider">
        </div>
        <div class="row">
            <section>
                <div class="container ubicacion ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="row">
                                    <div class="panel-heading col-lg-6">
                                        <div class="panel-title mb-4">
                                            <h4><b> Datos personales</b></h4>
                                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_personal.svg" alt="">
                                            <hr class="sidebar-divider">
                                        </div>
                                    </div>
                                    <div class="panel-body col-lg-6"><br><br>
                                        <P><b>Nombre: </b> <?php echo ' ' . $_SESSION['nombre_tec'];    ?></P>
                                        <P><b>Apellido: </b> <?php echo ' ' . $_SESSION['apellido_tec']; ?></P>
                                        <P><b>Correo: </b> <?php echo ' ' . $_SESSION['email_tec']; ?></P>
                                        <P><b>Fecha Registro: </b> <?php echo ' ' . $_SESSION['fecha_registro_tec'];  ?></P>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <br>
        <div class="row">
            <section>
                <div class="container ubicacion ">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title text-center mb-4">
                                        <h4><b> Tickest resueltos</b></h4>
                                        <hr class="sidebar-divider">
                                    </div>
                                </div>
                                <div class="panel-body text-justify">
                                    <div class="row">


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <br>
        <p class="mb-4">Historial de los mantenimientos realizados por: <?php echo ' ' . $_SESSION['nombre_tec'];    ?></p>
        <?php
        $filtro_tecnico = Tickets::filtro_ticket_tecnico($conexion);
        ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class=" text-gray-800 m-0 font-weight-bold text-primary">Tickets</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>AUTOR SOLICITUD</th>
                                <th>TIPO DE EQUIPO O DISPOSITIVO</th>
                                <th>CARACTERISTICAS</th>
                                <th>FALLO</th>
                                <th>NOVEDADES O REPUESTOS</th>
                                <th>DESCRIPCION</th>
                                <th>FECHA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($filtro_tecnico)) {
                                foreach ($filtro_tecnico as $resul) {
                            ?>
                                    <tr>
                                        <td><?php echo $resul->nombre_user; ?></td>
                                        <td><?php echo $resul->tipo; ?></td>
                                        <td><?php echo $resul->caracteristicas; ?></td>
                                        <td><?php echo $resul->descrip; ?></td>
                                        <td><?php echo $resul->repuestos; ?></td>
                                        <td><?php echo $resul->descripcion; ?></td>
                                        <td><?php echo $resul->fecha; ?></td>
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
    </div>
    <div id="divModal"></div>
    <script>
        function mostrarDetallesTecnico(id) {
            var ruta = 'plantillas/detalles_tecnico.inc.php?detalles=' + id;
            $.get(ruta, function(data) {
                $('#divModal').html(data);
                $('#informe_completo_tecnico').modal('show');
            });
        }
    </script>
<?php
} else {
    include_once 'plantillas/error.inc.php';
}
include_once 'plantillas/cierre_contenido.inc.php';
include_once 'plantillas/footer_modal.inc.php';
include_once 'plantillas/declaracion_cierre.inc.php';
?>