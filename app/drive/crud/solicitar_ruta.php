<?php


if(isset($_POST['solicitar'])){
    $id_us = $_POST['id_us'];
    $id_viaje = $id_us;
    $id_ruta = $_POST['ruta'];
    $punto_encuentro = $_POST['punto_encuentro'];
    $hora_viaje = $_POST['hora'];

    include_once '../../bd/conexion.php';

    $objConexion = new Conexion();
    $conexion = $objConexion->conectar();

    $query = "SELECT * FROM ruta WHERE id_ruta = '$id_ruta'";
    $result = $conexion->query($query);
    $row = $result->fetch_assoc();
    $id_conductor = $row['id_conductor'];

    $query = "SELECT * FROM pasajero WHERE usuario_id = '$id_us'";
    $result = $conexion->query($query);
    $row = $result->fetch_assoc();
    $id_us = $row['pasajero_id'];

    $eliminar = "DELETE FROM viaje WHERE id_pasajero = '$id_us'";
    $conexion->query($eliminar);

    $sql = "INSERT INTO viaje (id_pasajero, id_ruta, id_conductor, punto_encuentro, hora_viaje, estado) VALUES ('$id_us', '$id_ruta', '$id_conductor', '$punto_encuentro', '$hora_viaje','0');";
    $result = $conexion->query($sql);

    if($result){
       header("Location: ../../drive/viaje.php?id_usuario=$id_viaje");
    }else{
        echo $sql;
        echo "Error al solicitar la ruta";
    }
}

?>