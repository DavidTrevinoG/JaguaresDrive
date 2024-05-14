<?php
include_once '../bd/conexion.php'; 
// Crear una instancia de la clase Conexion
$conexion_bd = new Conexion();
$conexion = $conexion_bd->conectar();

session_start();

// Verificar si el usuario ha iniciado sesión y tiene el rol de pasajero
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'pasajero') {
    // Usuario no autenticado o no tiene el rol de pasajero, redirigir a la página de inicio de sesión
    header("Location: index.php");
    exit;
}

// Obtener el nombre de usuario de las variables de sesión
$nombreUsuario = "";

// Obtener el nombre de usuario desde la base de datos utilizando el ID de usuario almacenado en la sesión
$usuarioId = $_SESSION['usuario_id'];
$sql = "SELECT nombre, apellido_p, apellido_m, fecha_nac, telefono, matricula, correo,contrasena,foto,id_carrera FROM usuario WHERE usuario_id = $usuarioId";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombreUsuario = $row['nombre'];
    $apellidoPaterno = $row['apellido_p'];
    $apellidoMaterno = $row['apellido_m'];
    $fechaNacimiento = $row['fecha_nac'];
    $telefono = $row['telefono'];
    $matricula = $row['matricula'];
    $correo = $row['correo'];
    $contrasena = $row['contrasena'];
    $imagen = $row['foto'];
    $carrera = $row['id_carrera'];
} else {
    // No se encontró el usuario en la base de datos, manejar el error según sea necesario
    // Por ejemplo, redirigir al usuario a la página de inicio de sesión con un mensaje de error
    header("Location: index.php?error=user_not_found");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>JAGUARES DRIVE</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="icon" href="public/images/logo-jaguares-drive.png" type="image/png" sizes="512x512">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/diseño_editar.css">

    <!-- Enlace al icono para la pestaña -->
    <link rel="icon" href="img/logo.png" type="image/x-icon">

    <style>
        /* Estilos del precargador */
        #preloader {
           position: fixed;
           top: 0;
           left: 0;
           width: 100vw;
           height: 100vh;
           background-color: rgba(255, 255, 255, 0.8);
           display: flex;
           align-items: center;
           justify-content: center;
           z-index: 9999;
       }

       /* Estilos del ícono de carro */
       .car-icon {
           font-size: 3rem;
           color: #000000;
           position: absolute;
           left: 0;
           top: 50%;
           transform: translateY(-50%);
           animation: moveCar 1.5s linear infinite;
       }

       /* Animación de movimiento para el ícono de carro */
       @keyframes moveCar {
           0% {
               left: 0;
           }
           100% {
               left: 90%;
           }
       }

       #sidebar {
           width: 250px;
           height: 100vh;
           background-color: rgba(46, 46, 46);
           color: #fff;
           display: flex;
           flex-direction: column;
           align-items: center;
           padding: 20px;
           box-shadow: 2px 0 5px rgba(0, 0, 0, 0.3);
       }

       .menu .menu-item {
           margin-top: 40px; /* Ajusta este valor según sea necesario */
       }

       #content {
           flex-grow: 1; /* Permite que el contenido principal ocupe todo el espacio restante */
           padding: 20px; /* Añade un poco de espacio alrededor del contenido */
       }
    </style>
