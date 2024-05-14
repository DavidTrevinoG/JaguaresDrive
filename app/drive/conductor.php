
<?php
// Incluir el archivo de conexión
include_once '../bd/conexion.php'; 

// Crear una instancia de la clase Conexion
$conexion_bd = new Conexion();
$conexion = $conexion_bd->conectar();

session_start();

// Verificar si el usuario ha iniciado sesión y tiene el rol de conductor
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['rol']) || $_SESSION['rol'] !== 'conductor') {
    // Usuario no autenticado o no tiene el rol de conductor, redirigir a la página de inicio de sesión
    header("Location: index.php");
    exit;
}

// Obtener el nombre de usuario de las variables de sesión
$nombreUsuario = "";

// Obtener el nombre de usuario desde la base de datos utilizando el ID de usuario almacenado en la sesión
$usuarioId = $_SESSION['usuario_id'];
$sql = "SELECT nombre FROM usuario WHERE usuario_id = '$usuarioId'";
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

$sql = "SELECT nombre, apellido_p, apellido_m, fecha_nac, telefono, matricula, correo,contrasena,foto,id_carrera FROM usuario WHERE usuario_id = '$usuarioId'";
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

$buscarInfo = "SELECT * FROM conductor WHERE usuario_id = '$usuarioId'";
$result = $conexion->query($buscarInfo);
$fila = $result->fetch_assoc();
$id_conductor = $fila['id_conductor'];

$buscarRuta = "SELECT * FROM ruta WHERE id_conductor = '$id_conductor'";
$result = $conexion->query($buscarRuta);
$fila = $result->fetch_assoc();
$coordenadas = $fila['direcciones'];
$costo = $fila['costo_viaje'];
$hora = $fila['duracion'];
$descripcion = $fila['descripcion'];

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
    <script src="../controllers/mapa.js"></script>
    <script>
    window.onload = function() {
        initAutocomplete();
    };
</script>
   
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


    </style>
</head>

<?php

$coordenadas = explode("|", $coordenadas);
 
