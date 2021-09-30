<?php
include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Tickets.inc.php';
include_once 'api/Contador.inc.php';

?>
<div id="content">
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
            <?php
            if (ControlSesion::sesion_iniciada_tecnico()) {
            ?>
                <?php
                $notify = Tickets::count_tickets_proceso($conexion);
                ?>
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell fa-fw"></i>
                        <span class="badge badge-danger badge-counter"><?php echo count($notify);  ?></span>
                    </a>
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                        <h6 class="dropdown-header bg-primary">
                            Centro de notificaciones
                        </h6>
                        <?php
                        $sentencia = $conexion->prepare("SELECT * FROM solicitud WHERE notify=0 LIMIT 5");
                        $sentencia->execute();
                        $alertas = $sentencia->fetchAll(PDO::FETCH_OBJ);
                        if (!empty($alertas)) {
                            foreach ($alertas as $fila) {
                        ?>
                                <a class="dropdown-item d-flex align-items-center" href=" <?php echo RUTA_TICKET_RESPONDER . $fila->id  ?> ">
                                    <div>
                                        <div class="small text-gray-500"><?php echo $fila->horafecha;    ?></div>
                                        <span class=""><?php echo '<strong> Equipo:</strong> ' . $fila->tipoe . '<br>' . '<strong>Descripcion:</strong> ' . $fila->descrip;     ?></span>
                                    </div>
                                </a>
                            <?php
                            }
                            ?>
                            <a class="dropdown-item text-center small text-gray-500 text-info" href="<?php echo RUTA_PROCESOS_TICKETS; ?>">
                                Ver todas las solicitudes detalladas.
                            </a>
                        <?php
                        } else {
                        ?>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div>
                                    <div class="small text-gray-500 text-info">Aviso</div>
                                    No hay solicitudes en proceso pendientes...
                                </div>
                            </a>
                        <?php
                        }
                        ?>
                    </div>
                </li>
                <div class="topbar-divider d-none d-sm-block"></div>

                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-tie mr-2 fa-2x text-gray-800"></i>
                        <span class="mr-2 d-none d-lg-inline text-black-50 small"></span>
                        <h5 class="text-gray-800"> <?php echo $_SESSION['nombre_tec']; ?> </h5>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?php echo RUTA_ACTIVIDAD_TECNICOS; ?>">
                            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                            Actividad
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-muted">
                            <i class="fa fa-user-circle fa-sm fa-fw mr-2 text-gray-400"></i>
                            Usuarios
                            <?php
                            $n_usuarios = Contador::count_usuarios($conexion);
                            echo  count($n_usuarios);
                            ?>
                        </a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400 text-muted"></i>
                            Cerrar sesion
                        </a>
                    </div>
                </li>
                <?php
            } else {
                if (ControlSesion::sesion_iniciada_admin()) {
                ?>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-shield  fa-2x mr-2 text-gray-800"></i>
                            <span class="mr-2 d-none d-lg-inline text-black-50 small"></span>
                            <h5 class="text-gray-800"> <?php echo $_SESSION['nombre_admin']; ?> </h5>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="<?php echo RUTA_ADMINISTRADOR; ?>">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Menu
                            </a>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logout_modal_administrador">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400 text-muted"></i>
                                Cerrar sesion
                            </a>
                        </div>
                    </li>
                    <?php
                } else {
                    if (ControlSesion::sesion_iniciada_usuario()) {
                    } else {
                    ?>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-users fa-2x mr-2 text-gray-800"> </i>
                                <h5><span class="mr-2 d-none d-lg-inline text-gray-800 small">Tecnicos</span></h5>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?php echo RUTA_LOGIN_TECNICO; ?>">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Iniciar sesion
                                </a>
                            </div>
                        </li>

                    <?php
                    }
                    ?>

            <?php
                }
            }
            ?>


        </ul>
    </nav>