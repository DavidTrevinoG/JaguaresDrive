<?php
require_once '../models/Usuario.php';

class UserController {
    public function registrarUsuario() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $matricula = $_POST['mat'];
            $nombre = $_POST['nombre'];
            $apellido_paterno = $_POST['apep'];
            $apellido_materno = $_POST['apem'];
            $fecha_nacimiento = $_POST['fecha'];
            $correo = $_POST['correo'];
            $telefono = $_POST['tele'];
            $contrasena = $_POST['pass'];
            $rol = $_POST['user-role'];

            // Crear un objeto Usuario con los datos del formulario
            $usuario = new Usuario(null, $matricula, $nombre, $apellido_paterno, $apellido_materno, $fecha_nacimiento, $correo, $contrasena, null, $telefono);

            // Crear una instancia de UsuarioModel
            $usuarioModel = new UsuarioModel();

            // Insertar el usuario
            if ($usuarioModel->insertarUsuario($usuario)) {
                echo "Registro exitoso";
            } else {
                echo "Error al registrar el usuario";
            }
        }
    }
}

$userController = new UserController();
$userController->registrarUsuario();

?>