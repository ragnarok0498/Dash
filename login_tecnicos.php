<?php
include_once 'api/Conexion.inc.php';
include_once 'api/RegistroTecnico.inc.php';
include_once 'api/ValidadorRegistroTecnico.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';

$titulo = 'Login tecnicos';


if (ControlSesion::sesion_iniciada_tecnico()) {
    Redireccion::redirigir(SERVIDOR);
}

if (ControlSesion::sesion_iniciada_admin()) {
    Redireccion::redirigir(SERVIDOR);
}

if (ControlSesion::sesion_iniciada_usuario()) {
    Redireccion::redirigir(SERVIDOR);
}

if (isset($_POST['btnlogin'])) {

    if (!empty($_POST['emailtec']) && !empty($_POST['passtec'])) {

        if (isset($conexion)) {

            try {

                $sentencia = $conexion->prepare('SELECT * FROM tecnicos  WHERE email = :email AND activo = 1');
                $sentencia->bindParam(':email', $_POST['emailtec']);
                $sentencia->execute();

                $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

                $mensaje = '';

                if ($resultado) {

                    if (count($resultado) > 0 && password_verify($_POST['passtec'], $resultado['password'])) {

                        ControlSesion::iniciar_sesion_tecnico(
                            $id_tec = $resultado['id'],
                            $nombre_tec = $resultado['nombre'],
                            $apellido_tec = $resultado['apellido'],
                            $email_tec = $resultado['email'],
                            $fecha_registro_tec = $resultado['fecha_registro']
                        );
                        Redireccion::redirigir(RUTA_ACTIVIDAD_TECNICOS);
                    } else {
                        $mensaje = "<div class='alert alert-danger text-md-center' role='alert'>
                       <i class='fas fa-exclamation-triangle'></i> Datos incorrectos
                     </div>";
                    }
                } else {

                    $stn = $conexion->prepare('SELECT * FROM admin  WHERE email = :email');
                    $stn->bindParam(':email', $_POST['emailtec']);
                    $stn->execute();

                    $datos = $stn->fetch(PDO::FETCH_ASSOC);

                    if ($datos) {
                        if (count($datos) > 0 && password_verify($_POST['passtec'], $datos['password'])) {

                            ControlSesion::iniciar_sesion_admin(
                                $id_admin = $datos['id'],
                                $nombre_admin = $datos['nombre'],
                                $email_admin = $datos['email']
                            );
                            Redireccion::redirigir(RUTA_ADMINISTRADOR);
                        } else {
                            $mensaje = "<div class='alert alert-danger text-md-center' role='alert'>
                           <i class='fas fa-exclamation-triangle'></i> Datos incorrectos
                         </div>";
                        }
                    }
                    $mensaje = "<div class='alert alert-danger text-md-center' role='alert'>
                       <i class='fas fa-exclamation-triangle'></i> Email no existe o cuenta suspendida.
                     </div>";
                }
                $stn = null;
                $sentencia->closeCursor(); 
                $sentencia = null;
                $sql = null;
            } catch (PDOException $ex) {
                print "ERROR" . $ex->getMessage();
            }
        }
    } else {
        echo "<div class='alert alert-warning text-md-center' role='alert'>
        <i class='fas fa-exclamation-triangle fa-2x mr-3'></i> Debe ingresar los datos completos, si no tiene cuenta comuniquece con el administrador del sistema.
        </div>";
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
                    PANEL DE TECNICOS
                </div>
                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                            <div class="form-group">
                                <label for="email" class="form-control-label">CORREO</label>
                                <input type="email" id="emailtec" name="emailtec" class="form-control" <?php if (isset($_POST['btnlogin']) && isset($_POST['emailtec']) && !empty($_POST['emailtec'])) {
                                                                                                            echo 'value="' . $_POST['emailtec'] . '"';
                                                                                                        }
                                                                                                        ?> autofocus>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-control-label">CONTRASEÑA</label>
                                <input type="password" id="passtec" name="passtec" class="form-control" autofocus>
                            </div>
                            <div class="col-lg-12 loginbttm">
                                <div class="col-lg-6 login-btm login-text">
                                    <?php
                                    if (isset($_POST['btnlogin']) && !empty($mensaje)) {
                                        echo $mensaje;
                                    ?>
                                        <div class='alert alert-info text-md-center' role='alert'>
                                            Para mayor información comuniquese con el administrador del aplicativo.
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                                <div class="col-lg-6 login-btm login-button">

                                    <button type="submit" name="btnlogin" class="btn btn-outline-primary">INICIAR
                                        SESIÓN</button>
                                </div>
                            </div>
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
</body>

</html>