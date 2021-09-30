<?php
include_once 'api/Conexion.inc.php';
include_once 'api/RegistroUsuario.inc.php';
include_once 'api/ValidarUsuario.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Redireccion.inc.php';
$titulo = 'Login usuarios';

if (ControlSesion::sesion_iniciada_usuario()) {
    Redireccion::redirigir(SERVIDOR);
}

if (ControlSesion::sesion_iniciada_tecnico()) {
    Redireccion::redirigir(SERVIDOR);
}

if (ControlSesion::sesion_iniciada_admin()) {
    Redireccion::redirigir(SERVIDOR);
}


$mensaje = '';
if (isset($_POST['registro'])) {


    if (!empty($_POST['email_user']) && !empty($_POST['password_user'])) {
        $sentencia = $conexion->prepare('SELECT * FROM usuarios  WHERE email_user = :email AND activo = 1');
        $sentencia->bindParam(':email', $_POST['email_user']);
        $sentencia->execute();

        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($resultado) {
            if (count($resultado) > 0 && password_verify($_POST['password_user'], $resultado['password'])) {

                ControlSesion::iniciar_sesion_usuario(
                    $id_user = $resultado['id'],
                    $nombre_user = $resultado['nombre_user']
                );
                $mensaje =  "<div class='alert alert-success text-md-center' role='alert'>
                <i class='fas fa-check-circle fa-2x mr-3 '></i>Login correcto
                </div>";
                Redireccion::redirigir(RUTA_GENERAR_TICKETS);
            } else {
                $mensaje = "<div class='alert alert-danger text-md-center' role='alert'>
               <i class='fas fa-exclamation-triangle'></i> Datos incorrectos
             </div>";
            }
        } else {
            $mensaje = "<div class='alert alert-danger text-md-center' role='alert'>
           <i class='fas fa-exclamation-triangle'></i> Email incorrecto o cuenta suspendida.
         </div>";
        }

        $sentencia = null; 
        $sql = null;
    } else {
        $mensaje = "<div class='alert alert-warning text-md-center' role='alert'>
        <i class='fas fa-exclamation-triangle fa-2x mr-3'></i> Debe ingresar los datos, si no tiene cuenta <a href='registro.php' class='alert-link'>Registrese</a>. para continuar.
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
    <link href="css/graficos-login-user.css" rel="stylesheet">
</head>

<body class="my-login-page">
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-md-center h-100">
                <div class="card-wrapper">
                    <div class="brand">
                        <i class="fa fa-user fa-6x"></i>
                    </div>
                    <div class="card fat">
                        <div class="card-body">
                            <h4 class="card-title text-center">Inicio de sesión usuarios</h4>
                            <form method="POST" class="my-login-validation" novalidate="">
                                <div class="form-group">
                                    <label for="email">Correo electronico</label>
                                    <input id="email" type="email" class="form-control" name="email_user" value="" required autofocus>
                                    <div class="invalid-feedback">
                                        Email incorrecto
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input id="password" type="password" class="form-control" name="password_user" required data-eye>
                                    <div class="invalid-feedback">
                                        Se requiere una contraseña
                                    </div>
                                </div>

                                <div class="form-group m-0">
                                    <button type="submit" class="btn btn-primary btn-block" name="registro">
                                        Iniciar sesión
                                    </button>
                                </div>
                                <div class="mt-4 text-center">
                                    ¡No tiene una cuenta! <a href="registro.php">Registrate ahora</a>
                                </div>
                                <br>
                                <div class="form-group m-0">
                                    <?php
                                    if (isset($_POST['registro']) && !empty($mensaje)) {
                                        echo $mensaje;
                                    ?>
                                        <div class='alert alert-info text-md-center' role='alert'>
                                            Si su cuenta ha sido suspendida para mayor información comuniquese con el administrador del aplicativo
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <p class="text-gray-500 text-justify">Señor usuario si olvido su contraseña pongase en contacto con la oficina de sistemas para su restablecimiento.</p>
                                </div>
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
</body>

</html>