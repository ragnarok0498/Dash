<?php

class ControlSesion
{

    public static function iniciar_sesion_admin($id_admin, $nombre_admin, $email_admin)
    {
        if (session_id() == '') {
            session_start();
        }
        $_SESSION['id_admin'] = $id_admin;
        $_SESSION['nombre_admin'] = $nombre_admin;
        $_SESSION['email_admin'] = $email_admin;
    }
    public static function cerrar_sesion_admin()
    {
        if (session_id() == '') {
            session_start();
        }

        if (isset($_SESSION['id_admin'])) {
            unset($_SESSION['id_admin']);
        }

        if (isset($_SESSION['nombre_admin'])) {
            unset($_SESSION['nombre_admin']);
        }

        if(isset($_SESSION['email_admin'])){
            unset($_SESSION['email_admin']);
        }

        session_destroy();
    }
    public static function sesion_iniciada_admin()
    {
        if (session_id() == '') {
            session_start();
        }

        if (isset($_SESSION['id_admin']) && isset($_SESSION['nombre_admin']) && $_SESSION['email_admin']) {
            return true;
        } else {
            return false;
        }
    }
    

    public static function iniciar_sesion_tecnico($id_tec, $nombre_tec, $apellido_tec, $email_tec, $fecha_registro_tec)
    {
        if (session_id() == '') {
            session_start();
        }
        $_SESSION['id_tec'] = $id_tec;
        $_SESSION['nombre_tec'] = $nombre_tec;
        $_SESSION['apellido_tec'] = $apellido_tec;
        $_SESSION['email_tec'] = $email_tec;
        $_SESSION['fecha_registro_tec'] = $fecha_registro_tec;
    }

    public static function cerrar_sesion_tecnico()
    {
        if (session_id() == '') {
            session_start();
        }

        if (isset($_SESSION['id_tec'])) {
            unset($_SESSION['id_tec']);
        }

        if (isset($_SESSION['nombre_tec'])) {
            unset($_SESSION['nombre_tec']);
        }
        
        if (isset($_SESSION['apellido_tec'])) {
            unset($_SESSION['apellido_tec']);
        }

        if (isset($_SESSION['email_tec'])) {
            unset($_SESSION['email_tec']);
        }

        if (isset($_SESSION['fecha_registro_tec'])) {
            unset($_SESSION['fecha_registro_tec']);
        }

        session_destroy();
    }
    public static function sesion_iniciada_tecnico()
    {
        if (session_id() == '') {
            session_start();
        }

        if (isset($_SESSION['id_tec']) && isset($_SESSION['nombre_tec'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function iniciar_sesion_usuario($id_user, $nombre_user)
    {
        if (session_id() == '') {
            session_start();
        }
        $_SESSION['id_user'] = $id_user;
        $_SESSION['nombre_user'] = $nombre_user;
    }
    public static function cerrar_sesion_usuario()
    {
        if (session_id() == '') {
            session_start();
        }

        if (isset($_SESSION['id_user'])) {
            unset($_SESSION['id_user']);
        }

        if (isset($_SESSION['nombre_user'])) {
            unset($_SESSION['nombre_user']);
        }

        session_destroy();
    }
    public static function sesion_iniciada_usuario()
    {
        if (session_id() == '') {
            session_start();
        }

        if (isset($_SESSION['id_user']) && isset($_SESSION['nombre_user'])) {
            return true;
        } else {
            return false;
        }
    }
}
