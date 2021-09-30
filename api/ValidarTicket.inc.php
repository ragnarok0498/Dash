<?php

include_once 'Tickets.inc.php';
include_once 'Conexion.inc.php';

class ValidarTicket
{

    private $equipo_dispositivo;
    private $descripcion_ticket;

    private $aviso_inicio_ticket;
    private $aviso_cierre_ticket;


    public function __construct($equipo_dispositivo, $descripcion_ticket)
    {

        $this->aviso_inicio_ticket = "<br><div class='alert alert-danger' role='alert'>";
        $this->aviso_cierre_ticket = "</div>";

        $this->equipo_dispositivo = '';
        $this->descripcion_ticket = '';

        $this->error_equipo = $this->validar_equipo_ticket($equipo_dispositivo);
        $this->error_descripcion = $this->validar_descripcion_ticket($descripcion_ticket);
    }


    private function variable_iniciada($variable)
    {
        if (isset($variable) && !empty($variable)) {
            return true;
        } else {
            return false;
        }
    }


    private function validar_equipo_ticket($equipo_dispositivo)
    {

        if (!$this->variable_iniciada($equipo_dispositivo)) {
            return "Debes ingresar el tipo de dispositvo o equipo";
        } else {
            $this->equipo_dispositivo = $equipo_dispositivo;
        }

        if (strlen($equipo_dispositivo) <= 2) {
            return "El tipo de equipo o dispositivo debe ser mayor de dos caracteres";
        }

        return "";
    }

    private function validar_descripcion_ticket($descripcion_ticket)
    {

        if (!$this->variable_iniciada($descripcion_ticket)) {
            return "Debes describir el fallo del equipo o dispositivo";
        } else {
            $this->descripcion_ticket = $descripcion_ticket;
        }

        if (strlen($descripcion_ticket) <= 5) {
            return "La descripcion del fallo debe ser mayor de 5 caracteres.";
        }

        return "";
    }

    public function obtener_equipo_ticket()
    {
        return $this->equipo_dispositivo;
    }

    public function obtener_descripcion_ticket()
    {
        return $this->descripcion_ticket;
    }

    public function mostrar_equipo_ticket()
    {
        if ($this->equipo_dispositivo !== "") {
            echo 'value="' . $this->equipo_dispositivo . '"';
        }
    }

    public function mostrar_error_equipo_ticket()
    {
        if ($this->error_equipo !== "") {
            echo $this->aviso_inicio_ticket . $this->error_equipo . $this->aviso_cierre_ticket;
        }
    }

    public function mostrar_descripcion_ticket()
    {
        if ($this->descripcion_ticket !== "") {
            echo 'value="' . $this->descripcion_ticket . '"';
        }
    }

    public function mostrar_error_descripcion_ticket()
    {
        if ($this->error_descripcion) {
            echo $this->aviso_inicio_ticket . $this->error_descripcion . $this->aviso_cierre_ticket;
        }
    }

    public function registro_valido_ticket()
    {
        if (
            $this->error_equipo === "" &&
            $this->error_descripcion === ""
        ) {
            return true;
        } else {
            return false;
        }
    }
}
