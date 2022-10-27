<?php

require_once 'models/usuario.php';
require 'vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

class usuarioController {

    public function registroLogin() {
        require_once 'views/usuario/registroLogin.php';
        if (isset($_SESSION['error_login'])) {
            unset($_SESSION['error_login']);
        }
    }

    public function save() {
        if (isset($_POST)) {

            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : false;
            $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : false;
            $fnacimiento = isset($_POST['fnacimiento']) ? trim($_POST['fnacimiento']) : false;
            $email = isset($_POST['email']) ? trim($_POST['email']) : false;
            $password = isset($_POST['password']) ? trim($_POST['password']) : false;
            $password2 = isset($_POST['password2']) ? trim($_POST['password2']) : false;

            $validar = Utils::validate($nombre, $apellidos, $fnacimiento, $email, $password, $password2);
            if ($validar == false) {
                $usuario = new Usuario();
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setNombre_Apellidos($nombre . ' ' . $apellidos);
                $usuario->setFnacimiento($fnacimiento);
                $usuario->setEmail($email);
                $usuario->setPassword($password);

                $file = $_FILES['imagen'];
                $filename = $file['name'];
                $mimetype = $file['type'];

                if ($mimetype == "image/jpg" || $mimetype == "image/jpeg" || $mimetype == "image/png" || $mimetype == "image/gif") {

                    if (!is_dir('uploads/images')) {
                        mkdir('uploads/images', 0777, true);
                    }
                    $usuario->setImagen($filename);
                    move_uploaded_file($file['tmp_name'], 'uploads/images/' . $filename);
                }
                if (isset($_SESSION['admin'])) {
                    $save = $usuario->savePsiquiatra();
                } else {
                    $save = $usuario->save();
                }

                if ($save) {
                    $_SESSION['register'] = "complete";
                } else {
                    $_SESSION['register'] = "failed";
                }
            } else {
                $_SESSION['register'] = $validar;
            }
        } else {
            $_SESSION['register'] = "Algo ha fallado";
        }
        if (isset($_SESSION['admin'])) {
            header("Location:" . base_url . 'usuario/registrarPsiquiatra');
        } else {
            header("Location:" . base_url . 'usuario/registroLogin');
        }
    }

    public function login() {
        if (isset($_POST)) {
            $usuario = new Usuario();
            $usuario->setEmail($_POST['email']);
            $usuario->setPassword($_POST['password']);

            $identity = $usuario->login();

            if ($identity && is_object($identity)) {
                $_SESSION['identity'] = $identity;
                if ($identity->rol == 'estudiante') {
                    $_SESSION['estudiante'] = true;
                } elseif ($identity->rol == 'admin') {
                    $_SESSION['admin'] = true;
                } else {
                    $_SESSION['psiquiatra'] = true;
                }
                header("Location:" . base_url);
            } else {
                header("Location:" . base_url . "usuario/registroLogin");
                $_SESSION['error_login'] = "Identificación fallida, revise sus credenciales";
            }
        }
    }

    public function logout() {
        if (isset($_SESSION['estudiante'])) {
            unset($_SESSION['estudiante']);
        }
        if (isset($_SESSION['admin'])) {
            unset($_SESSION['admin']);
        }
        if (isset($_SESSION['psiquiatra'])) {
            unset($_SESSION['psiquiatra']);
        }
        
        header("Location:" . base_url.'/chatnow/logout.php');
    }

    public function perfilEstudiante() {
        require_once 'views/usuario/perfilEstudiante.php';
    }

    public function perfilPsiquiatra() {
        require_once 'views/usuario/perfilPsiquiatra.php';
    }

    public function actualizarPerfil() {
        require_once 'views/usuario/actualizarPerfil.php';
        if (isset($_SESSION['update'])) {
            unset($_SESSION['update']);
        }
    }

    public function update() {
        if (isset($_POST)) {

            $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : false;
            $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : false;
            $fnacimiento = isset($_POST['fnacimiento']) ? trim($_POST['fnacimiento']) : false;

            $validar = Utils::validateUpdate($nombre, $apellidos, $fnacimiento);
            if ($validar == false) {
                $usuario = new Usuario();
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setNombre_Apellidos($nombre . ' ' . $apellidos);
                $usuario->setFnacimiento($fnacimiento);

                if (isset($_FILES['imagen'])) {
                    $file = $_FILES['imagen'];
                    $filename = $file['name'];
                    $mimetype = $file['type'];

                    if ($mimetype == "image/jpg" || $mimetype == "image/jpeg" || $mimetype == "image/png" || $mimetype == "image/gif") {

                        if (!is_dir('uploads/images')) {
                            mkdir('uploads/images', 0777, true);
                        }
                        $usuario->setImagen($filename);
                        move_uploaded_file($file['tmp_name'], 'uploads/images/' . $filename);
                    }
                }
                $_SESSION['identity']->nombre = $nombre;
                $_SESSION['identity']->apellidos = $apellidos;
                $_SESSION['identity']->fnacimiento = $fnacimiento;

                $save = $usuario->update();

                if ($save) {
                    $_SESSION['update'] = "complete";
                } else {
                    $_SESSION['update'] = "failed";
                }
            } else {
                $_SESSION['update'] = $validar;
            }
        } else {
            $_SESSION['update'] = "Algo ha fallado";
        }
        header("Location:" . base_url . 'usuario/actualizarPerfil');
    }

    public function gestion() {
        $usuario = new Usuario();
        if (isset($_POST['buscador'])) {
            $usuarios = $usuario->getBusqueda($_POST['buscador']);
        } else {
            $usuarios = $usuario->getAll();
        }
        require_once 'views/usuario/gestion.php';
    }

    public function registrarPsiquiatra() {
        require_once 'views/usuario/registrarPsiquiatra.php';
    }

    public function imprimir() {
        $usuario = new Usuario();
        if (isset($_SESSION['admin'])) {
            $usuarios = $usuario->getAll();
        } else {
            $usuarios = $usuario->getEstudiantes();
        }
        $html2pdf = new Html2Pdf();
        ob_start();
        require_once 'views/usuario/imprimirUsuarios.php';
        $html = ob_get_clean();
        ob_end_clean();
        $html2pdf->writeHTML($html);
        $html2pdf->output();
    }

    public function verPerfil() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $usuario = new Usuario();
            $usuario->setId($id);

            $usu = $usuario->getOne();
        }
        require_once 'views/usuario/verPerfil.php';
    }

    public function estudiantesAsignados() {
        $usuario = new Usuario();
        if (isset($_POST['buscador'])) {
            $usuarios = $usuario->getBusquedaE($_POST['buscador']);
        } else {
            $usuarios = $usuario->getEstudiantes();
        }
        require_once 'views/usuario/gestion.php';
    }

    public function verGrafico(){
        require_once 'views/usuario/graficos.php';
    }
    
}
