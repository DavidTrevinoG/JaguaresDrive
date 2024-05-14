<?php

class Mensaje {
    private $ID_Mensaje;
    private $ID_Usuario_Origen;
    private $ID_Usuario_Destino;
    private $contenido;
    private $fecha_envio;
    private $hora_envio;

    public function __construct($ID_Mensaje, $ID_Usuario_Origen, $ID_Usuario_Destino, $contenido, $fecha_envio, $hora_envio) {
        $this->ID_Mensaje = $ID_Mensaje;
        $this->ID_Usuario_Origen = $ID_Usuario_Origen;
        $this->ID_Usuario_Destino = $ID_Usuario_Destino;
        $this->contenido = $contenido;
        $this->fecha_envio = $fecha_envio;
        $this->hora_envio = $hora_envio;
    }

    public function getID_Mensaje() {
        return $this->ID_Mensaje;
    }

    public function getID_Usuario_Origen() {
        return $this->ID_Usuario_Origen;
    }

    public function getID_Usuario_Destino() {
        return $this->ID_Usuario_Destino;
    }

    public function getContenido() {
        return $this->contenido;
    }

    public function getFecha_envio() {
        return $this->fecha_envio;
    }

    public function getHora_envio() {
        return $this->hora_envio;
    }

    public function setID_Mensaje($ID_Mensaje) {
        $this->ID_Mensaje = $ID_Mensaje;
    }

    public function setID_Usuario_Origen($ID_Usuario_Origen) {
        $this->ID_Usuario_Origen = $ID_Usuario_Origen;
    }

    public function setID_Usuario_Destino($ID_Usuario_Destino) {
        $this->ID_Usuario_Destino = $ID_Usuario_Destino;
    }

    public function setContenido($contenido) {
        $this->contenido = $contenido;
    }

    public function setFecha_envio($fecha_envio) {
        $this->fecha_envio = $fecha_envio;
    }

    public function setHora_envio($hora_envio) {
        $this->hora_envio = $hora_envio;
    }
}
?>