</head>
<body>

    <!-- Precargador -->
    <div id="preloader">
        <!-- Usar un ícono de Font Awesome de carro con animación -->
        <i class="fas fa-car car-icon"></i>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Escucha el evento DOMContentLoaded, que se dispara cuando el contenido de la página está listo
            const preloader = document.getElementById('preloader');
            // Oculta el precargador después de un breve tiempo (ajusta este tiempo según sea necesario)
            setTimeout(() => {
                preloader.style.display = 'none';
            }, 1000); // Puedes ajustar este tiempo según sea necesario
        });
    </script>
    <!--Fin de precargador-->

    <div id="sidebar">
        <div class="avatar-container">
            <img src="img\icono-usuario.png" alt="Avatar" class="avatar-img">
        </div>

        <div class="menu">
            <label for="matricula" style="display: block; text-align: center;" class="white-text"><b><?php echo $matricula?></b></label>
            <a href="pasajero.php" class="menu-item"><i class="fas fa-location-dot"></i> Ruta</a>
            <a href="editar.php" class="menu-item"><i class="fa-solid fa-gear"></i> Perfil</a>
            <a href="index.php" class="menu-item" onclick="confirmarCerrarSesion(event)"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
        </div>
    </div>

        <div id="content">
            <div class="container-content">
                <!-- Icono de imagen con evento de clic -->
               
            <!-- Input oculto para cargar imagen -->
            <input type="file" id="input-imagen" style="display: none;" accept="image/*"> <!-- Icono en la posición izquierda superior -->
            <form action="crud/cambiar_rol.php" method="post">
                <button type="submit" name="rol_pasajero" value="conductor" class="btn btn-lg btn-purple float-right">Cambiar a Conductor</button>
            </form>
            <form action="crud/editar_pasajero.php?id_usuario=<?php echo $usuarioId; ?>" method="post">
            <button type="submit" id="btn-actualizar" class="btn btn-lg btn-purple float-right">Actualizar</button> <!-- Botón de Actualizar --> <!-- Botón de Actualizar -->

            <div class="avatar-container-large">
                <centering>
                    <label for="input-imagen" class="position-absolute top-0 start-0">
                        <img src="fotos_perfil/<?php echo $imagen; ?>" class="card-img-top rounded-circle" alt="<?php echo $imagen; ?>" style="width:130px; height: 130px;">
                    </label>
                </centering>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-4">
                    <div class="form-group text-center">
                        <label for="nombre" class="text-center">Nombre:</label>
                        <input type="text" class="form-control text-center" id="nombre" name="nombre" placeholder="Ingrese su nombre" value="<?php echo $nombreUsuario; ?>" required>
                    </div>
                    <div class="form-group text-center">
                        <label for="apellido1" class="text-center">Apellido Paterno:</label>
                        <input type="text" class="form-control text-center" id="apellido1" name="apellido1" placeholder="Ingrese apellido paterno" value="<?= $apellidoPaterno?>" required>
                    </div>
                    <div class="form-group text-center">
                        <label for="apellido2" class="text-center">Apellido Materno:</label>
                        <input type="text" class="form-control text-center" id="apellido2" name="apellido2" placeholder="Ingrese apellido materno" value="<?= $apellidoMaterno?>" required>
                    </div>
                    <div class="form-group text-center">
                        <label for="nacimiento" class="text-center">Fecha de Nacimiento:</label>
                        <input type="date" class="form-control text-center" id="nacimiento" name="nacimiento" value="<?= $fechaNacimiento?>" max="<?php echo date('Y-m-d', strtotime('-17 years')); ?>" required>
                    </div>
                    <div class="form-group text-center">
                        <label for="telefono" class="text-center">Teléfono:</label>
                        <input type="tel" class="form-control text-center" id="telefono" name="telefono" placeholder="Ingrese su número de teléfono" value="<?= $telefono?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group text-center">
                        <label for="matricula" class="text-center">Matrícula:</label>
                        <input type="text" class="form-control text-center" id="matricula" name="matricula" placeholder="Ingrese su matrícula" value="<?= $matricula?>" readonly>
                    </div>
                    <div class="form-group text-center">
                        <label for="correo" class="text-center">Correo Electrónico:</label>
                        <input type="email" class="form-control text-center" id="correo" name="correo" placeholder="Ingrese su correo electrónico" value="<?= $correo?>" required>
                    </div>
                    <div class="form-group text-center">
                        <label for="contrasena" class="text-center">Contraseña:</label>
                        <input type="password" class="form-control text-center" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" value="<?= $contrasena?>" required>
                    </div>
                    <div class="form-group text-center">
                        <label for="carrera" class="text-center">Carrera:</label>
                        <select class="form-control text-center" id="carrera" name="carrera" required>
                            <?php
                            // Consultar todas las carreras de la base de datos
                            $query = "SELECT id_carrera, nombre FROM carreras";
                            $result = $conexion->query($query);

                            // Verificar si hay resultados
                            if ($result->num_rows > 0) {
                                // Iterar sobre los resultados y crear opciones para el select
                                while ($row = $result->fetch_assoc()) {
                                    // Verificar si esta opción está seleccionada
                                    $selected = ($row['id_carrera'] == $carrera) ? 'selected' : '';
                                    echo "<option value='" . $row['id_carrera'] . "' $selected>" . $row['nombre'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>No hay carreras disponibles</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group text-center">
                    </div>
                </div>
            </div>
        </form>

        </div>
    </div>
    
    
    <script>
        function confirmarCerrarSesion(event) {
            event.preventDefault(); // Evita el comportamiento predeterminado del evento

            Swal.fire({
                title: "¿Estás seguro de cerrar sesión?",
                text: "Se cerrará tu sesión actual.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "purple",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, cerrar sesión",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirige al usuario a la página de inicio de sesión (login.html)
                    window.location.href = "index.php";
                }
            });
        }
    </script>
  <!--  <script>
        // Captura el evento de cambio del input de tipo archivo
        document.getElementById('input-imagen').addEventListener('change', function(event) {
            // Obtiene el archivo seleccionado
            const file = event.target.files[0];
            // Crea un objeto URL para la imagen seleccionada
            const imageUrl = URL.createObjectURL(file);
            // Actualiza la imagen del avatar con la imagen seleccionada
            document.getElementById('avatar-img').src = imageUrl;
        });
    </script>
    <script>
        // Función para mostrar la alerta de actualización de datos
        function mostrarAlertaActualizar(event) {
            event.preventDefault(); // Evita el comportamiento predeterminado del evento
    
            Swal.fire({
                title: "¿Estás seguro de actualizar tus datos?",
                text: "Se actualizarán tus datos personales.",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "purple",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, actualizar datos",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí puedes agregar la lógica para realizar la actualización de datos
                    // Por ejemplo, enviar una solicitud al servidor para guardar los cambios
                    // Luego podrías mostrar una confirmación de que los datos se han actualizado correctamente
                    Swal.fire({
                        title: "Datos actualizados",
                        text: "Tus datos se han actualizado correctamente.",
                        icon: "success",
                        confirmButtonColor: "purple"
                    });
                }
            });
        }
    
        // Agrega el evento de clic al botón de "Actualizar"
        document.getElementById('btn-actualizar').addEventListener('click', mostrarAlertaActualizar);
    </script>-->
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-Xe8FIISpaF1FODdP7IjFmzHeGeFZhUByu2DdTm6l5on5Cv5uUZcXnKjpBy6QhpF4" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js
