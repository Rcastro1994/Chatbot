<?php

class Acta {

    private $id;
    private $conversacion_id;
    private $fecha;
    private $hora;
    private $estado;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getId() {
        return $this->id;
    }

    public function getConversacion_id() {
        return $this->conversacion_id;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getHora() {
        return $this->hora;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setConversacion_id($conversacion_id) {
        $this->conversacion_id = $conversacion_id;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setHora($hora) {
        $this->hora = $hora;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function save() {
        $sql = "INSERT INTO actas_reunion VALUES(null, {$this->getConversacion_id()}, '{$this->getFecha()}', '{$this->getHora()}', 'Generada')";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function update() {
        $sql = "UPDATE actas_reunion SET fecha = '{$this->getFecha()}', hora = '{$this->getHora()}', estado = '{$this->getEstado()}' WHERE id = {$this->getId()}";
        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function getAll() {
        $sql = "SELECT * FROM actas_reunion ORDER BY id ASC";
        $actas = $this->db->query($sql);
        return $actas;
    }

    public function getActaPsiquiatra() {
        $sql = "SELECT a.* FROM actas_reunion a INNER JOIN conversaciones c ON c.id=a.conversacion_id WHERE c.psiquiatra_id={$_SESSION['identity']->id} ORDER BY id ASC";
        $actas = $this->db->query($sql);
        return $actas;
    }

    public function getOne($psiquiatra, $estudiante) {
        $sql = "SELECT id FROM conversaciones WHERE usuario_id = $estudiante AND psiquiatra_id = $psiquiatra";
        $conversacion = $this->db->query($sql);
        return $conversacion->fetch_object();
    }

    public function getActaGenerada() {
        $sql = "SELECT * FROM actas_reunion ORDER BY id DESC LIMIT 1";
        $acta = $this->db->query($sql);
        return $acta->fetch_object();
    }

    public function getActaById() {
        $sql = "SELECT * FROM actas_reunion WHERE id = {$this->getId()}";
        $acta = $this->db->query($sql);
        return $acta->fetch_object();
    }

    public function getEstudianteById() {
        $sql = "SELECT u.* FROM actas_reunion a INNER JOIN conversaciones c ON c.id=a.conversacion_id INNER JOIN usuarios u ON u.id=c.usuario_id WHERE a.id={$this->getId()}";
        $estudiante = $this->db->query($sql);
        return $estudiante->fetch_object();
    }

    public function getPsiquiatraById() {
        $sql = "SELECT u.* FROM actas_reunion a INNER JOIN conversaciones c ON c.id=a.conversacion_id INNER JOIN usuarios u ON u.id=c.psiquiatra_id WHERE a.id={$this->getId()}";
        $psiquiatra = $this->db->query($sql);
        return $psiquiatra->fetch_object();
    }

}
