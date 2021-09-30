<?php

include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/RegistroTecnico.inc.php';
include_once 'api/ValidadorRegistroTecnico.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/ControlSesion.inc.php';

if (ControlSesion::sesion_iniciada_tecnico()) {
    echo '<script>windows.location="' . Redireccion::redirigir(SERVIDOR) . '"</script>';
}

if (ControlSesion::sesion_iniciada_usuario()) {
    Redireccion::redirigir(SERVIDOR);
}

$titulo = 'Registro tecnicos';


if (ControlSesion::sesion_iniciada_admin()) {


    if (isset($_POST['registrarse'])) {

        $validador = new ValidadorRegistroTecnico(
            $_POST['nombre_tec'],
            $_POST['apellido_tec'],
            $_POST['email_tec'],
            $_POST['password_tec'],
            $_POST['password1_tec'],
            $conexion
        );

        if ($validador->registro_valido_tecnico()) {

            $tecnico_insertado = RegistroTecnico::insertar_tecnico($conexion);

            if ($tecnico_insertado) {

                $_SESSION['alerta'] = "Registro completo";
                $_SESSION['estado'] = "success";
            } else {

                $_SESSION['alerta'] = "Fallo en el registro del tecnico";
                $_SESSION['estado'] = "warning";
            }

            $sentencia = null;
            $sql = null;
        }
    }
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
        <title>Dashboard Mantenimientos</title>
        <link rel="shortcut icon" type="image/x-icon" href="img/api.ico">


        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link href="css/bootstrap-plantilla.css" rel="stylesheet">
        <link href="css/graficos-login.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-2"></div>
                <div class="col-lg-6 col-md-8 login-box">
                    <div class="col-lg-12 login-key">
                        <i class="fa fa-key" aria-hidden="true"></i>
                    </div>
                    <div class="col-lg-12 login-title">
                        REGISTRO TECNICOS
                    </div>

                    <div class="col-lg-12 login-form">
                        <div class="col-lg-12 login-form">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                                <?php
                                if (isset($_POST['registrarse'])) {
                                    include_once 'plantillas/registro_tecnico_validado.inc.php';
                                } else {
                                    include_once 'plantillas/registro_tecnico_vacio.inc.php';
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-2">
                    </div>
                </div>
            </div>
            <br>
            <div class="footer align-items-center text-center mb-4">
                Copyright &copy; 2021 &mdash; Bleywill
            </div>
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
    </html>
<?php
} else {
    Redireccion::redirigir(SERVIDOR);
}

?>