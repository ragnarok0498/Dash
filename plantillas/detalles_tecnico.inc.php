<?php

$detalles = $_REQUEST['detalles'];

include_once '../api/Conexion.inc.php';

$sql = "SELECT * FROM respuesta re INNER JOIN equipos eq ON re.maquina_id = eq.id INNER JOIN solicitud so ON re.soli_id = so.id INNER JOIN usuarios us ON so.autor_soli = us.id INNER JOIN tecnicos te ON re.autor_id = te.id WHERE us.id = :detalles AND te.id = :tecnico";
$sentencia = $conexion->prepare($sql);

$sentencia->bindParam(":detalles", $detalles, PDO::PARAM_STR);
$sentencia->bindParam(":tecnico", $_SESSION['id_tec'], PDO::PARAM_STR);
$sentencia->execute();

$result = $sentencia->fetchall(PDO::FETCH_ASSOC);
?>

<div class="modal fade" id="informe_completo_tecnico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalle del mantenimiento realizado</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>FUNCIONARIO</th>
                            <th>EQUIPO</th>
                            <th>CARACTERISTICAS</th>
                            <th>FALLO</th>
                            <th>NOVEDADES</th>
                            <th>DESCRIPCION</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($result)) {
                            foreach ($result as $filas) {
                        ?>
                                <tr>
                                    <td><?php echo $filas['nombre_user']; ?></td>
                                    <td><?php echo $filas['tipo']; ?></td>
                                    <td><?php echo $filas['caracteristicas']; ?></td>
                                    <td><?php echo $filas['descrip']; ?></td>
                                    <td><?php echo $filas['repuestos']; ?></td>
                                    <td><?php echo $filas['descripcion']; ?></td>
                                    <td><?php echo $filas['fecha']; ?></td>
                                </tr>
                        <?php
                            }
                        } echo "NO ESTA COGIENDO INFORMACION";
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                    <i class="fas fa-times-circle mr-2"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>