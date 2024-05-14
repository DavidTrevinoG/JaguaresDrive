<?php
class Viaje
{
    private $id_viaje;
    private $fecha_viaje;
    private $hora_viaje;
    private $punto_encuentro;
    private $costo_viaje;
    private $id_conductor;
    private $id_pasajero;

    public function getIdViaje()
    {
        return $this->id_viaje;
    }

    public function setIdViaje($id_viaje)
    {
        $this->id_viaje = $id_viaje;
    }

    public function getFechaViaje()
    {
        return $this->fecha_viaje;
    }

    public function setFechaViaje($fecha_viaje)
    {
        $this->fecha_viaje = $fecha_viaje;
    }

    public function getHoraViaje()
    {
        return $this->hora_viaje;
    }

    public function setHoraViaje($hora_viaje)
    {
        $this->hora_viaje = $hora_viaje;
    }

    public function getPuntoEncuentro()
    {
        return $this->punto_encuentro;
    }

    public function setPuntoEncuentro($punto_encuentro)
    {
        $this->punto_encuentro = $punto_encuentro;
    }

    public function getCostoViaje()
    {
        return $this->costo_viaje;
    }

    public function setCostoViaje($costo_viaje)
    {
        $this->costo_viaje = $costo_viaje;
    }

    public function getIdConductor()
    {
        return $this->id_conductor;
    }

    public function setIdConductor($id_conductor)
    {
        $this->id_conductor = $id_conductor;
    }

    public function getIdPasajero()
    {
        return $this->id_pasajero;
    }

    public function setIdPasajero($id_pasajero)
    {
        $this->id_pasajero = $id_pasajero;
    }
}