?>

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
            <a href="solicitudes.php?id_usuario=<?php echo $usuarioId; ?>" class="menu-item"><i class="fa-solid fa-car"></i> Solicitudes</a>
            <a href="editar_conductor.php?id_usuario=<?php echo $usuarioId; ?>" class="menu-item"><i class="fa-solid fa-gear"></i> Perfil</a>
            <a href="cerrar_sesion.php" class="menu-item" onclick="confirmarCerrarSesion(event)"><i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a>
        </nav>
    </div>

    <!-- Resto del contenido HTML -->
    <div id="content">
        <!-- Añade aquí el contenido de tu página -->
        <h1>Bienvenid@ <?php echo $nombreUsuario; ?></h1> <!-- Aquí se mostrará el nombre de usuario -->

        <br>
        <a href="crud/eliminarRuta.php?id_usuario=<?php echo $usuarioId; ?>" class="btn btn-danger">Eliminar Ruta Creada Previamente</a>
        <br>
        <br>
        <form if="formulario" method="POST" action="crud/insertarRuta.php">
        <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['usuario_id']; ?>">
        <input type="hidden" id="coordenadas2" name="coordenadas2" value="">
        <div class="container-content">
            <div class="form-group">
                <label for="punto-partida"><b>Selecciona tu punto de partida:</b></label>
                <div class="input-group mb-3">
                    <!-- Icono -->
                    <span class="input-group-text"><i class="fas fa-location-dot"></i></span>
                    <input name="partida" id="partida" value="<?php echo $coordenadas[0]; ?>" type="text" class="autocomplete-input form-control" placeholder="Buscar punto de partida" aria-label="Buscar punto de partida" aria-describedby="button-buscar" required>
                </div>
            </div>
            <label for="paradas"><b>Selecciona puntos de paradas:</b></label>
            <div id="paradas-container">
                <div class="form-group">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="fa-solid fa-location-pin"></i></span>
                        <input type="text" class="autocomplete-input form-control" placeholder="Buscar paradas" value="<?php echo $coordenadas[1]; ?>" name="input1" id="input1" aria-label="Buscar paradas" aria-describedby="button-buscar-paradas" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary btn-accion" type="button" id="button-agregar-parada" onclick="agregarPuntoParada()"><i class="fa-solid fa-plus"></i></button>
                            <button class="btn btn-outline-secondary btn-accion" type="button" id="button-eliminar-parada" onclick="eliminarPuntoParada()"><i class="fa-solid fa-minus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="map-container">
            <button class="btn btn-outline-secondary btn-accion" type="button" id="button-agregar-parada" onclick="convertirDireccionACoordenadas()">Agregar a mapa</button>
               <div id="mapa" style="width: 100%; height: 400px;" ></div>
            </div>
             <!-- División donde se mostrará el mapa -->

            <div class="form-group">
                           
                <div class="input-group">
                      <label for="costo" style="margin-right: 10px;"><b>Costo:</b></label>
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" value="<?php echo $costo; ?>" name="costo" id="costo" placeholder="Ingrese el costo" aria-label="Ingrese el costo" aria-describedby="button-calcular" required>
                   
                    <label for="hora" style="margin-right: 10px;"><b>Hora de salida:</b></label>
                    <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                    <input type="time" class="form-control" value="<?php echo $hora; ?>"; name="hora" id="hora" aria-label="Ingrese la hora" aria-describedby="button-calcular" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="descripcion"><b>Descripción:</b></label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3" placeholder="Ingrese la descripción" required><?php echo $descripcion; ?></textarea>
            </div>
            <button type="submit" name="insertar_ruta" class="btn btn-primary" onclick="confirmarInicioViaje(event)" style="background-color: rgb(0, 0, 0); color: white;">Subir Viaje</button>
        </div>
    </div>
    </form>

    <script>

        <?php
        for($i = 2; $i < count($coordenadas); $i++){
            echo 'agregarPuntoParada("'.$coordenadas[$i].'", "'.$i.'");';
        }  
        ?>

        function initAutocomplete() {
            var inputs = document.querySelectorAll('.autocomplete-input');

            // Itera sobre cada input y aplica el autocompletado de direcciones
            inputs.forEach(function(input) {
                var autocomplete = new google.maps.places.Autocomplete(input);
            });
        }
        
        var cont = 1;
        function agregarPuntoParada(value, cant) {
            if(cant == null){
                cant = cont;
            }
            if(value == null){
                value = "";
            }
            cont++;
            var paradaContainer = document.getElementById("paradas-container");
            var newFormGroup = document.createElement("div");
            newFormGroup.classList.add("form-group");
            newFormGroup.innerHTML = `
                <div class="input-group mb-3">
                    <!-- Icono -->
                    <span class="input-group-text"><i class="fa-solid fa-location-pin"></i></span>
                    <input id="input`+ cant + `" name="input`+ cant + `" value="`+ value + `" class="autocomplete-input form-control" placeholder="Buscar punto de partida" aria-label="Buscar punto de partida" aria-describedby="button-buscar" req>
                    <!-- Botones de acciones -->
                    <div class="input-group-append">
                        <!-- Botón de agregar -->
                        <button class="btn btn-outline-secondary btn-accion" type="button" onclick="agregarPuntoParada()"><i class="fa-solid fa-plus"></i></button>
                        <!-- Botón de eliminar -->
                        <button class="btn btn-outline-secondary btn-accion" type="button" onclick="eliminarPuntoParada()"><i class="fa-solid fa-minus"></i></button>
                    </div>
                </div>`;
            paradaContainer.appendChild(newFormGroup);
            initAutocomplete();
        }

        function eliminarPuntoParada() {
            var paradaContainer = document.getElementById('paradas-container');
            var formGroups = paradaContainer.getElementsByClassName('form-group');
            if (formGroups.length > 1) { // Asegúrate de que haya al menos un elemento antes de eliminar
                paradaContainer.removeChild(formGroups[formGroups.length - 1]); // Elimina el último elemento de la lista
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
                    window.location.href = "cerrar_sesion.php";
                }
            });
        }
    </script>
    <script>    

