<?php
include_once 'RegistroTecnico.inc.php';
include_once 'Conexion.inc.php';

class ValidadorRegistroTecnico
{

    private $nombre_tec;
    private $apellido_tec;
    private $email_tec;
    private $password_tec;

    private $error_nombre_tec;
    private $error_apellido_tec;
    private $error_email_tec;
    private $error_password_tec;
    private $error_password1_tec;

    private $aviso_inicio_tec;
    private $aviso_cierre_tec;

    public function __construct($nombre_tec, $apellido_tec, $email_tec, $password_tec, $password1_tec, $conexion)
    {

        $this->aviso_inicio_tec = "<br><div class='alert alert-danger' role='alert'>";
        $this->aviso_cierre_tec = "</div>";

        $this->nombre_tec = "";
        $this->apellido_tec = "";
        $this->email_tec = "";
        $this->password_tec = "";

        $this->error_nombre_tec = $this->validar_nombre($nombre_tec , $conexion);
        $this->error_apellido_tec = $this->validar_apellido($apellido_tec);
        $this->error_email_tec = $this->validar_email($email_tec, $conexion);
        $this->error_password_tec = $this->validar_password($password_tec);
        $this->error_password1_tec = $this->validar_password1($password_tec, $password1_tec);

        if ($this->error_password_tec === "" && $this->error_password1_tec) {
            $this->password_tec = $password_tec;
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

    private function validar_nombre($nombre_tec, $conexion)
    {
        if (!$this->variable_iniciada($nombre_tec)) {
            return "Debes escribir un nombre de usuario";
        } else {
            $this->nombre_tec = $nombre_tec;
        }

        if (strlen($nombre_tec) <= 2) {
            return "El nombre debe ser mas largo de 2 caracteres";
        }

        if (strlen($nombre_tec) >= 30) {
            return "El nombre no puede ser mas largo de 30 caracteres";
        }
        
        if (RegistroTecnico::tecnico_existe($conexion)) {
            return "Este nombre ya existe prueba con otro nombre";
        }
        

        return "";
    }

    private function validar_apellido($apellido_tec)
    {
        if (!$this->variable_iniciada($apellido_tec)) {
            return "Debes escribir un apellido de usuario";
        } else {
            $this->apellido_tec = $apellido_tec;
        }

        if (strlen($apellido_tec) < 3) {
            return "El nombre debe ser mas largo de 3 caracteres";
        }

        if (strlen($apellido_tec) > 30) {
            return "El nombre no puede ser mas largo de 30 caracteres";
        }

        return "";
    }

    private function validar_email($email_tec, $conexion)
    {
        if (!$this->variable_iniciada($email_tec)) {
            return "Debes ingresar un correo electronico";
        } else {
            $this->email_tec = $email_tec;
        }
        
        if (RegistroTecnico::email_tecnico_existe($conexion)) {
            return "Este email ya se encuentra registrado en el sistema";
        }

        return "";
    }

    private function validar_password($password_tec)
    {
        if (!$this->variable_iniciada($password_tec)) {
            return "Debes ingresar una contraseña";
        }

        return "";
    }

    private function validar_password1($password_tec, $password1_tec)
    {

        if (!$this->variable_iniciada($password_tec)) {
            return "Debes completar los dos campos";
        }

        if (!$this->variable_iniciada($password1_tec)) {
            return "Debes repetir tu contraseña";
        }

        if ($password_tec !== $password1_tec) {
            return "Las contraseñas deben coincidir";
        }

        return "";
    }

    public function obtener_nombre_tecnico()
    {
        return $this->nombre_tec;
    }

    public function obtener_apellido_tecnico()
    {
        return $this->apellido_tec;
    }

    public function obtener_email_tecnico()
    {
        return $this->email_tec;
    }

    public function obtener_password_tecnico()
    {
        return $this->password_tec;
    }

    public function obtener_error_nombre_tecnico()
    {
        return $this->error_nombre_tec;
    }

    public function obtener_error_apellido_tecnico()
    {
        return $this->error_apellido_tec;
    }

    public function obtener_error_email_tecnico()
    {
        return $this->error_email_tec;
    }

    public function obtener_error_password_tecnico()
    {
        return $this->error_password_tec;
    }

    public function obtener_error_password1_tecnico()
    {
        return $this->error_password1_tec;
    }

    public function mostrar_nombre_tecnico()
    {
        if ($this->nombre_tec !== "") {
            echo 'value="' . $this->nombre_tec . '"';
        }
    }

    public function mostrar_error_nombre_tecnico()
    {
        if ($this->error_nombre_tec !== "") {
            echo $this->aviso_inicio_tec . $this->error_nombre_tec . $this->aviso_cierre_tec;
        }
    }

    public function mostrar_apellido_tecnico()
    {
        if ($this->apellido_tec !== "") {
            echo 'value="' . $this->apellido_tec . '"';
        }
    }

    public function mostrar_error_apellido_tecnico()
    {
        if ($this->error_apellido_tec !== "") {
            echo $this->aviso_inicio_tec . $this->error_apellido_tec . $this->aviso_cierre_tec;
        }
    }

    public function mostrar_email_tecnico()
    {
        if ($this->email_tec !== "") {
            echo 'value="' . $this->email_tec . '"';
        }
    }

    public function mostrar_error_email_tecnico()
    {
        if ($this->error_email_tec !== "") {
            echo $this->aviso_inicio_tec . $this->error_email_tec . $this->aviso_cierre_tec;
        }
    }

    public function mostrar_error_password_tecnico()
    {
        if ($this->error_password_tec !== "") {
            echo $this->aviso_inicio_tec . $this->error_password_tec . $this->aviso_cierre_tec;
        }
    }

    public function mostrar_error_password1_tecnico()
    {
        if ($this->error_password1_tec !== "") {
            echo $this->aviso_inicio_tec . $this->error_password1_tec . $this->aviso_cierre_tec;
        }
    }

    public function registro_valido_tecnico()
    {
        if (
            $this->error_nombre_tec === "" &&
            $this->error_apellido_tec === "" &&
            $this->error_email_tec === "" &&
            $this->error_password_tec === "" &&
            $this->error_password1_tec === ""
        ) {
            return true;
        } else {
            return false;
        }
    }
}
