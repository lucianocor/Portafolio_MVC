<?php
require_once __DIR__ . '/../config/conexion.php';

class MateriaController {
    private $model;

    public function __construct() {
        global $conn;
        $this->model = new Materia($conn);
    }

    // 1. CARGA LA VISTA VISUAL (HTML)
    public function index() {
        require_once __DIR__ . '/../views/materias/index.php';
    }

    // 2. DEVUELVE EL JSON PARA JAVASCRIPT
    public function listarJson() {
        header('Content-Type: application/json; charset=utf-8');
        $resultado = $this->model->getAll();
        $materias = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $materias[] = $fila;
        }
        echo json_encode($materias);
    }

    // 3. CREAR
    public function store() {
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
        if ($id) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al guardar']);
        }
    }

    // 4. ACTUALIZAR
    public function update() {
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

        if ($this->model->update($id, $nombre, $estado, $anio)) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al actualizar']);
        }
    }

    // 5. ELIMINAR
    public function delete() {
        header('Content-Type: application/json; charset=utf-8');
        $id = filter_var($_POST['id'] ?? $_GET['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id) {
            http_response_code(400);
            echo json_encode(['error' => 'ID inválido']);
            exit;
        }

        if ($this->model->delete($id)) {
            echo json_encode(['success' => true]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Error al eliminar']);
        }
    }
}