<?php
session_start();

require_once __DIR__ . '/../controllers/MateriaController.php';
require_once __DIR__ . '/../controllers/AuthController.php';

$materiaController = new MateriaController();
$authController    = new AuthController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $materiaController->index();
        break;

    case 'listar_json':
        $materiaController->listarJson();
        break;

    case 'store':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') die("Método no permitido");
        $materiaController->store();
        break;

    case 'update':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') die("Método no permitido");
        $materiaController->update();
        break;

   case 'delete':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') die("Método no permitido");
        $materiaController->delete();
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController->login();
        } else {
            $authController->showLogin();
        }
        break;

    case 'logout':
        $authController->logout();
        break;

    default:
        http_response_code(404);
        die("Acción no encontrada.");
}