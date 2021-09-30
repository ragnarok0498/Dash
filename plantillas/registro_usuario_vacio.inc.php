<div class="form-group">
    <label>Nombre</label>
    <input id="forname" type="text" class="form-control" name="nombre_user" autofocus>
</div>
<div class="form-group">
    <label>Apellido</label>
    <input id="forapellido" type="text" class="form-control" name="apellido_user">
</div>
<div class="form-group">
    <label>Secretaria</label>
    <select class="form-control" id="forsecretarias" name="secretaria_user">
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
</div>
<div class="form-group">
    <label>Oficina</label>
    <input id="foraficina" type="text" class="form-control" name="oficina_user">
</div>
<div class="form-group">
    <label>Correo electronico</label>
    <input id="email" type="email" class="form-control" name="email_user">
</div>
<div class="form-group">
    <label>Contraseña</label>
    <input id="password" type="password" class="form-control" name="password_user" data-eye>
</div>
<div class="form-group">
    <label>Repita la contraseña</label>
    <input id="password1" type="password" class="form-control" name="password1_user" data-eye>
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