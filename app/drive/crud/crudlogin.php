<?php
include_once '../../bd/conexion.php'; 

// Iniciar sesión
session_start();

// Verificar si se han enviado datos mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombreUsuario = $_POST['nombre'];
    $contrasena = $_POST['pass'];
    $userRole = $_POST['user-role'];

    $conexion = new Conexion();
    $mysqli = $conexion->conectar();

    // Consulta para verificar la existencia del usuario en la tabla 'usuario'
    $sql = "SELECT * FROM usuario WHERE matricula = '$nombreUsuario' AND contrasena = '$contrasena'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        // El usuario y la contraseña existen en la tabla 'usuario'
        $row = $result->fetch_assoc();
        $usuarioId = $row['usuario_id'];
        $rol = $row['rol'];

        // Establecer variables de sesión
        $_SESSION['usuario_id'] = $usuarioId;
        $_SESSION['rol'] = $rol;

        // Redirigir según el rol del usuario
        if ($userRole == 1 && $rol == 'conductor') {
            // El usuario es conductor
            header("Location: ../conductor.php");
            exit;
        } elseif ($userRole == 2 && $rol == 'pasajero') {
            // El usuario es pasajero
            header("Location: ../pasajero.php");
            exit;
        } else {
            //El usuario seleccionó un rol incorrecto o no coincide con el rol en la base de datos
            echo "<script>alert('El usuario no tiene acceso con el rol seleccionado.');history.back();</script>";

        }
    } else {
        //El usuario o la contraseña son incorrectos
        echo "<script>alert('Usuario o contraseña incorrectos.');history.back();</script>";
    }

}
?>
    