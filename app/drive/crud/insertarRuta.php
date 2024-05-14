<?php

include_once '../../bd/conexion.php';

$objConexion = new Conexion();
$conexion = $objConexion->conectar();

if(isset($_POST['insertar_ruta'])){

    $start = $_POST['partida'];

    $direcciones = $start." | ";

    // Iterar sobre los inputs
    $i = 1;
    while (isset($_POST["input{$i}"])) {
        $input = trim($_POST["input{$i}"]);
        $direcciones .= $_POST["input{$i}"]."|";
        $i++;
    }

    $id_conductor = $_POST['id_usuario'];
    $coordenadas = $_POST['coordenadas2'];
    $costo = $_POST['costo'];
    $hora = $_POST['hora'];
    $descripcion = $_POST['descripcion'];


    $query = "SELECT * FROM conductor WHERE usuario_id = '$id_conductor'";
    $result = $conexion->query($query);
    $row = $result->fetch_assoc();
    $id_conductor = $row['id_conductor'];
    
    $verificacion = "DELETE FROM viaje WHERE id_conductor = '$id_conductor'";
    $conexion->query($verificacion);
   
    $verificacion = "DELETE FROM ruta WHERE id_conductor = '$id_conductor'";
    $conexion->query($verificacion);

    if($row['ID_vehiculo'] == null){
        echo "<script>alert('No tienes un vehiculo registrado, por favor registra uno para poder publicar rutas');";
        echo "window.location.href='../../drive/conductor.php';</script>";
    } else {
        $sql = "INSERT INTO ruta (id_conductor, puntos, direcciones, costo_viaje, duracion, descripcion, estado) VALUES ('$id_conductor', '$coordenadas', '$direcciones', '$costo', '$hora', '$descripcion', 'Activo');";
        echo $sql;
        $result = $conexion->query($sql);
        
        if($result){
           header("Location: ../../drive/conductor.php");
        }
    }

  
    
}

?>