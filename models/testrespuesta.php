<?php

class Testrespuesta{
    private $id;
    private $usuario_id;
    private $test_id;
    private $respuesta1;
    private $respuesta2;
    private $respuesta3;
    private $respuesta4;
    private $respuesta5;
    private $respuesta6;
    private $respuesta7;
    private $respuesta8;
    private $respuesta9;
    private $respuesta10;
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

    public function getTest_id() {
        return $this->test_id;
    }

    public function getRespuesta1() {
        return $this->respuesta1;
    }

    public function getRespuesta2() {
        return $this->respuesta2;
    }

    public function getRespuesta3() {
        return $this->respuesta3;
    }

    public function getRespuesta4() {
        return $this->respuesta4;
    }

    public function getRespuesta5() {
        return $this->respuesta5;
    }

    public function getRespuesta6() {
        return $this->respuesta6;
    }

    public function getRespuesta7() {
        return $this->respuesta7;
    }

    public function getRespuesta8() {
        return $this->respuesta8;
    }

    public function getRespuesta9() {
        return $this->respuesta9;
    }

    public function getRespuesta10() {
        return $this->respuesta10;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setUsuario_id($usuario_id){
        $this->usuario_id = $usuario_id;
    }

    public function setTest_id($test_id){
        $this->test_id = $test_id;
    }

    public function setRespuesta1($respuesta1){
        $this->respuesta1 = $respuesta1;
    }

    public function setRespuesta2($respuesta2){
        $this->respuesta2 = $respuesta2;
    }

    public function setRespuesta3($respuesta3){
        $this->respuesta3 = $respuesta3;
    }

    public function setRespuesta4($respuesta4){
        $this->respuesta4 = $respuesta4;
    }

    public function setRespuesta5($respuesta5){
        $this->respuesta5 = $respuesta5;
    }

    public function setRespuesta6($respuesta6){
        $this->respuesta6 = $respuesta6;
    }

    public function setRespuesta7($respuesta7){
        $this->respuesta7 = $respuesta7;
    }

    public function setRespuesta8($respuesta8){
        $this->respuesta8 = $respuesta8;
    }

    public function setRespuesta9($respuesta9){
        $this->respuesta9 = $respuesta9;
    }

    public function setRespuesta10($respuesta10){
        $this->respuesta10 = $respuesta10;
    }


    public function saveRespuesta() {
        $sql = "INSERT INTO respuestas_tests VALUES(null, '{$this->getUsuario_id()}', '{$this->getTest_id()}', '{$this->getRespuesta1()}', '{$this->getRespuesta2()}', '{$this->getRespuesta3()}', '{$this->getRespuesta4()}', '{$this->getRespuesta5()}','{$this->getRespuesta6()}', '{$this->getRespuesta7()}', '{$this->getRespuesta8()}', '{$this->getRespuesta9()}', '{$this->getRespuesta10()}');";
        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }
    
}