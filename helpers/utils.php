<?php

class Utils {

    public static function deleteSession($name) {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
        return $name;
    }

    public static function validate($nombre, $apellidos, $fnacimiento, $email, $password, $password2) {
        $error = true;

        if (empty($nombre) || empty($apellidos) || empty($fnacimiento) || empty($email) || empty($password)) {
            $error = "<strong class='alert-red'>Por favor, no dejar campos en blanco</strong>";
            return $error;
        } else {
            $error = false;
        }

        if (is_numeric($nombre) || preg_match("/[0-9]/", $nombre)) {
            $error = "<strong class='alert-red'>Por favor, introduzca un nombre válido</strong>";
            return $error;
        } else {
            $error = false;
        }

        if (is_numeric($apellidos) || preg_match("/[0-9]/", $apellidos)) {
            $error = "<strong class='alert-red'>Por favor, introduzca apellidos válidos</strong>";
            return $error;
        } else {
            $error = false;
        }

        $sql = "SELECT email FROM usuarios WHERE email = '$email'";
        $conexion = Database::connect();
        $result = mysqli_fetch_assoc($conexion->query($sql));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "<strong class='alert-red'>Por favor introduzca un email válido</strong>";
            return $error;
        } elseif (!empty($result)) {
            $error = "<strong class='alert-red'>El email ya esta registrado</strong>";
            return $error;
        } else {
            $error = false;
        }

        if (strlen($password) <= 8) {
            $error = "<strong class='alert-red'>Por favor introduzca una contraseña válida, mínimo 8 carácteres</strong>";
            return $error;
        } else {
            $error = false;
        }

        if ($password != $password2) {
            $error = "<strong class ='alert-red'>Las contraseñas no coinciden</strong>";
            return $error;
        } else {
            $error = false;
        }

        return $error;
    }

    public static function validateUpdate($nombre, $apellidos, $fnacimiento) {
        $error = true;

        if (empty($nombre) || empty($apellidos) || empty($fnacimiento)) {
            $error = "<strong class='alert-red'>Por favor, no dejar campos en blanco</strong>";
            return $error;
        } else {
            $error = false;
        }

    if (is_numeric($nombre) || preg_match("/[0-9]/", $nombre)) {
            $error = "<strong class='alert-red'>Por favor, introduzca un nombre válido</strong>";
            return $error;
        } else {
            $error = false;
        }

        if (is_numeric($apellidos) || preg_match("/[0-9]/", $apellidos)) {
            $error = "<strong class='alert-red'>Por favor, introduzca apellidos válidos</strong>";
            return $error;
        } else {
            $error = false;
        }

        return $error;
    }

    public static function validateTest($nombre, $pregunta1, $pregunta2, $pregunta3, $pregunta4, $pregunta5) {
        $error = true;

        if (empty($nombre)) {
            $error = "<strong class='alert-red'>Por favor, ingrese el nombre del test</strong>";
            return $error;
        } else {
            $error = false;
        }

        if (empty($pregunta1) || empty($pregunta2) || empty($pregunta3) || empty($pregunta4) || empty($pregunta5)) {
            $error = "<strong class='alert-red'>Por favor, el test debe tener al menos cinco campos llenos</strong>";
            return $error;
        } else {
            $error = false;
        }
        return $error;
    }
    

    public static function showEstudiantes() {
        require_once 'models/conversacion.php';
        $conversacion = new Conversacion();
        $estudiantes = $conversacion->getEstudiantes();
        return $estudiantes;
    }

    public static function validateActa($estudiante, $fecha, $hora) {
        $error = true;

        if (empty($estudiante) || empty($fecha) || empty($hora)) {
            $error = "<strong class='alert-red'>Por favor, no dejar campos en blanco</strong>";
            return $error;
        } else {
            $error = false;
        }

        return $error;
    }

}
