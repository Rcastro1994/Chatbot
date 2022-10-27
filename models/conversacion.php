<?php

class Conversacion {

    private $id;
    private $usuario_id;
    private $psiquiatra_id;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getId() {
        return $this->id;
    }

    public function getUsuario_id() {
        return $this->usuario_id;
    }

    public function getPsiquiatra_id() {
        return $this->psiquiatra_id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setUsuario_id($usuario_id) {
        $this->usuario_id = $usuario_id;
    }

    public function setPsiquiatra_id($psiquiatra_id) {
        $this->psiquiatra_id = $psiquiatra_id;
    }

    public function getEstudiantes() {
        $sql = "SELECT * FROM usuarios u INNER JOIN conversaciones c ON u.id=c.usuario_id WHERE c.psiquiatra_id={$_SESSION['identity']->id}";
        $estudiantes = $this->db->query($sql);
        return $estudiantes;
    }

}
