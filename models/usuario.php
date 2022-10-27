<?php

class Usuario {

    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $nombre_apellidos;
    private $password;
    private $fnacimiento;
    private $rol;
    private $imagen;
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

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getNombre_Apellidos() {
        return $this->nombre_apellidos;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return password_hash($this->db->real_escape_string($this->password), PASSWORD_BCRYPT, ['cost' => 4]);
    }

    public function getFnacimiento() {
        return $this->fnacimiento;
    }

    public function getRol() {
        return $this->rol;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $this->db->real_escape_string($nombre);
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $this->db->real_escape_string($apellidos);
    }

    public function setNombre_Apellidos($nombre_apellidos) {
        $this->nombre_apellidos = $nombre_apellidos;
    }

    public function setEmail($email) {
        $this->email = $this->db->real_escape_string($email);
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setFnacimiento($fnacimiento) {
        $this->fnacimiento = $this->db->real_escape_string($fnacimiento);
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function setImagen($imagen) {
        $this->imagen = $imagen;
    }

    public function save() {
        $sql = "INSERT INTO usuarios VALUES(null, '{$this->getNombre()}', '{$this->getApellidos()}','{$this->getNombre_Apellidos()}', '{$this->getEmail()}', '{$this->getPassword()}', '{$this->getFnacimiento()}', 'estudiante', '{$this->getImagen()}');";
        $save = $this->db->query($sql);
        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

    public function login() {
        $result = false;
        $email = $this->email;
        $password = $this->password;

        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $login = $this->db->query($sql);

        if ($login && $login->num_rows == 1) {
            $usuario = $login->fetch_object();

            $verify = password_verify($password, $usuario->password);

            if ($verify) {
                $result = $usuario;
            }
        }
        return $result;
    }

    public function update() {
        $sql = "UPDATE usuarios SET nombre =  '{$this->getNombre()}', apellidos = '{$this->getApellidos()}',nombre_apellidos = '{$this->getNombre_Apellidos()}', fnacimiento = '{$this->getFnacimiento()}'";
        if ($this->getImagen() != null) {
            $sql .= ", imagen = '{$this->getImagen()}'";
            $_SESSION['identity']->imagen = $this->getImagen();
        }

        $sql .= " WHERE id = {$_SESSION['identity']->id};";
        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }
    
    public function getAll() {
        $sql = "SELECT * FROM usuarios WHERE rol='estudiante' OR rol='psiquiatra' ORDER BY id DESC";
        $usuarios = $this->db->query($sql);
        return $usuarios;
    }

    public function getEstudiantes() {
        $sql = "SELECT u.* FROM usuarios u INNER JOIN conversaciones c ON u.id=c.usuario_id WHERE c.psiquiatra_id={$_SESSION['identity']->id} ORDER BY id DESC";
        $usuarios = $this->db->query($sql);
        return $usuarios;
    }

    public function getBusquedaE($busqueda) {
        $sql = "SELECT u.* FROM usuarios u INNER JOIN conversaciones c ON u.id=c.usuario_id WHERE (c.psiquiatra_id={$_SESSION['identity']->id}) AND (u.nombre LIKE '%$busqueda%' OR u.apellidos LIKE '%$busqueda%' OR u.email LIKE '%$busqueda%')";
        $usuarios = $this->db->query($sql);
        return $usuarios;
    }

    public function getBusqueda($busqueda) {
        $sql = "SELECT * FROM usuarios WHERE (rol='estudiante' OR rol='psiquiatra') AND (nombre LIKE '%$busqueda%' OR apellidos LIKE '%$busqueda%' OR email LIKE '%$busqueda%') ORDER BY id DESC";
        $usuarios = $this->db->query($sql);
        return $usuarios;
    }

    public function getOne() {
        $sql = "SELECT * FROM usuarios WHERE id = {$this->getId()}";
        $usuario = $this->db->query($sql);
        return $usuario->fetch_object();
    }

    public function getUsuarioId() {
        $sql = "SELECT id FROM usuarios WHERE nombre_apellidos = '{$this->getNombre_Apellidos()}'";
        $usuario = $this->db->query($sql);
        return $usuario->fetch_object();
    }

    public function savePsiquiatra() {
        $sql = "INSERT INTO usuarios VALUES(null, '{$this->getNombre()}', '{$this->getApellidos()}', '{$this->getNombre_Apellidos()}', '{$this->getEmail()}', '{$this->getPassword()}', '{$this->getFnacimiento()}', 'psiquiatra', '{$this->getImagen()}');";
        $save = $this->db->query($sql);

        $result = false;
        if ($save) {
            $result = true;
        }
        return $result;
    }

}
