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
    $placas = $_POST['placas'];
    $modelo = $_POST['molda'];
    $color = $_POST['col'];
    $marca = $_POST['marca'];
    $licencia = $_POST['licencia'];
    $disponibilidad = $_POST['disponibilidad'];

    // Actualizar la tabla usuario
    $query_usuario = "UPDATE usuario 
                    SET  matricula=?, nombre=?, apellido_p=?, apellido_m=?, fecha_nac=?, correo=?,   contrasena=?,telefono=?, id_carrera=? 
                    WHERE usuario_id=?";
    $statement_usuario = $conexion->prepare($query_usuario);
    $statement_usuario->bind_param("isssssssii", $matricula, $nombre, $apellido1, $apellido2, $fecha_nacimiento, $correo, $contrasena, $telefono, $carrera,$id_conductor);
    $statement_usuario->execute();

    // Actualizar la tabla conductor
    $query_conductor = "UPDATE conductor 
                        SET Num_licencia_conducir=?, Estado_disponibilidad=? 
                        WHERE usuario_id=?";
    $statement_conductor = $conexion->prepare($query_conductor);
    $statement_conductor->bind_param("sis", $licencia, $disponibilidad, $id_conductor);
    $statement_conductor->execute();

    // Verificar y actualizar la tabla vehiculo
    $query_check_vehicle = "SELECT ID_vehiculo FROM conductor WHERE usuario_id=? AND ID_vehiculo IS NULL";
    $statement_check_vehicle = $conexion->prepare($query_check_vehicle);
    $statement_check_vehicle->bind_param("i", $id_conductor);
    $statement_check_vehicle->execute();
    $result_check_vehicle = $statement_check_vehicle->get_result();


    


    if ($result_check_vehicle->num_rows > 0) {
        // Si el conductor no tiene vehículo asignado, insertar un nuevo registro en la tabla vehiculo
        $query_insert_vehicle = "INSERT INTO vehiculo (Placas, Color, Marca, Modelo) VALUES (?, ?, ?, ?)";
        $statement_insert_vehicle = $conexion->prepare($query_insert_vehicle);
        $statement_insert_vehicle->bind_param("ssss", $placas, $color, $marca, $modelo);
        $statement_insert_vehicle->execute();

        // Obtener el ID del vehículo insertado
        $id_vehiculo = $statement_insert_vehicle->insert_id;

        // Actualizar el campo ID_vehiculo en la tabla conductor
        $query_update_conductor = "UPDATE conductor SET ID_vehiculo=? WHERE usuario_id=?";
        $statement_update_conductor = $conexion->prepare($query_update_conductor);
        $statement_update_conductor->bind_param("ii", $id_vehiculo, $id_conductor);
        $statement_update_conductor->execute();
    } else {
        $query_check_vehicle = "SELECT ID_vehiculo FROM conductor WHERE usuario_id=?";
        $statement_check_vehicle = $conexion->prepare($query_check_vehicle);
        $statement_check_vehicle->bind_param("i", $id_conductor);
        $statement_check_vehicle->execute();
        $result_check_vehicle = $statement_check_vehicle->get_result();
        // Si el conductor ya tiene vehículo asignado, actualizar los detalles del vehículo
        $row_vehicle = $result_check_vehicle->fetch_assoc();
        $id_vehiculo = $row_vehicle['ID_vehiculo'];

        $query_update_vehicle = "UPDATE vehiculo SET Placas=?, Color=?, Marca=?, Modelo=? WHERE ID_vehiculo=?";
        $statement_update_vehicle = $conexion->prepare($query_update_vehicle);
        $statement_update_vehicle->bind_param("ssssi", $placas, $color, $marca, $modelo, $id_vehiculo);
        $statement_update_vehicle->execute();
    }

    // Redireccionar a alguna página después de la actualización
    header("Location: ../editar_conductor.php?id_usuario=" . $id_conductor);

}
?>
