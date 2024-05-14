<?php
// Incluir el archivo de conexión a la base de datos u otras clases necesarias
require_once '../bd/conexion.php';
require_once '../models/Usuario.php'; // Asegúrate de especificar la ruta correcta

// Verificar si se han enviado datos mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidoPaterno = $_POST['apellido1'];
    $apellidoMaterno = $_POST['apellido2'];
    $fechaNacimiento = $_POST['nacimiento'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $matricula = $_POST['matricula'];
    $contrasena = $_POST['contrasena'];
    $placasAuto = $_POST['placas'];
    $modeloAuto = $_POST['molda'];
    $colorAuto = $_POST['col'];
    $marcaAuto = $_POST['marca'];

    // Obtener el ID del conductor a actualizar desde la URL
    if(isset($_GET['id_conductor'])) {
        $idConductor = $_GET['id_conductor'];
        
        // Crear una instancia de UsuarioModel y llamar al método actualizarConductor
        $usuarioModel = new UsuarioModel();
        $resultado = $usuarioModel->actualizarConductor($idConductor, $nombre, $apellidoPaterno, $apellidoMaterno, $fechaNacimiento, $correo, $telefono, $matricula, $contrasena, $placasAuto, $modeloAuto, $colorAuto, $marcaAuto);

        if ($resultado) {
            // Éxito al actualizar los datos
            echo "<script>alert('Los datos del conductor se actualizaron correctamente.'); window.location.href = 'conductor.php';</script>";
        } else {
            // Error al actualizar los datos
            echo "<script>alert('Error al actualizar los datos del conductor.');</script>";
        }
    } else {
        // ID de conductor no proporcionado, manejar el error según sea necesario
        echo "<script>alert('ID de conductor no válido.');</script>";
    }
} else {
    // Redireccionar si no se recibieron datos por POST
    header("Location: editar_conductor.php?id_usuario=" . $_GET['id_conductor']);
    exit();
}
?>
