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
// Por ejemplo, si tienes una conexión a la base de datos llamada $conexion, podrías hacer algo como esto:
$usuarioId = $_SESSION['usuario_id'];
$sql = "SELECT nombre FROM usuario WHERE usuario_id = $usuarioId";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nombreUsuario = $row['nombre'];
} else {
    // No se encontró el usuario en la base de datos, manejar el error según sea necesario
    // Por ejemplo, redirigir al usuario a la página de inicio de sesión con un mensaje de error
    header("Location: index.php?error=user_not_found");
    exit;
}
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC9TPtQVo1d15jPaORSaA082SlBqiv_f8s&libraries=places"></script>
    <link rel="stylesheet" href="css/diseño_pasajero.css">
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
            background-color: rgb(46, 46, 46);
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
        #main-container {
            display: flex; /* Configura el diseño de la fila para contener el sidebar a la izquierda y el contenido a la derecha */
        }
        
    </style>
</head>

<body>
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

    <div id="sidebar">
        <div class="avatar-container">
            <img src="img/icono-usuario.png" alt="Avatar" class="avatar-img">
            <label for="matricula" class="matricula-label"><b>2130155</b></label>
        </div>
        <nav class="menu">
            <a href="pasajero.php" class="menu-item"><i class="fas fa-location-dot"></i> Viajes disponibles</a>
            <a href="viaje.php?id_usuario=<?php echo $usuarioId; ?>" class="menu-item"><i class="fa-solid fa-car"></i> Mi viaje</a>
            <a href="editar.php" class="menu-item"><i class="fa-solid fa-gear"></i> Perfil</a>
            <a href="cerrar_sesion.php" class="menu-item" onclick="confirmarCerrarSesion(event)"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
        </nav>
    </div>

    <!-- Resto del contenido HTML -->
    <div id="content">
        <!-- Añade aquí el contenido de tu página -->
        <h1>Bienvenid@ <?= $nombreUsuario ?></h1>
        <br>
        <div class="container-content">
            <?php
            // Query to fetch all routes from the "rutas" table
            $sql = "SELECT * FROM ruta";
            $result = $conexion->query($sql);
            $cont = 0;

            if ($result->num_rows > 0) {
                // Loop through each row of the result set
                while ($row = $result->fetch_assoc()) {
                    $cont++;

                    $check = "SELECT * FROM conductor WHERE id_conductor = " . $row['id_conductor'];
                    $result2 = $conexion->query($check);
                    $row2 = $result2->fetch_assoc();

                    $check = "SELECT * FROM usuario WHERE usuario_id = " . $row2['usuario_id'];
                    $result3 = $conexion->query($check);
                    $row3 = $result3->fetch_assoc();

                    echo "<p><b>Conductor:</b> " . $row3['nombre'] . " " . $row3['apellido_p'] . " " . $row3['apellido_m'] . "</p>";

                    $check = "SELECT * FROM vehiculo WHERE ID_vehiculo = " . $row2['ID_vehiculo'];
                    $result4 = $conexion->query($check);
                    $row4 = $result4->fetch_assoc();

                    echo "<p><b>Vehículo:</b> " . $row4['Marca'] . " " . $row4['Modelo'] . " " . $row4['Color'] . " " . $row4['Placas'] . "</p>";

                    // Display the route information
                    echo "<p>Route ID: " . $row['id_ruta'] . "</p>";
                    echo "<p><b>Descripción:</b> " . $row['descripcion'] . "</p>";
                    echo "<p><b>Costo: </b> $" . $row['costo_viaje'] . " | <b> Hora de Salida: </b>" . $row['duracion'] . " </p>";
      
                    echo " <div id='mapa".$cont."' style='width: 100%; height: 400px;'></div>";
                    echo "<br>";
                    echo '<form method="POST" action="crud/solicitar_ruta.php">
                    <input type="hidden" name="ruta" value="'.$row['id_ruta'].'">
                    <input type="hidden" name="id_us" value="'.$usuarioId.'">
                    <input type="hidden" name="hora" value="'.$row['duracion'].'">
           
                    <div class="form-row">
                        <label class="input-container" style="display: flex; align-items: center;">
                            <input type="text" class="form-control" placeholder="Punto de Encuentro.." name="punto_encuentro" id="punto_encuentro" width="50%" required>
                            <input type="submit" value="Solicitar" name="solicitar" class="btn btn-success" style="margin-left: 10px;">
                        </label>
                    </div>
                    
                    </form>';
                  
                    echo "<hr>";
                    echo "<script>
                    function iniciarMap".$cont."() {
                        // Configura el mapa
                        var mapOptions = {
                            center: { lat: 23.728058, lng: -99.077465 },
                            zoom: 12, 
                        };
                      
                        // Crea el mapa
                        var map = new google.maps.Map(document.getElementById('mapa".$cont."'), mapOptions);
                      
                        // Configura la solicitud de direcciones
                        var directionsService = new google.maps.DirectionsService();
                        var directionsRenderer = new google.maps.DirectionsRenderer();
                        directionsRenderer.setMap(map);
                    
                        // Define los puntos de inicio y fin y los puntos intermedios (waypoints)";

                        $cadena = $row['puntos'];
                        $puntos = explode("|", $cadena);

                        echo "
                        var start = new google.maps.LatLng(".$puntos[0]."); // Ubicación de inicio
                        var end = new google.maps.LatLng(23.729029, -99.077182); // Ubicación de fin
                        var waypoints = [];
                        ";

                        for ($i = 1; $i < count($puntos) - 1; $i++) {
                            echo "waypoints.push({
                                location: new google.maps.LatLng(".$puntos[$i]."),
                                stopover: true
                            });";
                        }
                        echo "
                        // Configura la solicitud de ruta
                        var request = {
                            origin: start,
                            destination: end,
                            waypoints: waypoints,
                            travelMode: 'DRIVING' // Modo de viaje para trazo de ruta
                        };
                      
                        // Obtiene la ruta y muestra en el mapa
                        directionsService.route(request, function(response, status) {
                            if (status === 'OK') {
                                directionsRenderer.setDirections(response);
                            } else {
                                window.alert('Error al mostrar las direcciones: ' + status);
                            }
                        });
                      }
                      iniciarMap".$cont."();
                    </script>";
                }
            } else {
                echo "No routes available.";
            }
            ?>
        </div>
    </div>
    </div>

    <script>
        function mostrarSweetAlertt(nombre) {
            Swal.fire({
                title: "Información del Conductor",
                text: "Nombre: " + nombre,
                showClass: {
                    popup: `
                        animate__animated animate__fadeInUp animate__faster
                    `
                },
                hideClass: {
                    popup: `
                        animate__animated animate__fadeOutDown animate__faster
                    `
                },
                scrollbarPadding: false
            });
        }

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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-Xe8FIISpaF1FODdP7IjFmzHeGeFZhUByu2DdTm6l5on5Cv5uUZcXnKjpBy6QhpF4" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyIx8vHV5z5q1gF94tLl5MDO/aDlO7f5J" crossorigin="anonymous"></script>
</body>

</html>
