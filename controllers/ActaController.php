<?php

require_once 'models/acta.php';
require_once 'models/usuario.php';
require 'vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

class actaController {

    public function generar() {
        require_once 'views/acta/generarActa.php';
    }

    public function gestion() {
        $acta = new Acta();
        if (isset($_SESSION['psiquiatra'])) {
            $actas = $acta->getActaPsiquiatra();
        } elseif (isset($_SESSION['admin'])) {
            $actas = $acta->getAll();
        }
        require_once 'views/acta/gestion.php';
    }

    public function save() {
        if (isset($_POST)) {
            $psiquiatra = $_SESSION['identity']->id;
            $estudiante = isset($_POST['estudiante']) ? trim($_POST['estudiante']) : false;
            $fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : false;
            $hora = isset($_POST['hora']) ? trim($_POST['hora']) : false;

            $validar = Utils::validateActa($estudiante, $fecha, $hora);
            if ($validar == false) {
                $usuario = new Usuario();
                $usuario->setNombre_Apellidos($estudiante);
                $u = $usuario->getUsuarioId();
                $id_user = $u->id;
                $acta = new Acta();
                $c = $acta->getOne($psiquiatra, $id_user);
                $c_id = $c->id;
                $acta->setConversacion_id($c_id);
                $acta->setFecha($fecha);
                $acta->setHora($hora);
                $save = $acta->save();
                $a = $acta->getActaGenerada();
                $id = $a->id;

                if ($save) {
                    $_SESSION['register'] = "complete";
                    header("Location:" . base_url . 'acta/imprimirActa&id=' . $id);
                }
            } else {
                $_SESSION['register'] = $validar;
                header("Location:" . base_url . 'acta/generar');
            }
        }
    }

    public function update() {
        if (isset($_POST)) {
            $fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : false;
            $hora = isset($_POST['hora']) ? trim($_POST['hora']) : false;
            $estado = isset($_POST['estado']) ? trim($_POST['estado']) : false;

            $validar = Utils::validateActa(1, $fecha, $hora);
            if ($validar == false) {
                $acta = new Acta();
                $acta->setFecha($fecha);
                $acta->setHora($hora);
                $acta->setEstado($estado);

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $acta->setId($id);
                    $save = $acta->update();
                }

                if ($save) {
                    $_SESSION['updated'] = "complete";
                }
            } else {
                $_SESSION['updated'] = $validar;
            }
            header("Location:" . base_url . 'acta/gestion');
        }
    }

    public function editarActa() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $acta = new Acta();
            $acta->setId($id);
            $a = $acta->getActaById();
            $estudiante = $acta->getEstudianteById();
            $psiquiatra = $acta->getPsiquiatraById();
        }
        require_once 'views/acta/editarActa.php';
    }

    public function imprimirActa() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $acta = new Acta();
            $acta->setId($id);
            $a = $acta->getActaById();
            $estudiante = $acta->getEstudianteById();
            $psiquiatra = $acta->getPsiquiatraById();
        }
        $html2pdf = new Html2Pdf();
        ob_start();
        require_once 'views/acta/imprimirActa.php';
        $html = ob_get_clean();
        ob_end_clean();
        $html2pdf->writeHTML($html);
        $html2pdf->output();
    }

    public function imprimirLista() {
        $acta = new Acta();
        if (isset($_SESSION['admin'])) {
            $actas = $acta->getAll();
        } elseif (isset($_SESSION['psiquiatra'])) {
            $actas = $acta->getActaPsiquiatra();
        }
        $html2pdf = new Html2Pdf();
        ob_start();
        require_once 'views/acta/imprimirActas.php';
        $html = ob_get_clean();
        ob_end_clean();
        $html2pdf->writeHTML($html);
        $html2pdf->output();
    }

}
