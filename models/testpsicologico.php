<?php

class Testpsicologico {

    private $id;
    private $nombre;
    private $pregunta1;
    private $pregunta2;
    private $pregunta3;
    private $pregunta4;
    private $pregunta5;
    private $pregunta6;
    private $pregunta7;
    private $pregunta8;
    private $pregunta9;
    private $pregunta10;
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPregunta1() {
        return $this->pregunta1;
    }

    public function getPregunta2() {
        return $this->pregunta2;
    }

    public function getPregunta3() {
        return $this->pregunta3;
    }

    public function getPregunta4() {
        return $this->pregunta4;
    }

    public function getPregunta5() {
        return $this->pregunta5;
    }

    public function getPregunta6() {
        return $this->pregunta6;
    }

    public function getPregunta7() {
        return $this->pregunta7;
    }

    public function getPregunta8() {
        return $this->pregunta8;
    }

    public function getPregunta9() {
        return $this->pregunta9;
    }

    public function getPregunta10() {
        return $this->pregunta10;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setPregunta1($pregunta1) {
        $this->pregunta1 = $pregunta1;
    }

    public function setPregunta2($pregunta2) {
        $this->pregunta2 = $pregunta2;
    }

    public function setPregunta3($pregunta3) {
        $this->pregunta3 = $pregunta3;
    }

    public function setPregunta4($pregunta4) {
        $this->pregunta4 = $pregunta4;
    }

    public function setPregunta5($pregunta5) {
        $this->pregunta5 = $pregunta5;
    }

    public function setPregunta6($pregunta6) {
        $this->pregunta6 = $pregunta6;
    }

    public function setPregunta7($pregunta7) {
        $this->pregunta7 = $pregunta7;
    }

    public function setPregunta8($pregunta8) {
        $this->pregunta8 = $pregunta8;
    }

    public function setPregunta9($pregunta9) {
        $this->pregunta9 = $pregunta9;
    }

    public function setPregunta10($pregunta10) {
        $this->pregunta10 = $pregunta10;
    }

    public function getAll() {
        $sql = "SELECT * FROM tests_psicologicos ORDER BY id ASC";
        $tests = $this->db->query($sql);
        return $tests;
    }

    public function getOne() {
        $sql = "SELECT * FROM tests_psicologicos WHERE id = {$this->getId()}";
        $test = $this->db->query($sql);
        return $test->fetch_object();
    }

    public function saveTest() {
        $sql = "INSERT INTO tests_psicologicos VALUES(null, '{$this->getNombre()}', '{$this->getPregunta1()}', '{$this->getPregunta2()}', '{$this->getPregunta3()}', '{$this->getPregunta4()}', '{$this->getPregunta5()}', '{$this->getPregunta6()}','{$this->getPregunta7()}', '{$this->getPregunta8()}', '{$this->getPregunta9()}', '{$this->getPregunta10()}' );";
        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function updateTest() {
        $sql = "UPDATE tests_psicologicos SET nombre = '{$this->getNombre()}', pregunta1 =  '{$this->getPregunta1()}', pregunta2 = '{$this->getPregunta2()}', pregunta3 = '{$this->getPregunta3()}', pregunta4 = '{$this->getPregunta4()}', pregunta5 = '{$this->getPregunta5()}', pregunta6 = '{$this->getPregunta6()}', pregunta7 = '{$this->getPregunta7()}', pregunta8 = '{$this->getPregunta8()}', pregunta9 = '{$this->getPregunta9()}', pregunta10 = '{$this->getPregunta10()}' WHERE id = {$this->getId()}";
        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function deleteTest() {
        $sql = "DELETE FROM tests_psicologicos WHERE id = {$this->getId()}";
        $test = $this->db->query($sql);
        return $_SESSION['deleteTest'] = "deleted";
    }

}
