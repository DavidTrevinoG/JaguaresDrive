<?php

class Resena {
    private $ID_Resena;
    private $ID_Asigna;
    private $ID_Recibe;
    private $calificacion;
    private $comentario;
    private $fecha;

    public function __construct($ID_Resena, $ID_Asigna, $ID_Recibe, $calificacion, $comentario, $fecha) {
        $this->ID_Resena = $ID_Resena;
        $this->ID_Asigna = $ID_Asigna;
        $this->ID_Recibe = $ID_Recibe;
        $this->calificacion = $calificacion;
        $this->comentario = $comentario;
        $this->fecha = $fecha;
    }

    public function getID_Resena() {
        return $this->ID_Resena;
    }

    public function getID_Asigna() {
        return $this->ID_Asigna;
    }

    public function getID_Recibe() {
        return $this->ID_Recibe;
    }

    public function getCalificacion() {
        return $this->calificacion;
    }

    public function getComentario() {
        return $this->comentario;
    }

    public function getFecha() {
        return $this->fecha;
    }

    // Setters
    public function setID_Resena($ID_Resena) {
        $this->ID_Resena = $ID_Resena;
    }

    public function setID_Asigna($ID_Asigna) {
        $this->ID_Asigna = $ID_Asigna;
    }

    public function setID_Recibe($ID_Recibe) {
        $this->ID_Recibe = $ID_Recibe;
    }

    public function setCalificacion($calificacion) {
        $this->calificacion = $calificacion;
    }

    public function setComentario($comentario) {
        $this->comentario = $comentario;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }
}


