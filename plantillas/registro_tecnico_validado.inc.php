<?php
include_once 'api/Redireccion.inc.php';
include_once 'api/ControlSesion.inc.php';

if (isset($tecnico_insertado)) {
?>
    <div class="col-lg-6 login-btm login-button">
        <br>
        <?php
        if (ControlSesion::sesion_iniciada_admin()) {
        ?>
            <a href="<?php echo RUTA_PANEL_TECNICOS; ?>" class="btn btn-outline-primary" name="redirigir">
                <i class="fas fa-sign-in-alt mr-2"></i>Regresar al panel de tecnicos.
            </a>
        <?php
        } else {
        ?>
            <a href="<?php echo RUTA_LOGIN_TECNICO; ?>" class="btn btn-outline-primary" name="redirigir">
                <i class="fas fa-sign-in-alt mr-2"></i>Iniciar sesión
            </a>

        <?php
        }
        ?>
    </div>
<?php
} else {
?>
    <div class="form-group">
        <label class="form-control-label">Nombre</label>
        <input type="text" class="form-control" name="nombre_tec" id="nombre_t" <?php $validador->mostrar_nombre_tecnico() ?>>
        <?php
        $validador->mostrar_error_nombre_tecnico();
        ?>
    </div>
    <div class="form-group">
        <label class="form-control-label">Apellido</label>
        <input type="text" class="form-control" name="apellido_tec" id="apellido_t" <?php $validador->mostrar_apellido_tecnico() ?>>
        <?php
        $validador->mostrar_error_apellido_tecnico();
        ?>
    </div>
    <div class="form-group">
        <label class="form-control-label">Correo</label>
        <input type="email" class="form-control" name="email_tec" id="email_t" <?php $validador->mostrar_email_tecnico() ?>>
        <?php
        $validador->mostrar_error_email_tecnico();
        ?>
    </div>
    <div class="form-group">
        <label class="form-control-label">Contraseña</label>
        <input type="password" class="form-control" name="password_tec" id="password_t">
        <?php
        $validador->mostrar_error_password_tecnico();
        ?>
    </div>
    <div class="form-group">
        <label class="form-control-label">Repita la contraseña</label>
        <input type="password" class="form-control" name="password1_tec" id="password_t1">
        <?php
        $validador->mostrar_error_password1_tecnico();
        ?>
    </div>
    <div class="col-lg-10 loginbttm">
        <div class="col-lg-6 login-btm login-button">
            <button id="btnregistro" type="submit" name="registrarse" class="btn btn-outline-primary">
                <i class="fas fa-user-plus mr-2"></i>Registrarse</button>
        </div>
    </div>
<?php
}
?>