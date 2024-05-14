<?php


if(isset($_GET['id_usuario'])){

    $id_usuario = $_GET['id_usuario'];

    include_once '../../bd/conexion.php';

    $objConexion = new Conexion();
    $conexion = $objConexion->conectar();

    $sql = "SELECT * FROM conductor WHERE usuario_id = '$id_usuario'";
    $result = $conexion->query($sql);
    $row = $result->fetch_assoc();
    $id_conductor = $row['id_conductor'];

    $verificacion = "DELETE FROM viaje WHERE id_conductor = '$id_conductor'";
    $result = $conexion->query($verificacion);

    $verificacion = "DELETE FROM ruta WHERE id_conductor = '$id_conductor'";
    $result = $conexion->query($verificacion);

    if($result){
        header("Location: ../../drive/conductor.php");
    }else{
        echo $sql;
        echo "Error al aceptar la solicitud";
    }

}

?>