<?php
// Conexión a la base de datos
class Conexion{
private $server_name = "localhost";
private $user_name = "admin";
private $password = "0ff42d8a24af5b106c0b0d5bfbda40dfb6d57e4f11434fa8";
private $dbname = "prueba_didi";


public function conectar() {
    $conexion = new mysqli($this->server_name, $this->user_name, $this->password, $this->dbname);

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }else{
}
    return $conexion;
}
}

?>
