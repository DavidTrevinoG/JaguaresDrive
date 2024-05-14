<?php
require_once '../../bd/conexion.php';
$conexion_bd = new Conexion();
$conexion = $conexion_bd->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_conductor = $_GET['id_usuario'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $fecha_nacimiento = $_POST['nacimiento'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $matricula = $_POST['matricula'];
    $contrasena = $_POST['contrasena'];
    $carrera = $_POST['carrera'];

    // Actualizar la tabla usuario
    $query_usuario = "UPDATE usuario 
                    SET  matricula=?, nombre=?, apellido_p=?, apellido_m=?, fecha_nac=?, correo=?,   contrasena=?,telefono=?, id_carrera=? 
                    WHERE usuario_id=?";
    $statement_usuario = $conexion->prepare($query_usuario);
    $statement_usuario->bind_param("isssssssii", $matricula, $nombre, $apellido1, $apellido2, $fecha_nacimiento, $correo, $contrasena, $telefono, $carrera,$id_conductor);
    $statement_usuario->execute();

    

    

    // Redireccionar a alguna página después de la actualización
    header("Location: ../editar.php?id_usuario=" . $id_conductor);

}
?>
