<?php
class Conductor
{
    private $id_conductor, $usuario_id, $vehiculo_id, $num_licencia_conducir, $estado_disponibilidad;

    // Constructor
    public function __construct($id_conductor, $usuario_id, $vehiculo_id, $num_licencia_conducir, $estado_disponibilidad)
    {
        $this->id_conductor = $id_conductor;
        $this->usuario_id = $usuario_id;
        $this->vehiculo_id = $vehiculo_id;
        $this->num_licencia_conducir = $num_licencia_conducir;
        $this->estado_disponibilidad = $estado_disponibilidad;
    }

    // Getter's & Setter's
    public function setIdConductor($id_conductor)
    {
        $this->id_conductor = $id_conductor;
    }

    public function getIdConductor()
    {
        return $this->id_conductor;
    }

    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }

    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    public function setVehiculoId($vehiculo_id)
    {
        $this->vehiculo_id = $vehiculo_id;
    }

    public function getVehiculoId()
    {
        return $this->vehiculo_id;
    }

    public function setNumLicenciaConducir($num_licencia_conducir)
    {
        $this->num_licencia_conducir = $num_licencia_conducir;
    }

    public function getNumLicenciaConducir()
    {
        return $this->num_licencia_conducir;
    }

    public function setEstadoDisponibilidad($estado_disponibilidad)
    {
        $this->estado_disponibilidad = $estado_disponibilidad;
    }

    public function getEstadoDisponibilidad()
    {
        return $this->estado_disponibilidad;
    }
}
