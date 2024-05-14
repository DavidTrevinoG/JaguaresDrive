<?php
    include_once '../bd/conexion.php';
    $objConexion = new Conexion();
$conexion = $objConexion->conectar();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    <link rel="stylesheet" href="css/style.css">

    <title>JAGUARES DRIVE</title>

    <!-- Enlace al icono para la pestaña -->
    <link rel="icon" href="img/logo.png" type="image/x-icon">

</head>
    <style>
        .form-select {
            border-radius: 20px;
        }

        .form-select option {
            background-color: #f8f9fa;
            color: #212529;
            border-radius: 20px;
        }

        .form-row {
            display: flex;
            justify-content: space-between;
            gap: 10px; /* Ajusta este valor para controlar el espacio entre campos */
        }

        .form-field {
            flex: 1;
            margin-right: 10px;
        }

        .form-field:last-child {
            margin-right: 0;
        }

        .form-register {
            display: flex;
            flex-direction: column;
            gap: 1rem; /* Espacio entre filas */
        }

        .form-row label {
            flex: 1;
            display: flex;
            align-items: center; /* Alinea verticalmente los iconos e inputs */
            gap: 0.5rem; /* Espacio entre el icono y el campo de entrada */
        }

        .input-container {
            display: flex;
            align-items: center;
            gap: 0.5rem; /* Espacio entre el icono y el campo de entrada */
        }

        .input-container i {
            font-size: 1.2rem;
        }

        .input-container input {
            flex: 1; /* Permite que el campo de entrada tome el espacio restante */
        }

        /* Estilo para el contenedor de la imagen */
        .logo-container {
            text-align: center; /* Centra la imagen */
            margin-top: 15px; /* Espacio entre la imagen y el h2 */
        }

        /* Estilo para la imagen */
        .logo-container img {
            display: block; /* Hace que la imagen sea un bloque */
            margin: 0 auto; /* Centra la imagen horizontalmente */
            /* Puedes ajustar otros estilos aquí, como el tamaño de la imagen */
        }
        
        .information {
            width: 40%;
            display: flex;
            align-items: center;
            text-align: center;
            background-color:  rgb(63, 63, 63);
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
        }

        .form input[type="submit"] {
            background-color: #9f9fa3;
            color: #fff;
            border-radius: 20px;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, .1);
        }

        .form input[type="submit"]:hover {
            background-color: #818186;
        }

        #sign-up {
            background-color: #9f9fa3; /* Color de fondo */
            color: #fff; /* Color del texto */
            border-color: #9f9fa3; /* Color del borde */
            padding: 10px 20px; /* Relleno del botón */
            border-radius: 20px; /* Borde redondeado */
            font-size: 16px; /* Tamaño de la fuente */
            cursor: pointer; /* Cursor en forma de mano al pasar por encima */
        }
        #sign-in { 
            background-color: #9f9fa3; /* Color de fondo */
            color: #fff; /* Color del texto */
            border-color: #9f9fa3; /* Color del borde */
            padding: 10px 20px; /* Relleno del botón */
            border-radius: 20px; /* Borde redondeado */
            font-size: 16px; /* Tamaño de la fuente */
            cursor: pointer; /* Cursor en forma de mano al pasar por encima */
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url('img/2.jpg');
            background-size: cover;
        }


    </style> 
    <!--FIN DE ESTILO DEL FORMULARIO-->

