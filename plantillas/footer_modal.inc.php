<?php
include_once 'api/config.inc.php';
include_once 'api/Conexion.inc.php';
include_once 'api/Redireccion.inc.php';
include_once 'api/ControlSesion.inc.php';
include_once 'api/Equipos.inc.php';

?>
<div class="modal fade" id="logout_modal_administrador" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Desea cerrar sesión?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Seleccione "Salir" para finalizar la sesion de administrador.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                    <i class="fas fa-times-circle"></i>
                    Cancelar</button>
                <a class="btn btn-primary" href="<?php echo RUTA_LOGOUT_ADMIN;  ?>">
                    <i class="fas fa-sign-out-alt"></i>
                    Salir</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logout_modal_usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Desea cerrar sesión?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Seleccione "Salir" para finalizar la sesion de usuario.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                    <i class="fas fa-times-circle"></i>
                    Cancelar</button>
                <a class="btn btn-primary" href="<?php echo RUTA_LOGOUT_USER;  ?>">
                    <i class="fas fa-sign-out-alt"></i>
                    Salir</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Desea cerrar sesión?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Seleccione "Salir" para finalizar la sesion de usuario tecnico.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                    <i class="fas fa-times-circle"></i>
                    Cancelar</button>
                <a class="btn btn-primary" href="<?php echo RUTA_LOGOUT_TECNICO;   ?>">
                    <i class="fas fa-sign-out-alt"></i>
                    Salir</a>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['enviar_equipo'])) {

    if (!empty($_POST['tipo']) && !empty($_POST['marca']) && !empty($_POST['mac']) && !empty($_POST['caracte'] && !empty($_POST['especi']))) {

        $mac_existente = Equipos::mac_registro($conexion);

        if ($mac_existente) {
            $_SESSION['alerta'] = "La MAC ingresada ya existe en el sistema";
            $_SESSION['estado'] = "info";
        } else {
            $equipo_insertado = Equipos::insertar_equipo($conexion);

            if ($equipo_insertado) {

                $_SESSION['alerta'] = "Registro completo, recargue la tabla";
                $_SESSION['estado'] = "success";
            } else {

                $_SESSION['alerta'] = "Fallo al realizar el registro";
                $_SESSION['estado'] = "error";
            }
        }
        $sentencia->closeCursor(); 
        $sentencia = null; 

    } else {
        $_SESSION['alerta'] = "Debe ingresar todos los datos.";
        $_SESSION['estado'] = "warning";
    }
}
?>

<?php
if (isset($_SESSION['borrado'])) {
    $_SESSION['alerta'] = "Registro del equipo eliminado";
    $_SESSION['estado'] = "success";
}
?>

<div class="modal fade" id="RegistroEquiposModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo equipo o dispositivo.</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">

                <div class="modal-body">Complete todo el formulario para registrar el equipo.
                    <hr>
                    <div class="form-group">
                        <label for="ftipo">Tipo</label>
                        <input id="fortipo" type="text" class="form-control" name="tipo" required autofocus>
                        <div class="invalid-feedback">
                            ¿Cual es el tipo de dispositivo o equipo?
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fmarca">Marca</label>
                        <input id="formarca" type="text" class="form-control" name="marca" required autofocus>
                        <div class="invalid-feedback">
                            ¿Que marca es el dispositivo o equipo?
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fmarca">Caracteristicas</label>
                        <input id="formarca" type="text" class="form-control" name="caracte" required autofocus>
                        <div class="invalid-feedback">
                            ¿Cuales son las caracteristias del dispositivo o equipo?
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fmarca">Especificaciones</label>
                        <input id="formarca" type="text" class="form-control" name="especi" required autofocus>
                        <div class="invalid-feedback">
                            ¿Describa cuales son las especificaciones del dispositivo o equipo?
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fmac">Numero MAC</label>
                        <input id="formac" type="text" class="form-control" name="mac" required autofocus>
                        <div class="invalid-feedback">
                            Numero de mac del equipo o dispositivo
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        <i class="fas fa-times-circle"></i>
                        Cerrar</button>
                    <?php
                    if (!isset($_POST['enviar_equipo'])) {
                    ?>
                        <button id="btnregistro_e" type="submit" name="enviar_equipo" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                            Registrar equipo</button>
                    <?php
                    } else {
                    }
                    ?>
                    <p>Señor tecnico si ya realizo el registro del equipo recargue la pagina para visualizarlo en su
                        tabla</p>
                </div>
            </form>

        </div>
    </div>
</div>