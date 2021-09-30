<?php
include_once 'api/Redireccion.inc.php';
include_once 'api/config.inc.php';
include_once 'api/ControlSesion.inc.php';
if (isset($usuario_insertado)) {
?>
    <div class="mt-4 text-center">
        ¡Ya tienes una cuenta!
        <br>
        <br>
        <?php
        if (ControlSesion::sesion_iniciada_admin()) {
        ?>
            <a href="<?php echo RUTA_PANEL_USUARIOS; ?>" class="btn btn-primary btn-block">
                <i class="fas fa-sign-in-alt mr-2"></i>Regresar al panel de usuarios</a>
        <?php
        } else {
        ?>
            <a href="<?php echo RUTA_LOGIN_USER; ?>" class="btn btn-primary btn-block">
                <i class="fas fa-sign-in-alt mr-2"></i>Inicia sesión ahora</a>
        <?php
        }
        ?>
    </div>
<?php
} else {
?>
    <div class="form-group">
        <label>Nombre</label>
        <input id="forname" type="text" class="form-control" name="nombre_user" <?php $validador_usuario->mostrar_nombre_usuario() ?>>
        <?php
        $validador_usuario->mostrar_error_nombre_usuario();
        ?>
    </div>
    <div class="form-group">
        <label>Apellido</label>
        <input id="forapellido" type="text" class="form-control" name="apellido_user" <?php $validador_usuario->mostrar_apellido_usuario() ?>>
        <?php
        $validador_usuario->mostrar_error_apellido_usuario()
        ?>
    </div>
    <div class="form-group">
        <label>Secretaria</label>
        <select class="form-control" id="forsecretarias" name="secretaria_user" <?php $validador_usuario->mostrar_secretaria_usuario() ?>>
            <option></option>
            <option>Agricultura y medio ambiente</option>
            <option>General</option>
            <option>Gobierno</option>
            <option>Hacienda Municipal</option>
            <option>Infraestructura y desarrollo fisico</option>
            <option>Inclusión y desarrollo social</option>
            <option>Planeación y gestion de riesgo</option>
            <option>Turismo, cultura, recreación y deporte</option>
        </select>
        <?php
        $validador_usuario->mostrar_error_secretaria_usuario()
        ?>
    </div>
    <div class="form-group">
        <label>Oficina</label>
        <input id="foraficina" type="text" class="form-control" name="oficina_user" <?php $validador_usuario->mostrar_oficina_usuario()   ?>>
        <?php
        $validador_usuario->mostrar_error_oficina_usuario()
        ?>
    </div>
    <div class="form-group">
        <label>Correo electronico</label>
        <input id="email" type="email" class="form-control" name="email_user" <?php $validador_usuario->mostrar_email_usuario()  ?>>
        <?php
        $validador_usuario->mostrar_error_email_usuario()
        ?>
    </div>
    <div class="form-group">
        <label>Contraseña</label>
        <input id="password" type="password" class="form-control" name="password_user" data-eye>
        <?php
        $validador_usuario->mostrar_error_password_usuario()
        ?>
    </div>
    <div class="form-group">
        <label>Repita la contraseña</label>
        <input id="password1" type="password" class="form-control" name="password1_user" data-eye>
        <?php
        $validador_usuario->mostrar_error_password1_usuario()
        ?>
    </div>
    <div class="form-group">
        <div class="custom-checkbox custom-control">
            <input type="checkbox" name="agree" id="agree" class="custom-control-input" required="">
            <label for="agree" class="custom-control-label">
                <a data-toggle="modal" data-target="#terminos_condiciones" class="btn btn-sm btn-light btn-icon-split">
                    <span class="text">Acepto terminos y condiciones</span>
                </a>
            </label>
            <div class="invalid-feedback">
                Debes estar de acuerdo con nuestros términos y condiciones.
            </div>
        </div>
    </div>
    <div class="form-group m-0">
        <button type="submit" class="btn btn-primary btn-block" name="registrarse">
            <i class="far fa-paper-plane mr-2"></i> Registrarse </button>
    </div>
    <div class="mt-4 text-center">
        ¡Ya tienes una cuenta! <a href="login_user.php">Inicia sesión ahora</a>
    </div>
<?php
}
?>