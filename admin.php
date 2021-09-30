<?php
include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/Contador.inc.php';
include_once 'api/Redireccion.inc.php';

$titulo = 'Admin';

include_once 'plantillas/declaracion_documento.inc.php';
include_once 'plantillas/sidebar.inc.php';
include_once 'plantillas/navbar.inc.php';

if (ControlSesion::sesion_iniciada_admin()) {
?>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Menu de administrador</h1>
        </div>
        <hr class="sidebar-divider my-0">
        <br>
        <div class="text-center">
            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_settings.svg" alt="">
        </div>

        <div class="row">

            <?php
            $n_tecnicos = Contador::count_tecnicos($conexion);

            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Usuarios: Tecnicos</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> N° <?php echo count($n_tecnicos);  ?>
                                    <a href="<?php echo RUTA_PANEL_TECNICOS;  ?>"> <i class="far fa-eye text-gray-900"></i> </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="<?php echo RUTA_PANEL_TECNICOS;  ?>"> <i class="fas fa-users-cog fa-2x text-gray-500"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $n_usuarios = Contador::count_usuarios($conexion);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Usuarios: Funcionario</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> N° <?php echo count($n_usuarios);  ?>
                                    <a href="<?php echo RUTA_PANEL_USUARIOS;  ?>"> <i class="far fa-eye text-gray-900"></i> </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="<?php echo RUTA_PANEL_USUARIOS;  ?>"> <i class="fas fa-user-friends fa-2x text-gray-500"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $n_equipos = Contador::count_equipos($conexion);

            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Equipos registrados</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> N° <?php echo count($n_equipos);  ?>
                                    <a href="<?php echo RUTA_EQUIPOS_DISPOSITIVOS; ?>"> <i class="far fa-eye text-gray-900"></i> </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="<?php echo RUTA_EQUIPOS_DISPOSITIVOS; ?>"><i class="fas fa-laptop-code fa-2x text-gray-500"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $n_t_end = Contador::count_tickets_end($conexion);

            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Tickets finalizados </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> N° <?php echo count($n_t_end);  ?>
                                    <a href="<?php echo RUTA_TICKETS_FINALIZADOS; ?>"> <i class="far fa-eye text-gray-900"></i> </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="<?php echo RUTA_TICKETS_FINALIZADOS; ?>"> <i class="fas fa-clipboard-check fa-2x text-gray-500"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row>">
            <?php
            $n_t_proceso = Contador::count_tickets_proceso($conexion);
            ?>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Tickets sin responder</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"> N° <?php echo count($n_t_proceso);  ?>
                                    <a href="<?php echo RUTA_PROCESOS_TICKETS; ?>"> <i class="far fa-eye text-gray-900"></i> </a>
                                </div>
                            </div>
                            <div class="col-auto">
                                <a href="<?php echo RUTA_PROCESOS_TICKETS; ?>"> <i class="fas fa-clipboard-list fa-2x text-gray-500"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}else{
    include_once 'plantillas/error.inc.php';
}
include_once 'plantillas/cierre_contenido.inc.php';
include_once 'plantillas/footer_modal.inc.php';
include_once 'plantillas/declaracion_cierre.inc.php';
?>