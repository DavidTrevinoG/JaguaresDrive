<?php

$id_usuario = $_GET['id_usuario'];

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
    <link rel="stylesheet" href="css/diseño_conductor.css">

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

        #map-container {
            height: 500px;
            width: 100%;
            overflow: hidden; /* Evita que el mapa genere barras de desplazamiento */
        }

        .solicitud-container {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            flex-grow: 0; /* Evita el crecimiento automático de las solicitudes */
            height: 300px; /* Deja que la altura sea automática */
        }

        .solicitud-content {
            padding: 10px;
        }

        .solicitud-container ul {
            margin: 0;
            padding: 0;
            max-height: 200px; /* Ajusta la altura máxima según sea necesario */
            overflow-y: auto; /* Agrega barra de desplazamiento vertical si el contenido excede la altura máxima */
        }

        .botones-container {
            display: flex;
            justify-content: center;
            margin-top: 20px; /* Ajusta el margen superior según sea necesario */
        }

        .botones-container button {
            margin: 0 10px; /* Ajusta el margen horizontal entre los botones */
            border: none; /* Elimina el borde de los botones */
            cursor: pointer; /* Cambia el cursor al pasar sobre los botones */
        }

        .botones-container button:focus {
            outline: none; /* Elimina el contorno de enfoque al hacer clic en los botones */
        }

        .container-content {
            display: flex; /* Usamos flexbox para distribuir los elementos en una fila */
            flex-wrap: wrap; /* Permitimos que los elementos se envuelvan a la siguiente línea si no caben en la actual */
            gap: 20px; /* Espacio entre los elementos */
        }

       
        .solicitudes-wrapper {
            display: flex;
            flex-direction: row; /* Cambia 'row-reverse' por 'row' para que los elementos se agreguen de izquierda a derecha */
            gap: 20px; /* Espacio entre los elementos */
            flex-wrap: wrap; /* Permite que las solicitudes se muevan a la siguiente fila si es necesario */
        }
        #content {
            /*width: 80%; *//* Establece un ancho más grande para el contenedor, ajusta según sea necesario */
            margin-left: auto; /* Centra el contenedor horizontalmente */
            margin-right: auto; /* Centra el contenedor horizontalmente */
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
            <a href="conductor.php" class="menu-item"><i class="fas fa-location-dot"></i> Rutas</a>
            <a href="solicitudes.php?id_usuario=<?php echo $id_usuario; ?>" class="menu-item"><i class="fa-solid fa-car"></i> Solicitudes</a>
            <a href="editar_conductor.php?id_usuario=<?php echo $id_usuario; ?>" class="menu-item"><i class="fa-solid fa-gear"></i> Perfil</a>
            <a href="cerrar_sesion.php" class="menu-item" onclick="confirmarCerrarSesion(event)"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
        </nav>
    </div>

    <!-- Resto del contenido HTML -->
    <div id="content">
        <!-- Añade aquí el contenido de tu página -->
        <h1>Solicitudes</h1>
        <div class="container-content">
            <div class="solicitudes-wrapper">
            
            <?php

                    include_once '../bd/conexion.php';

                    $objConexion = new Conexion();
                    $conexion = $objConexion->conectar();

                    $search = "SELECT * FROM conductor WHERE usuario_id = '$id_usuario'";
                    $result = $conexion->query($search);
                    $row = $result->fetch_assoc();
                    $id_conductor = $row['id_conductor'];

 

                    $query = "SELECT * FROM viaje WHERE id_conductor = '$id_conductor'";
                    $resul = $conexion->query($query);
               
            
                    while ($rew = $resul->fetch_assoc()) {

                        $searchU = "SELECT * FROM pasajero WHERE pasajero_id = '".$rew['id_pasajero']."'";
                        $resultU = $conexion->query($searchU);
                        $rowU = $resultU->fetch_assoc();
                        $id_pasajero = $rowU['usuario_id'];

            
                        $check = "SELECT * FROM usuario WHERE usuario_id = '".$id_pasajero."'";
                        $res = $conexion->query($check);
                        $row = $res->fetch_assoc();
                        $nombre = $row['nombre'];
                        $apellido_paterno = $row['apellido_p'];
                        $apellido_materno = $row['apellido_m'];
                        $matricula = $row['matricula'];

                        echo "<div class='solicitud-container' id='solicitud-".$rew['viaje_id']."'>";
                        echo "<div class='solicitud-content'>";
                        echo "<ul>";
                        echo "<li><b>Nombre:</b> ".$nombre."</li>";
                        echo "<li><b>Apellido Paterno:</b> ".$apellido_paterno."</li>";
                        echo "<li><b>Apellido Materno:</b> ".$apellido_materno."</li>";
                        echo "<li><b>Matrícula:</b> ".$matricula."</li>";
                        echo "<li><b>Punto de encuentro:</b> ".$rew['punto_encuentro']."</li>";
                        echo "<li><b>Hora de salida:</b> ".$rew['hora_viaje']."</li>";
                        echo "</ul>";
                        echo "<div class='botones-container'>";
                        if($rew['estado'] == 0){
                            echo "<a href='crud/aceptarSoli.php?viaje=".$rew['id_viaje']."&id_usuario=".$id_usuario."' class='btn btn-success'><i class='fa-solid fa-check'></i></a>";
                            echo "<a href='crud/negarSoli.php?viaje=".$rew['id_viaje']."&id_usuario=".$id_usuario."' class='btn btn-danger'><i class='fa-solid fa-x'></i></a>";
                        } else {
                            echo "aceptado";
                        }
                        
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";

                    }

                ?>
             

            </div>
        </div>
    </div>

    <script>
        function eliminarSolicitud(id) {
            // Obtiene el contenedor de la solicitud por su id
            const solicitud = document.getElementById(`solicitud-${id}`);
            // Elimina el contenedor de la solicitud si existe
            if (solicitud) {
                solicitud.remove();
            }
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
