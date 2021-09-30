<?php

include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/ValidarUsuario.inc.php';
include_once 'api/RegistroUsuario.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/ControlSesion.inc.php';

if (ControlSesion::sesion_iniciada_usuario()) {

    Redireccion::redirigir(SERVIDOR);
}

if (ControlSesion::sesion_iniciada_tecnico()) {

    Redireccion::redirigir(SERVIDOR);
}


if (isset($_POST['registrarse'])) {

    $validador_usuario = new ValidarUsuario(
        $_POST['nombre_user'],
        $_POST['apellido_user'],
        $_POST['secretaria_user'],
        $_POST['oficina_user'],
        $_POST['email_user'],
        $_POST['password_user'],
        $_POST['password1_user'],
        $conexion
    );

    if ($validador_usuario->registro_valido_usuario()) {

        $usuario_insertado = RegistroUsuario::insertar_usuario($conexion);

        if ($usuario_insertado) {

            $_SESSION['alerta'] = "Registro completo";
            $_SESSION['estado'] = "success";
            $_SESSION['boton'] = "Continue iniciando sesión";
        } else {

            $_SESSION['alerta'] = "Fallo en el registro del tecnico";
            $_SESSION['estado'] = "warning";
        }

        $sentencia = null; 
        $sql = null;
    }
}

$titulo = 'Registro usuarios';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
    echo "<title>$titulo</title>";
    ?>
    <link rel="shortcut icon" type="image/x-icon" href="img/api.ico">

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/bootstrap-plantilla.css" rel="stylesheet">
    <link href="css/graficos-login-user.css" rel="stylesheet">
</head>

<body class="my-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="brand">
                        <i class="fa fa-user-plus fa-5x"></i>
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title text-center">Formulario registro</h4>
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="my-login-validation">
                                <?php
                                if (isset($_POST['registrarse'])) {
                                    include_once 'plantillas/registro_usuario_validado.inc.php';
                                } else {
                                    include_once 'plantillas/registro_usuario_vacio.inc.php';
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                    <div class="footer">
                        Copyright &copy; 2021 &mdash; Bleywill
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="js/graficos-admin.min.js"></script>

    <script src="vendor/chart.js/Chart.min.js"></script>

    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <script src="js/sweetalert.min.js"></script>

    <?php
    if (isset($_SESSION['alerta']) && $_SESSION['alerta'] != '') {
    ?>
        <script>
            swal({
                title: "<?php echo $_SESSION['alerta'];  ?>",
                icon: "<?php echo $_SESSION['estado']; ?>",
                button: "<?php if (isset($_SESSION['boton'])) {
                                echo $_SESSION['boton'];
                            } else { ?> Continuar <?php } ?>",
            });
        </script>
    <?php
        unset($_SESSION['alerta']);
    }
    ?>
</body>
<div class="modal fade" id="terminos_condiciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><strong>Políticas de seguridad de la información </strong></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p> <strong> Sobre las bases de datos. </strong><br>
                    La totalidad de la información del sitio Web, está almacenada en una base de datos, para lo cual la entidad ha dispuesto una serie de validaciones de seguridad
                    con el objetivo de que el acceso a esta sea lo más restringido posible, para esto se han interpuesto barreras de fuego y software de control de contenidos con el
                    fin de filtrar cualquier ingreso no autorizado.</p>

                <p><strong> Sobre la adquisición de información.</strong><br>
                    Para la adquisición de información del sitio Web por parte de los usuarios, se utilizarán diferentes formularios donde el usuario ingresará su usuario y su clave,
                    la cual dependiendo de que tipo de usuario es en el portal, le permitirá controlar la información que ingresa.</p>

                <p><strong>Sobre el Registro de Usuario.</strong><br>
                    El sitio Web ofrece espacios para buscar el estado de las solicitudes a través de la entrega de un ticket (número o código) una vez haya registrado la información
                    solicitada. Se trata de un único número que no debe transferir ni entregar a un tercero, ya que este podría verificar el estado de dicha solicitud.</p>

                <p>Por lo tanto, el funcionario deberá destinar claramente y de forma real la información para poder ser susceptible de realizar la respectiva solicitud.</p>

                <p>El sitio Web se compromete a adoptar una política de confidencialidad y protección de datos, con el objeto de proteger la privacidad de la información personal
                    obtenida a través de su sitio web.</p>

                <p> Para disminuir los riesgos el sitio Web se recomienda al usuario salir de su cuenta y cerrar la ventana de su navegador cuando finalice su actividad, más aún si
                    comparte su computadora con alguien o utiliza una computadora en un lugar público como una biblioteca o un café Internet. </p>

                <p> El sitio Web no compartirá ni revelará la información confidencial con terceros, excepto que tenga expresa autorización de quienes se suscribieron, o cuando ha sido
                    requerido por orden judicial o legal.</p>

                <p><strong>Gestión de Sesiones Seguras</strong><br>
                    Se recomienda a los usuarios del sitio Web para tener sesiones, digitar el dominio del sitio web cada vez que quieran ingresar en cualquier navegador, o dejarlo como
                    favoritos en el mismo. Evitar accesar al portal a través de vínculos o correos que les envíen.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                    <i class="fas fa-times-circle"></i>
                    Cerrar</button>
            </div>
        </div>
    </div>
</div>

</html>