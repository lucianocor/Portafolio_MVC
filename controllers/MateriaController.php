<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/Materia.php';

class MateriaController {
    private $model;

    public function __construct() {
        global $conn;
        $this->model = new Materia($conn);
    }

    
    private function requireAdmin() {
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Acceso denegado: se requieren permisos de administrador']);
            exit;
        }
    }

    public function index() {
        require_once __DIR__ . '/../views/materias/index.php';
    }

    public function listarJson() {
        header('Content-Type: application/json; charset=utf-8');
        $resultado = $this->model->getAll();
        $materias = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $materias[] = $fila;
        }
        echo json_encode($materias);
        exit;
    }

    public function store() {
        $this->requireAdmin(); 
        // Protegido

        header('Content-Type: application/json; charset=utf-8');
        $nombre = trim($_POST['nombre'] ?? '');
        $estado = trim($_POST['estado'] ?? 'Cursando');
        $anio   = isset($_POST['anio']) ? (int)$_POST['anio'] : 1;

        if (empty($nombre) || $anio <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos inválidos']);
            exit;
        }

        $id = $this->model->create($nombre, $estado, $anio);
        echo json_encode($id ? ['success' => true] : ['error' => 'Error al guardar']);
        exit;
    }

    public function update() {
        $this->requireAdmin(); // Protegido

        header('Content-Type: application/json; charset=utf-8');
        $id     = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        $nombre = trim($_POST['nombre'] ?? '');
        $estado = trim($_POST['estado'] ?? '');
        $anio   = isset($_POST['anio']) ? (int)$_POST['anio'] : null;

        if (!$id || empty($nombre) || empty($estado) || !$anio) {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos']);
            exit;
        }

        $ok = $this->model->update($id, $nombre, $estado, $anio);
        echo json_encode($ok ? ['success' => true] : ['error' => 'Error al actualizar']);
        exit;
    }

    public function delete() {
        $this->requireAdmin(); // Protegido

        header('Content-Type: application/json; charset=utf-8');
        $id = filter_var($_POST['id']  ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido']);
            exit;
        }

        $ok = $this->model->delete($id);
        echo json_encode($ok ? ['success' => true] : ['error' => 'Error al eliminar']);
        exit;
    }
}
?>