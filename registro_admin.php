<?php

include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/ControlSesion.inc.php';


$titulo = 'Registro tecnicos';

if (!ControlSesion::sesion_iniciada_admin()) {
    Redireccion::redirigir(SERVIDOR);
}

if (isset($_POST['registrarse'])) {

    if (!empty($_POST['name']) && !empty($_POST['mail']) && !empty($_POST['password']) && !empty($_POST['password1'])) {

        if ($_POST['password'] == $_POST['password1']) {

            if (isset($conexion)) {

                try {

                    $name = $_POST['name'];
                    $mail = $_POST['mail'];
                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                    $sql = "INSERT INTO admin(nombre, email, password, activo) VALUES (:nombre, :email, :password, 1)";

                    $sentencia = $conexion->prepare($sql);

                    $sentencia->bindParam(':nombre', $name, PDO::PARAM_STR);
                    $sentencia->bindParam(':email', $mail, PDO::PARAM_STR);
                    $sentencia->bindParam(':password', $password, PDO::PARAM_STR);

                    $admin_insertado = $sentencia->execute();

                    if ($admin_insertado) {
                        $_SESSION['alerta'] = "Registro completo";
                        $_SESSION['estado'] = "success";
                    }
                } catch (PDOException $ex) {
                    print 'Error: ' . $ex->getMessage();
                }
            }
        } else {
            $_SESSION['alerta'] = "La contraseña no coinciden";
            $_SESSION['estado'] = "info";
        }
    } else {
        $_SESSION['alerta'] = "Fallo en el registro del tecnico";
        $_SESSION['estado'] = "warning";
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
                    REGISTRO ADMINISTRADOR
                </div>

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                            <?php
                            if (isset($admin_insertado)) {
                            ?>
                                <div class="col-lg-6 login-btm login-button">
                                    <br>
                                    <?php
                                    if (ControlSesion::sesion_iniciada_admin()) {
                                    ?>
                                        <a href="<?php echo RUTA_ADMINISTRADOR; ?>" class="btn btn-outline-primary" name="redirigir">
                                            <i class="fas fa-sign-in-alt mr-2"></i>Regresar al menu administrador.
                                        </a>
                                        <?php
                                    } else {
                                        if (ControlSesion::sesion_iniciada_tecnico()) {
                                        ?>
                                            <a href="<?php echo SERVIDOR; ?>" class="btn btn-outline-primary" name="redirigir">
                                                <i class="fas fa-sign-in-alt mr-2"></i>Regresar a la pagina principal
                                            </a>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="form-group">
                                    <label class="form-control-label">Nombre</label>
                                    <input type="text" class="form-control" name="name" id="nombre_t" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Correo</label>
                                    <input type="email" class="form-control" name="mail" id="email_t" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Contraseña</label>
                                    <input type="password" class="form-control" name="password" id="password_t" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Repita la contraseña</label>
                                    <input type="password" class="form-control" name="password1" id="password_t1" required>
                                </div>
                                <div class="col-lg-10 loginbttm">
                                    <div class="col-lg-6 login-btm login-button">
                                        <button id="btnregistro" type="submit" name="registrarse" class="btn btn-outline-primary" required>
                                            <i class="fas fa-user-plus mr-2"></i>Registrarse</button>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </form>
                    </div>
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
                    // text: "You clicked the button!",
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