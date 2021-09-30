<?php
include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/Equipos.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';


$titulo = 'Historial mantenimientos';

include_once 'plantillas/declaracion_documento.inc.php';
include_once 'plantillas/sidebar.inc.php';
include_once 'plantillas/navbar.inc.php';

if (ControlSesion::sesion_iniciada_tecnico() || ControlSesion::sesion_iniciada_admin()) {
?>
    <div class="container-fluid">
        <?php
        
        $datos = Equipos::filtrar_equipos($conexion);

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

            $sentencia = null;
        } else {
            $_SESSION['alerta'] = "No se actuvo los datos del registro";
            $_SESSION['estado'] = "info";
        }
        ?>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="row">
                    <div class="panel-heading col-lg-6">
                        <div class="panel-title mb-4">
                            <h4><b> Datos del equipo</b></h4>
                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_devices.svg" alt="">
                            <hr class="sidebar-divider">
                        </div>
                    </div>
                    <div class="panel-body col-lg-6"><br><br>
                        <P><b>Tipo: </b> <?php echo ' ' . $tipo;    ?></P>
                        <P><b>Marca: </b> <?php echo ' ' . $marca; ?></P>
                        <P><b>Caracteristicas: </b> <?php echo ' ' . $caracte; ?></P>
                        <P><b>Especificaciones: </b> <?php echo ' ' . $especifi;  ?></P>
                        <P><b>MAC: </b> <?php echo ' ' . $mac;  ?></P>
                    </div>
                </div>
            </div>
        </div>


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class=" text-gray-800 m-0 font-weight-bold text-primary"> Historial mantenimientos realizados en el equipo</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed text-center" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>TIPO DE EQUIPO O DISPOSITIVO</th>
                                <th>TECNICO ENCARGADO</th>
                                <th>AUTOR SOLICITUD</th>
                                <th>OFICINA</th>
                                <th>NOVEDADES O REPUESTOS</th>
                                <th>DESCRIPCION</th>
                                <th>FECHA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($datos)) {
                                foreach ($datos as $filas) {
                            ?>
                                    <tr>
                                        <td><?php echo $filas->tipo; ?></td>
                                        <td><?php echo $filas->nombre; ?></td>
                                        <td><?php echo $filas->nombre_user; ?></td>
                                        <td><?php echo $filas->oficina; ?></td>
                                        <td><?php echo $filas->repuestos; ?></td>
                                        <td><?php echo $filas->descripcion; ?></td>
                                        <td><?php echo $filas->fecha; ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                $_SESSION['alerta'] = "Este equipo no tiene registros realizados.";
                                $_SESSION['estado'] = "info";
                            }
                            ?>
                        </tbody>
                    </table>
                    <br>
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