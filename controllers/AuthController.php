<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        global $conn;
        $this->userModel = new User($conn);
    }

    public function showLogin() {
        $error = $_GET['error'] ?? null;
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function login() {
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($email) || empty($password)) {
            header('Location: index.php?action=login&error=campos_vacios');
            exit;
        }

        $usuario = $this->userModel->findByEmail($email);

        // Comprueba si existe el usuario y si el hash coincide
        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id']     = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombreUser'];
            $_SESSION['usuario_rol']    = $usuario['rol'];

            header('Location: index.php?action=index');
            exit;
        }

        header('Location: index.php?action=login&error=credenciales_invalidas');
        exit;
    }

    public function logout() {
        $_SESSION = [];
        session_destroy();
        header('Location: index.php?action=index');
        exit;
    }
}
?>