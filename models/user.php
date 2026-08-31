<?php
class User {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function findByEmail($email) {
        $stmt = mysqli_prepare($this->db, "SELECT * FROM users WHERE emailUser = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($resultado);
    }
}
?>