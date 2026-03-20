<?php
require_once __DIR__ . '/../src/Config/app.php'; 

session_start();

try {
    $conn = new Connection();
    $userModel = new User($conn);
    
    $router = new Router($userModel);
    $router->run();

} catch (Exception $e) {
    error_log("Error crítico en Index: " . $e->getMessage());
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Error interno del servidor.']);
    exit;
}