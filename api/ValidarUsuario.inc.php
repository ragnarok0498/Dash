<?php

include_once 'RegistroUsuario.inc.php';
include_once 'Conexion.inc.php';

class ValidarUsuario
{

    private $nombre_user;
    private $apellido_user;
    private $secretaria_user;
    private $oficina_user;
    private $email_user;
    private $password_user;
    private $error_nombre_user;
    private $error_apellido_user;
    private $error_secretaria_user;
    private $error_oficina_user;
    private $error_email_user;
    private $error_password_user;
    private $error_password1_user;

    private $aviso_inicio_user;
    private $aviso_cierre_user;


    public function __construct($nombre_user, $apellido_user, $secretaria_user, $oficina_user, $email_user, $password_user, $password1_user, $conexion)
    {

        $this->aviso_inicio_user = "<br><div class='alert alert-danger' role='alert'>";
        $this->aviso_cierre_user = "</div>";

        $this->nombre_user_user = "";
        $this->apellido_user = "";
        $this->secretaria_user = "";
        $this->oficina_user = "";
        $this->email_user = "";
        $this->password_user = "";

        $this->error_nombre_user = $this->validar_nombre_usuario($nombre_user);
        $this->error_apellido_user = $this->validar_apellido_usuario($apellido_user);
        $this->error_secretaria_user = $this->validar_secretaria_usuario($secretaria_user);
        $this->error_oficina_user = $this->validar_oficina_usuario($oficina_user);
        $this->error_email_user = $this->validar_email_usuario($email_user, $conexion);
        $this->error_password_user = $this->validar_password_usuario($password_user);
        $this->error_password1_user = $this->validar_password1_usuario($password_user, $password1_user);

        if ($this->error_password_user === "" && $this->error_password1_user) {
            $this->password_user = $password_user;
        }
    }

    private function variable_iniciada($variable)
    {
        if (isset($variable) && !empty($variable)) {
            return true;
        } else {
            return false;
        }
    }

    private function validar_nombre_usuario($nombre_user)
    {
        if (!$this->variable_iniciada($nombre_user)) {
            return "Debes escribir un nombre de usuario";
        } else {
            $this->nombre_user = $nombre_user;
        }

        if (strlen($nombre_user) <= 2) {
            return "El nombre debe ser mas largo de 2 caracteres";
        }

        if (strlen($nombre_user) >= 30) {
            return "El nombre no puede ser mas largo de 30 caracteres";
        }

        return "";
    }

    private function validar_apellido_usuario($apellido_user)
    {
        if (!$this->variable_iniciada($apellido_user)) {
            return "Debes escribir un apellido de usuario";
        } else {
            $this->apellido_user = $apellido_user;
        }

        if (strlen($apellido_user) < 3) {
            return "El nombre debe ser mas largo de 3 caracteres";
        }

        if (strlen($apellido_user) > 30) {
            return "El nombre no puede ser mas largo de 30 caracteres";
        }

        return "";
    }

    private function validar_secretaria_usuario($secretaria_user)
    {
        if (!$this->variable_iniciada($secretaria_user)) {
            return "Debes ingresar una secretaria";
        } else {
            $this->secretaria_user = $secretaria_user;
        }

        return "";
    }

    private function validar_email_usuario($email_user,$conexion)
    {
        if (!$this->variable_iniciada($email_user)) {
            return "Debes ingresar un correo electronico";
        } else {
            $this->email_user = $email_user;
        }

        if (RegistroUsuario::email_usuario_existe ($conexion)) {
            return "Este email ya se encuentra registrado en el sistema";
        }

        return "";
    }

    private function validar_oficina_usuario($oficina_user)
    {
        if (!$this->variable_iniciada($oficina_user)) {
            return "Debes ingresar una oficina";
        } else {
            $this->oficina_user = $oficina_user;
        }

        return "";
    }

    private function validar_password_usuario($password_user)
    {
        if (!$this->variable_iniciada($password_user)) {
            return "Debes ingresar una contraseña";
        }

        return "";
    }

    private function validar_password1_usuario($password_user, $password1_user)
    {

        if (!$this->variable_iniciada($password_user)) {
            return "Debes completar los dos campos";
        }

        if (!$this->variable_iniciada($password1_user)) {
            return "Debes repetir tu contraseña";
        }

        if ($password_user !== $password1_user) {
            return "Las contraseñas deben coincidir";
        }

        return "";
    }

    public function obtener_nombre_usuario()
    {
        return $this->nombre_user;
    }

    public function obtener_apellido_usuario()
    {
        return $this->apellido_user;
    }

    public function obtener_secretaria_usuario()
    {
        return $this->secretaria_user;
    }

    public function obtener_oficina_usuario()
    {
        return $this->oficina_user;
    }

    public function obtener_email_usuario()
    {
        return $this->email_user;
    }

    public function obtener_password_usuario()
    {
        return $this->password_user;
    }

    public function obtener_error_nombre_usuario()
    {
        return $this->error_nombre_user;
    }

    public function obtener_error_apellido_usuario()
    {
        return $this->error_apellido_user;
    }

    public function obtener_error_secretaria_usuario()
    {
        return $this->error_secretaria_user;
    }

    public function obtener_error_oficina_usuario()
    {
        return $this->error_oficina_user;
    }

    public function obtener_error_email_usuario()
    {
        return $this->error_email_user;
    }

    public function obtener_error_password_usuario()
    {
        return $this->error_password_user;
    }

    public function obtener_error_password1_usuario()
    {
        return $this->error_password1_user;
    }

    public function mostrar_nombre_usuario()
    {
        if ($this->nombre_user !== "") {
            echo 'value="' . $this->nombre_user . '"';
        }
    }