function convertirDireccionACoordenadas() {
    var inputs = document.querySelectorAll('input[name^="input"]');
    var start = document.getElementById('partida').value;

    // Verificar si todos los inputs están vacíos
    var todosVacios = true;
    inputs.forEach(function(input) {
        if (input.value.trim() !== '') {
            todosVacios = false;
        }
    });

    // Si todos los inputs están vacíos, mostrar el mapa con una ubicación predeterminada
    if (todosVacios) {
        var mapOptions = {
            center: { lat: 23.728058, lng: -99.077465 },
            zoom: 12
        };

        var map = new google.maps.Map(document.getElementById('mapa'), mapOptions);
        return;
    }

    var geocoder = new google.maps.Geocoder();
    var cadenaOUT = "";
    var mapa;
    var waypoints = [];

    // Variable para contar cuántas solicitudes de geocodificación se han completado
    var geocodeCounter = 0;

    // Función de devolución de llamada para manejar los resultados de geocodificación
    function geocodeCallback(results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            var coordenadas = results[0].geometry.location;

            waypoints.push({
                location: coordenadas,
                stopover: true
            });

            cadenaOUT += coordenadas.lat().toString() + ", " + coordenadas.lng().toString() + "|";
            document.getElementById("coordenadas2").value = cadenaOUT;
            document.getElementsByName("coordenadas2")[0].value = cadenaOUT;

            geocodeCounter++; // Incrementar el contador de solicitudes completadas

            if (geocodeCounter === inputs.length) {
                // Si todas las solicitudes se han completado, construir la ruta
                construirRuta();
            }
        } else {
            console.log("Error en geocodificación: " + status);
        }
    }

    // Geocodificar la dirección de partida
    geocoder.geocode({ 'address': start }, function(result, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            start = result[0].geometry.location;
            cadenaOUT += start.lat().toString() + ", " + start.lng().toString() + "|";
        } else {
            console.log("Error en geocodificación de partida: " + status);
        }

        // Iterar sobre cada dirección y realizar la geocodificación
        inputs.forEach(function(input) {
            var direccion = input.value;
            if (direccion.trim() !== '') {
                geocoder.geocode({ 'address': direccion }, geocodeCallback);
            } else {
                geocodeCounter++;
                if (geocodeCounter === inputs.length) {
                    // Si todas las solicitudes se han completado, construir la ruta
                    construirRuta();
                }
            }
        });
    });

    // Función para construir la ruta una vez que se hayan completado todas las solicitudes de geocodificación
    function construirRuta() {
        var mapOptions = {
            center: start,
            zoom: 12
        };

        var map = new google.maps.Map(document.getElementById('mapa'), mapOptions);

        var directionsService = new google.maps.DirectionsService();
        var directionsRenderer = new google.maps.DirectionsRenderer();
        directionsRenderer.setMap(map);

        var end = new google.maps.LatLng(23.729029, -99.077182);

        var request = {
            origin: start,
            destination: end,
            waypoints: waypoints,
            travelMode: 'DRIVING'
        };

        directionsService.route(request, function(response, status) {
            if (status === 'OK') {
                directionsRenderer.setDirections(response);
            } else {
                window.alert('Error al mostrar las direcciones: ' + status);
            }
        });
    }
}


            
        



            // Iniciar el mapa con las coordenadas obteni

        convertirDireccionACoordenadas();

    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-Xe8FIISpaF1FODdP7IjFmzHeGeFZhUByu2DdTm6l5on5Cv5uUZcXnKjpBy6QhpF4" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+WyIx8vHV5z5q1gF94tLl5MDO/aDlO7f5J" crossorigin="anonymous"></script>
</body>

</html>
     