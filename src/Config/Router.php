<?php
// src/Config/Router.php

class Router {
    private string $uri;
    private string $method;
    private User $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->prepareUri();
    }

    private function prepareUri(): void {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // Limpiamos la ruta base del proyecto en XAMPP
        $path = str_ireplace('/ErasmusSA/public/', '', $path); 
        $this->uri = trim($path, '/');
    }

    public function run(): void {
        // 1. Ruta raíz o index
        if ($this->uri === '' || $this->uri === 'index') {
            $this->renderTemplate('auth/index.html');
            return;
        }

        // 2. Ruta Main (Protegida)
        if ($this->uri === 'main') {
            if (!isset($_SESSION['user_id'])) {
                header('Location: index'); // Redirección relativa a la base
                exit;
            }
            $this->renderTemplate('main.php');
            return;
        }

        // 3. Manejo de Login (POST)
        if ($this->uri === 'login' && $this->method === 'POST') {
            $this->handleLogin();
            return;
        }

        // 4. Resolución dinámica de vistas (Registro, recuperar contraseña, etc.)
        if ($this->resolveView()) {
            return;
        }

        $this->sendNotFound();
    }

    private function handleLogin(): void {
        header('Content-Type: application/json');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->verifyCredentials($username, $password);

        if ($user) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            echo json_encode(['status' => 'success']);
        } else {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Credenciales inválidas.']);
        }
    }

    private function resolveView(): bool {
        // Intentamos cargar .php o .html desde la raíz de templates o desde auth/
        $searchPaths = [
            TEMPLATES_PATH . $this->uri . '.php',
            TEMPLATES_PATH . $this->uri . '.html',
            TEMPLATES_PATH . 'auth/' . $this->uri . '.html'
        ];

        foreach ($searchPaths as $file) {
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
        }
        return false;
    }

    private function renderTemplate(string $path): void {
        $fullPath = TEMPLATES_PATH . $path;
        if (file_exists($fullPath)) {
            require_once $fullPath;
        } else {
            $this->sendNotFound();
        }
    }

    private function sendNotFound(): void {
        http_response_code(404);
        echo "404 - Página no encontrada. URI: " . htmlspecialchars($this->uri);
    }
}