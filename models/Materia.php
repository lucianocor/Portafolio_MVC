<?php
class Materia {
    private $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    public function getAll() {
        $sql = "SELECT MateriaId, NombreMateria, Anio, Estado FROM materias ORDER BY Anio ASC, NombreMateria ASC";
        return mysqli_query($this->db, $sql);
    }

    public function getById($id) {
        $stmt = mysqli_prepare($this->db, "SELECT * FROM materias WHERE MateriaId = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($resultado);
    }

    public function create($nombre, $estado, $anio) {
        $stmt = mysqli_prepare($this->db, "INSERT INTO materias (NombreMateria, Estado, Anio) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssi", $nombre, $estado, $anio);
        $ok = mysqli_stmt_execute($stmt);
        $idGenerado = mysqli_insert_id($this->db);
        mysqli_stmt_close($stmt);
        return $ok ? $idGenerado : false;
    }

    public function update($id, $nombre, $estado, $anio) {
        $stmt = mysqli_prepare($this->db, "UPDATE materias SET NombreMateria = ?, Estado = ?, Anio = ? WHERE MateriaId = ?");
        mysqli_stmt_bind_param($stmt, "ssii", $nombre, $estado, $anio, $id);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    }

    public function delete($id) {
        $stmt = mysqli_prepare($this->db, "DELETE FROM materias WHERE MateriaId = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    }
}
?>