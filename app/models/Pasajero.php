<?php
class Pasajero
{
    private $id_pasajero, $usuario_id, $asistencia_req;

    // Constructor
    public function __construct($id_pasajero, $usuario_id, $asistencia_req)
    {
        $this->id_pasajero = $id_pasajero;
        $this->usuario_id = $usuario_id;
        $this->asistencia_req = $asistencia_req;
    }

    // Getter's & Setter's
    public function setIdPasajero($id_pasajero)
    {
        $this->id_pasajero = $id_pasajero;
    }

    public function getIdPasajero()
    {
        return $this->id_pasajero;
    }

    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }

    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    public function setAsistenciaReq($asistencia_req)
    {
        $this->asistencia_req = $asistencia_req;
    }

    public function getAsistenciaReq()
    {
        return $this->asistencia_req;
    }
}
