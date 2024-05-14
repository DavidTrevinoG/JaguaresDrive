<?php

session_start();
$usuarioId = $_SESSION['usuario_id'];
$usuarioId = $_GET['id_usuario'];

?>

<?php

include_once '../bd/conexion.php';

$objConexion = new Conexion();
$conexion = $objConexion->conectar();

$query = "SELECT * FROM pasajero WHERE usuario_id = '$usuarioId'";
$result = $conexion->query($query);
$row = $result->fetch_assoc();
$id_pasajero = $row['pasajero_id'];


$query = "SELECT * FROM viaje WHERE id_pasajero = '$id_pasajero'";
$result = $conexion->query($query);
$viaje = $result->fetch_assoc();
$id_conductor = $viaje['id_conductor'];


$query = "SELECT * FROM conductor WHERE id_conductor = '$id_conductor'";
$result = $conexion->query($query);
$row = $result->fetch_assoc();
$id_usuarioConductor = $row['usuario_id'];
$id_vehiculo = $row['ID_vehiculo'];


$query = "SELECT * FROM usuario WHERE usuario_id = '$id_usuarioConductor'";
$result = $conexion->query($query);
$row = $result->fetch_assoc();
$nombreConductor = $row['nombre']." ".$row['apellido_p']." ".$row['apellido_m'];
$telefono = $row['telefono'];
$carrera = $row['carrera'];
$foto = $row['foto'];   

$query = "SELECT * FROM vehiculo WHERE ID_vehiculo = '$id_vehiculo'";
$result = $conexion->query($query);
$row = $result->fetch_assoc();
$marca = $row['Marca'];
$modelo = $row['Modelo'];
$color = $row['Color'];
$placas = $row['Placas'];

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
    <link rel="stylesheet" href="css/diseño_viaje.css">

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
        <label for="matricula" style="display: block; text-align: center;" class="white-text"><b></b></label>

        <nav class="menu">
        <a href="pasajero.php" class="menu-item"><i class="fas fa-location-dot"></i> Viajes disponibles</a>
        <a href="viaje.php" class="menu-item"><i class="fa-solid fa-car"></i> Mi viaje</a>
        <a href="editar.php" class="menu-item"><i class="fa-solid fa-gear"></i> Perfil</a>
        <a href="index.php" class="menu-item" onclick="confirmarCerrarSesion(event)"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
        </nav>
    </div>

    <div id="content">
        <div class="container-content">
            <h2><i class="fa-solid fa-check"></i> Viaje <?php
            
                if($viaje['estado'] == 0){
                    echo "en espera de confirmación..";
                } else {
                    echo "Aceptado!";
                }
            
            ?></h2>
            <div class="inner-container d-flex flex-column" style="position: relative;">
                <label for="descripcion-viaje" style="font-weight: bold;">Información del Conductor</label>
                <div style="display: flex; align-items: center;">
                    <div class="avatar-container" style="width: 50px; height: 50px; margin-right: 10px;">
                        <img src="fotos_perfil/<?php echo $foto; ?>" alt="Foto de perfil" class="avatar-img">
                    </div>
                    <div style="flex-grow: 1;"> <!-- Esto permite que el nombre de usuario ocupe todo el espacio disponible -->
                        <label for="name_usuario" style="margin: 0; text-align: right;"><?php echo $nombreConductor; ?></label>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <label for="hora" style="margin-right: 150px; color: gray;">Número de teléfono:<?php echo $telefono; ?></label>
                        <label for="hora" style="margin-right: 150px; color: gray;">Punto de encuentro: <?php echo $viaje['punto_encuentro']; ?></label>
                        <label for="hora" style="margin-right: 150px; color: gray;">Hora de Salida: <?php echo $viaje['hora_viaje']; ?></label>
                        
                    </div>
                </div>
                <label for="descripcion-viaje" style="font-weight: bold;">Informacion del carro</label><!-- Etiqueta para la descripción del viaje -->
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        <label for="hora" style="margin-right: 40px; color: gray;">Marca del carro: <?php echo $marca;?></label>
                        <label for="hora" style="margin-right: 40px; color: gray;">Modelo del auto: <?php echo $modelo;?></label>
                        <label for="hora" style="margin-right: 40px; color: gray;">Color del carro: <?php echo $color;?></label>
                        <label for="hora" style="margin-right: 40px; color: gray;">Placas: <?php echo $placas;?></label>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <div>
                        
                    </div>
                </div>
            
            </div>
            
        </div>
    </div>
    
    
    <script>
        function confirmarCerrarSesion(event) {
            event.preventDefault(); 

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