<body>

    <!--Formulario de Inicio de Sesión-->
    <div class="container-form login">
        <div class="information">
            <div class="info-childs">
                <h2>Bienvenido a Jaguares Drive</h2>
               <img src="img/logo.png" width="180px"/>
                <input type="button" value="Registrarse" id="sign-up">
            </div>
        </div>
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Iniciar Sesión</h2>
                <br>
     
            <form class="form form-register" method="post"  action="crud/crudlogin.php">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="user-role">
                        <i class='ant-design:pushpin-filled'></i> Seleccione un rol de usuario...
                    </label>
                    <select class="form-select form-select-sm" id="user-role" name="user-role" aria-label="Large select example">
                        <option value="1">Conductor</option>
                        <option value="2">Pasajero</option>
                    </select>
                </div>
                
                    <label class="input-container">
                        <i class='bx bx-user'></i>
                        <input type="text" placeholder="Matricula" name="nombre" id="nombre">
                    </label>
    
                    <label class="input-container">
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" placeholder="Contraseña" name="pass" id="pass">
                    </label>

                
                <input type="submit" value="Iniciar Sesión">
            </form>
            </div>
        </div>
    </div>
     <!--Fin de formulario de inicio de sesión-->



    <!-- Formulario de registro PASAJERO-->
    
    <div class="container-form register hide">
        <div class="information">
            <div class="info-childs">
                <h2>Bienvenido a Jaguares Drive</h2>
                
                <!-- Imagen debajo del h2 -->
                <div class="logo-container">
                    <img src="img/logo.png" alt="Logo de Jaguares Drive" width="180px">
                </div>
                
                <input type="button" value="Iniciar Sesión" id="sign-in">
            </div>
        </div>

        <!-- campos PASAJERO-->
    <div class="form-information ">
        <div class="form-information-childs">
            <h2>Crear Cuenta</h2>

            <form class="form form-register" method="post" action="crud/crud.php" enctype="multipart/form-data">

                <div class="input-group mb-3">
                    
                    <label class="input-group-text" for="user-role">
                        <i class='ant-design:pushpin-filled'></i>Rol de usuario
                    </label>
                    <select class="form-select form-select-sm" id="user-role" name="user-role" aria-label="Large select example" required>
                    <option value="2">Pasajero</option>
                    <option value="1">Conductor</option>
                    </select>
                    <label class="input-container">
                            <i class='bx bx-image'></i> <!-- Icono para indicar carga de imagen -->
                            <input type="file" id="imagen" name="imagen" class="form-control-file" accept="image/*" required>
                    </label>
                    

                </div>

                <div class="form-row">
                    <label class="input-container">
                        <i class='bx bx-user'></i>
                        <input type="text" placeholder="Nombre" name="nombre" id="nombre" required>
                    </label>

                    <label class="input-container">
                        <i class='bx bx-user'></i>
                        <input type="text" placeholder="Apellido Paterno" name="apep" id="apep" required>
                    </label>
                </div>
                
                <div class="form-row">
                    <label class="input-container">
                        <i class='bx bx-user'></i>
                        <input type="text" placeholder="Apellido Materno" name="apem" id="apem" required>
                    </label>

                    <label class="input-container">
                        <i class='bx bx-calendar'></i>
                        <input type="date" placeholder="Fecha de Nacimiento" name="fecha" id="fecha" max="<?php echo date('Y-m-d', strtotime('-17 years')); ?>" required>
                    </label>


                </div>
            
                <div class="form-row">
                    <label class="input-container">
                        <i class='bx bx-envelope'></i>
                        <input type="email" placeholder="Correo electrónico" name="correo" id="correo" required>
                    </label>

                    <label class="input-container">
                        <i class='bx bx-phone'></i>
                        <input type="tel" placeholder="Teléfono" name="tele" id="tele" pattern="\d{10}" required>
                    </label>
                </div>
                
                <div class="form-row">
                    <label class="input-container">
                        <i class='bx bx-id-card'></i>
                        <input type="number" placeholder="Matrícula" name="mat" id="mat"required>
                    </label>

                    <!--i class='bx bx-building-house'-->
                    <label class="input-container">
                        <i class='bx bx-lock-alt'></i>
                        <input type="password" placeholder="Contraseña" name="pass" id="pass"required>
                    </label>
                </div>
                <div class="form-row">
                <label class="input-container">
                    <i class='bx bx-lock-alt'></i>
                    <select name="carrera" id="carrera" required>
                        <?php
                        // Consulta todas las carreras de la base de datos
                        $query = "SELECT id_carrera, nombre FROM Carreras";
                        $result = $conexion->query($query);
                        // Verifica si hay resultados
                        if ($result->num_rows > 0) {
                            // Itera sobre los resultados y crea opciones para el select
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id_carrera'] . "'>" . $row['nombre'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No hay carreras disponibles</option>";
                        }

                        ?>
                    </select>
                </label>
       
            </div>
                <input type="submit" value="Registrarse">
            </form>
        </div>
    </div>

    <!--Fin formulario de registro PASAJERO-->



