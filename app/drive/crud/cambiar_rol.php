<?php
include_once '../../bd/conexion.php'; 
// Crear una instancia de la clase Conexion
$conexion_bd = new Conexion();
$conexion = $conexion_bd->conectar();

session_start();

if(isset($_POST['rol_pasajero'])) {
    $id_usuario = $_SESSION['usuario_id']; // Obtener el ID del usuario de alguna manera
    $rol="conductor";
    // Realizar la actualización en la base de datos
    $query = "UPDATE usuario SET rol=? WHERE usuario_id=?";
    $statement = $conexion->prepare($query);
    $statement->bind_param("si", $rol, $id_usuario);
    $statement->execute();
    // Verificar si el usuario ya es conductor
    $query_conductor = "SELECT * FROM conductor WHERE usuario_id=?";
    $statement_conductor = $conexion->prepare($query_conductor);
    $statement_conductor->bind_param("i", $id_usuario);
    $statement_conductor->execute();
    $result_conductor = $statement_conductor->get_result();
    
    if ($result_conductor->num_rows == 0) {
        // Si el usuario no es conductor, insertar en la tabla conductor
        $sql_conductor = "INSERT INTO conductor (usuario_id, Estado_disponibilidad) VALUES (?, 1)";
        $statement_insert_conductor = $conexion->prepare($sql_conductor);
        $statement_insert_conductor->bind_param("i", $id_usuario);
        $statement_insert_conductor->execute();
    }

    $check = "SELECT * FROM pasajero WHERE usuario_id='$id_usuario'";
    $result = mysqli_query($conexion, $check);
    $row = mysqli_fetch_assoc($result);
    $id_pasajero = $row['pasajero_id'];

    $check = "DELETE FROM viaje WHERE id_pasajero='$id_pasajero'";
    $result = mysqli_query($conexion, $check);


    // Redireccionar a alguna página después de la actualización
    header("Location: ../index.php");
}
if(isset($_POST['rol_conductor'])) {
    $id_usuario = $_SESSION['usuario_id']; // Obtener el ID del usuario de alguna manera
    $rol="pasajero";

    // Realizar la actualización en la base de datos
    $query = "UPDATE usuario SET rol=? WHERE usuario_id=?";
    $statement = $conexion->prepare($query);
    $statement->bind_param("si", $rol, $id_usuario);
    $statement->execute();

    // Verificar si el usuario ya es pasajero
    $query_pasajero = "SELECT * FROM pasajero WHERE usuario_id=?";
    $statement_pasajero = $conexion->prepare($query_pasajero);
    $statement_pasajero->bind_param("i", $id_usuario);
    $statement_pasajero->execute();
    $result_pasajero = $statement_pasajero->get_result();
    
    if ($result_pasajero->num_rows == 0) {
        // Si el usuario no es pasajero, insertar en la tabla pasajero
        $sql_pasajero = "INSERT INTO pasajero (usuario_id) VALUES (?)";
        $statement_insert_pasajero = $conexion->prepare($sql_pasajero);
        $statement_insert_pasajero->bind_param("i", $id_usuario);
        $statement_insert_pasajero->execute();
    }

    $check = "SELECT * FROM conductor WHERE usuario_id='$id_usuario'";
    $result = mysqli_query($conexion, $check);
    $row = mysqli_fetch_assoc($result);
    $id_conductor = $row['id_conductor'];

    $sql = "DELETE FROM viaje WHERE id_conductor='$id_conductor'";
    $result = mysqli_query($conexion, $sql);

    $sql = "DELETE FROM ruta WHERE id_conductor='$id_conductor'";
    $result = mysqli_query($conexion, $sql);
    
    // Redireccionar a alguna página después de la actualización
    header("Location: ../index.php");
}
?>