    public function mostrar_error_nombre_usuario()
    {
        if ($this->error_nombre_user !== "") {
            echo $this->aviso_inicio_user . $this->error_nombre_user . $this->aviso_cierre_user;
        }
    }

    public function mostrar_apellido_usuario()
    {
        if ($this->apellido_user !== "") {
            echo 'value="' . $this->apellido_user . '"';
        }
    }

    public function mostrar_error_apellido_usuario()
    {
        if ($this->error_apellido_user !== "") {
            echo $this->aviso_inicio_user . $this->error_apellido_user . $this->aviso_cierre_user;
        }
    }

    public function mostrar_secretaria_usuario()
    {
        if ($this->secretaria_user !== "") {
            echo 'value="' . $this->secretaria_user . '"';
        }
    }

    public function mostrar_error_secretaria_usuario()
    {
        if ($this->error_secretaria_user !== "") {
            echo $this->aviso_inicio_user . $this->error_secretaria_user . $this->aviso_cierre_user;
        }
    }

    public function mostrar_oficina_usuario()
    {
        if ($this->oficina_user !== "") {
            echo 'value="' . $this->oficina_user . '"';
        }
    }

    public function mostrar_error_oficina_usuario()
    {
        if ($this->error_oficina_user !== "") {
            echo $this->aviso_inicio_user . $this->error_oficina_user . $this->aviso_cierre_user;
        }
    }

    public function mostrar_email_usuario()
    {
        if ($this->email_user !== "") {
            echo 'value="' . $this->email_user . '"';
        }
    }

    public function mostrar_error_email_usuario()
    {
        if ($this->error_email_user !== "") {
            echo $this->aviso_inicio_user . $this->error_email_user . $this->aviso_cierre_user;
        }
    }

    public function mostrar_error_password_usuario()
    {
        if ($this->error_password_user !== "") {
            echo $this->aviso_inicio_user . $this->error_password_user . $this->aviso_cierre_user;
        }
    }

    public function mostrar_error_password1_usuario()
    {
        if ($this->error_password1_user !== "") {
            echo $this->aviso_inicio_user . $this->error_password1_user . $this->aviso_cierre_user;
        }
    }

    public function registro_valido_usuario()
    {
        if (
            $this->error_nombre_user === "" &&
            $this->error_apellido_user === "" &&
            $this->error_secretaria_user === "" &&
            $this->error_oficina_user === "" &&
            $this->error_email_user === "" &&
            $this->error_password_user === "" &&
            $this->error_password1_user === ""
        ) {
            return true;
        } else {
            return false;
        }
    }
}
/*
if (isset($_POST['registrarse'])) {
    if (empty($nombreuser)) {
        $error_nombreuser = "<div class='alert alert-danger' role='alert'> * Agregar tu nombre   </div>";
        // echo "<p class='error'>* Agregar tu nombre </p>";
    }
    if (strlen($nombreuser) > 15) {
        $error_nombreuser = "<div class='alert alert-danger' role='alert'>* El nombre es muy largo</div>";
        // echo "<p class='error'>* El nombre es muy largo </p>";
    }


    if (empty($apellidouser)) {
        $error_apellidouser = "<div class='alert alert-danger' role='alert'>  * Agregar tu apellido  </div>";
        //   echo "<p class='error'>* Agregar tu apellido </p>";
    } else {
        if (strlen($apellidouser) > 15) {
            $error_apellidouser = "<div class='alert alert-danger' role='alert'> * El apellido es muy largo   </div>";
            // echo "<p class='error'>* El apellido es muy largo </p>";
        }
    }

    if (empty($secretariauser)) {
        $error_secretariauser = "<div class='alert alert-danger' role='alert'>  * Agregar tu secretaria  </div>";
        // echo "<p class='error'>* Agregar tu secretaria </p>";
    }

    if (empty($oficinauser)) {
        $error_oficinauser = "<div class='alert alert-danger' role='alert'>  * Agregar tu oficina  </div>";
        //  echo "<p class='error'>* Agregar tu oficina </p>";
    } else {
        if (strlen($oficinauser) > 30) {
            $error_oficinauser = "<div class='alert alert-danger' role='alert'>  * El oficina es muy largo  </div>";
            // echo "<p class='error'>* El oficina es muy largo </p>";
        }
    }

    if (empty($emailuser)) {
        $error_emailuser = "<div class='alert alert-danger' role='alert'>  * Agregar tu correo   </div>";
        // echo "<p class='error'>* Agregar tu correo </p>";
    } else {
        if (!filter_var($emailuser, FILTER_VALIDATE_EMAIL)) {
            $error_emailuser = "<div class='alert alert-danger' role='alert'>  * el correo es incorrecto  </div>";
            // echo "<p class='error'>* el correo es incorrecto </p>";
        }
    }


    if (!empty($passworduser) || !empty($password1user)) {
        if ($passworduser !== $password1user) {
            $error_passworduser = "<div class='alert alert-danger' role='alert'>  * Las contraseña no coinciden   </div>";
            // echo "<p class='error'>* Las contraseña no coinciden  </p>";
        } else {
            if (strlen($passworduser) > 4) {
                $error_passworduser = "<div class='alert alert-danger' role='alert'>  * las contraseñas debe ser mayor a 4 caracteres  </div>";
                // echo "<p class='error'>* las contraseñas debe ser mayor a 4 caracteres  </p>";
            }
        }
    } else {
        $error_password1user = "<div class='alert alert-danger' role='alert'> * Agrega la contraseña en ambos campos   </div>";
        //  echo "<p class='error'>* Agrega la contraseña en ambos campos </p>";
    }
}
*/