<?php

include '../bd/conexion.php';

if (isset($_POST['iniciosesion'])) {
    $username = $_POST["username"];
    $contra = $_POST["contra"];

    $sql = "SELECT * FROM usuario WHERE correo = '$username' AND contrasena = '$contra'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            header("Location: ../views/index.php");
        }
    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}

if(isset($_POST["registro"])) {
	$matricula = $_POST["matricula"];
	$nombre = $_POST["nombre"];
	$apellidoPat = $_POST["apellido_p"];
	$apellidoMat = $_POST["apellido_m"];
	$fechaNacimiento = $_POST["fecha_nac"];
	$email = $_POST["correo"];
	$contra = $_POST["contra"];
	$carrera = $_POST["carrera"];
	$telefono = $_POST["telefono"];
	
	$sql_registro = "INSERT INTO usuario( nombre, apellido_p, apellido_m, fecha_nac, correo, contrasena, carrera, telefono, matricula )
						VALUES ('$nombre', '$apellidoPat', '$apellidoMat', STR_TO_DATE('$fechaNacimiento', '%Y-%m-%d'), '$email', '$contra', '$carrera', '$telefono', '$matricula');";
    
    $result = $conn->query($sql_registro);

    header("Location: ../../index.php");
}


if(isset($_POST['registro_conductor'])) {
    $nombre = $_POST['nom'];
    $apellido_materno = $_POST['apem'];
    $apellido_paterno = $_POST['apep'];
    $fecha_nacimiento = $_POST['fechan'];
    $email = $_POST['email'];
    $contrasena = $_POST['contra'];
    $telefono = $_POST['tel'];
    $matricula = $_POST['matricula'];

    // Vehiculo
    $placas = $_POST['placas'];
    $modelo = $_POST['mode'];
    $color = $_POST['col'];
    $marca = $_POST['marca'];

    // Inserción de usuario
    $sql = "INSERT INTO usuario (matricula, nombre, apellido_p, apellido_m, fecha_nac, correo, contrasena, telefono) 
                VALUES ('$matricula', '$nombre', '$apellido_paterno', '$apellido_materno', '$fecha_nacimiento', '$email', '$contrasena', '$telefono')";
    $result = $conn->query($sql);

    if(!$result) {
        echo 'Usuario no registrado';
    } else {
        // Suponiendo que solamente hay un usuario con dicha matrícula
        $id_usuario =  $conn->insert_id; // Obtiene el ID de la última inserción

        // Inserción de Vehiculo
        $sql_vehiculo = "INSERT INTO vehiculo (Placas, Color, Marca, Modelo)
                            VALUES ('$placas', '$color', '$marca', '$modelo')";
        $result_vehiculo = $conn->query($sql_vehiculo);

        if(!$result_vehiculo) {
            echo 'Vehiculo no registrado';
        } else {
            $id_vehiculo = $conn->insert_id;
            // Inserción de Conductor
            $sql_conductor = "INSERT INTO conductor (usuario_id, ID_vehiculo, Estado_disponibilidad)
                                VALUES ('$id_usuario', '$id_vehiculo', '1')";
            $result_conductor = $conn->query($sql_conductor);

            if(!$result_conductor) {
                echo 'Conductor no registrado';
            } else {
                echo '<h1>Conductor agregado correctamente</h1>';
            }
        }
    }
}

if(isset($_POST['registro_pasajero'])) {
    $nombre = $_POST['nom'];
    $apellido_materno = $_POST['apem'];
    $apellido_paterno = $_POST['apep'];
    $fecha_nacimiento = $_POST['fechan'];
    $email = $_POST['email'];
    $contrasena = $_POST['contra'];
    $telefono = $_POST['tel'];
    $matricula = $_POST['mat'];

    // Inserción de usuario
    $sql = "INSERT INTO usuario (matricula, nombre, apellido_p, apellido_m, fecha_nac, correo, contrasena, telefono) 
                VALUES ('$matricula', '$nombre', '$apellido_paterno', '$apellido_materno', '$fecha_nacimiento', '$email', '$contrasena', '$telefono')";
    $result = $conn->query($sql);

    if(!$result) {
        echo 'Usuario no registrado';
    } else {
        // Suponiendo que solamente hay un usuario con dicha matrícula
        $id_usuario =  $conn->insert_id; // Obtiene el ID de la última inserción

        // Inserción de Conductor
        $sql_pasajero = "INSERT INTO pasajero (usuario_id)
                            VALUES ('$id_usuario')";
        $result_pasajero = $conn->query($sql_pasajero);

        if(!$result_pasajero) {
            echo 'Pasajero no registrado';
        } else {
            echo '<h1>Pasajero agregado correctamente</h1>';
        }
    }
}
