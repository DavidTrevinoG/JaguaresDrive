<?php


if(isset($_GET['viaje'])){

    $id_viaje = $_GET['viaje'];
    $id_usuario = $_GET['id_usuario'];

    include_once '../../bd/conexion.php';

    $objConexion = new Conexion();
    $conexion = $objConexion->conectar();

    $sql = "DELETE FROM viaje WHERE id_viaje = '$id_viaje'";
    $result = $conexion->query($sql);

    if($result){
        header("Location: ../../drive/solicitudes.php?id_usuario=$id_usuario");
    }else{
        echo $sql;
        echo "Error al aceptar la solicitud";
    }

}

?>