<!-- Formulario de registro CONDUCTOR-->
    <div class="container-form register-conductor hide">
        <div class="information">
            <div class="info-childs">
                <h2>Bienvenido a Jaguares Drive</h2>
                
                <!-- Imagen debajo del h2 -->
                <div class="logo-container">
                    <img src="img/logo.png" alt="Logo de Jaguares Drive" width="180px">
                </div>
                
                <input type="button" value="Iniciar Sesión" id="sign-in">
            </div>
        </div>

    
        <!-- campos CONDUCTOR -->
        <div class="form-information">
            <div class="form-information-childs">
                <h2>Crear Cuenta</h2>
                <form class="form form-register" method="post">
                    <div class="form-row">
                        <label class="input-container">
                            <i class='bx bx-user'></i>
                            <input type="text" placeholder="Nombre" name="nombrec" id="nombrec">
                        </label>
    
                        <label class="input-container">
                            <i class='bx bx-user'></i>
                            <input type="text" placeholder="Apellido Paterno" name="apepc" id="apepc">
                        </label>
                    </div>
                    
                    <div class="form-row">
                        <label class="input-container">
                            <i class='bx bx-user'></i>
                            <input type="text" placeholder="Apellido Materno" name="apemc" id="apemc">
                        </label>
    
                        <label class="input-container">
                            <i class='bx bx-calendar'></i>
                            <input type="date" placeholder="Fecha de Nacimiento" name="fechac" id="fechac">
                        </label>
                    </div>
                    
                    <div class="form-row">
                        <label class="input-container">
                            <i class='bx bx-envelope'></i>
                            <input type="email" placeholder="Correo electrónico" name="correoc" id="correoc">
                        </label>
    
                        <label class="input-container">
                            <i class='bx bx-phone'></i>
                            <input type="tel" placeholder="Teléfono" name="telec" id="telec" pattern="\d{10}">
                        </label>
                    </div>
    
                    <div class="form-row">
                        <label class="input-container">
                            <i class='bx bx-id-card'></i>
                            <input type="text" placeholder="Placas" name="plac" id="plac">
                        </label>
    
                        <label class="input-container">
                            <i class='bx bx-lock-alt'></i>
                            <input type="number" placeholder="Modelo de auto" name="mol" id="mol">
                        </label>
                    </div>
    
                    <div class="form-row">
                        <label class="input-container">
                            <i class='bx bx-id-card'></i>
                            <input type="text" placeholder="Color de auto" name="col" id="col">
                        </label>
    
                        <label class="input-container">
                            <i class='bx bx-lock-alt'></i>
                            <input type="text" placeholder="Marca de auto" name="marca" id="marca">
                        </label>
                    </div>
    
                    <div class="form-row">
                        <label class="input-container">
                            <i class='bx bx-id-card'></i>
                            <input type="number" placeholder="Matrícula" name="matc" id="matc">
                        </label>
    
                        <label class="input-container">
                            <i class='bx bx-lock-alt'></i>
                            <input type="password" placeholder="Contraseña" name="passc" id="passc">
                        </label>
                    </div>
                    
                    <input type="submit" value="Registrarse">
                </form>
            </div>
        </div>
    </div>
    

    </div>

   <script>

        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona el botón "Registrarse" y los formularios
            const signUpButton = document.getElementById('sign-up');
            const loginForm = document.querySelector('.container-form.login');
            const registerForm = document.querySelector('.container-form.register');
            
            // Evento de clic para el botón "Registrarse"
            signUpButton.addEventListener('click', function () {
                // Ocultar el formulario de inicio de sesión
                loginForm.classList.add('hide');
                
                // Mostrar el formulario de registro
                if (registerForm) {
                    registerForm.classList.remove('hide');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona el botón "Iniciar Sesión" en el formulario de registro
            const signInButton = document.getElementById('sign-in');
            
            // Selecciona el formulario de inicio de sesión y el formulario de registro
            const loginForm = document.querySelector('.container-form.login');
            const registerForm = document.querySelector('.container-form.register');

            // Evento de clic para el botón "Iniciar Sesión" en el formulario de registro
            signInButton.addEventListener('click', function () {
                // Ocultar el formulario de registro
                registerForm.classList.add('hide');
                
                // Mostrar el formulario de inicio de sesión
                if (loginForm) {
                    loginForm.classList.remove('hide');
                }
            });
        });

   </script>

    <script src="js/script.js"></script>
    <script src="js/register.js"></script>
    <script src="js/login.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>