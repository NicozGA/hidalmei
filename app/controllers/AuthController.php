<?php
namespace App\Controllers;

use Core\Controller;

class AuthController extends Controller {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = $this->model('Usuario');
    }

    public function login() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $usuario = $this->usuarioModel->obtenerPorEmail($email);

            if ($usuario && password_verify($password, $usuario['password'])) {
                $_SESSION['usuario_id'] = $usuario['id_usuario'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_rol'] = $usuario['rol'] ?? 'Cliente';
                header('Location: /productos');
                exit;
            } else {
                $error = 'Credenciales incorrectas';
            }
        }
        $this->view('auth/login', ['error' => $error]);
    }

    public function registro() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (!empty($nombre) && !empty($email) && !empty($password)) {
                $hash = password_hash($password, PASSWORD_BCRYPT);
                if ($this->usuarioModel->registrar($nombre, $email, $hash)) {
                    header('Location: /auth/login');
                    exit;
                } else {
                    $error = 'El correo ya está registrado';
                }
            } else {
                $error = 'Por favor completa todos los campos';
            }
        }
        $this->view('auth/registro', ['error' => $error]);
    }

    public function logout() {
        unset($_SESSION['usuario_id']);
        unset($_SESSION['usuario_nombre']);
        unset($_SESSION['usuario_rol']);
        session_destroy();
        header('Location: /auth/login');
        exit;
    }
}