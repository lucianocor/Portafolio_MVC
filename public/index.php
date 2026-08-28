<?php
require_once __DIR__ . '/../controllers/MateriaController.php';
require_once __DIR__ . '/../models/Materia.php';
$controller = new MateriaController();
$action     = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        // Carga la página visual del portafolio (HTML)
        $controller->index();
        break;

    case 'listar_json':
        // Devuelve las materias en JSON para materias.js
        $controller->listarJson();
        break;

    case 'store':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') die("Método no permitido");
        $controller->store();
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') die("Método no permitido");
        $controller->update();
        break;

    case 'delete':
        $controller->delete();
        break;

    default:
        http_response_code(404);
        die("Acción no encontrada.");
}