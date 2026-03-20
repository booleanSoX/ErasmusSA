<?php
require_once __DIR__ . '/../Config/app.php';

session_start();
header('Content-Type: application/json');

try {
    $database = new Connnection();
    $databaseManager = new DatabaseManager($database); 

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if ($databaseManager->checkUserExists($email, $username)) {
            echo json_encode(['status' => 'error', 'message' => 'Usuario o email ya en uso.']);
        } else {
            $result = $databaseManager->createUser($username, $email, $password, $_POST['name'], $_POST['last_name']);
            echo $result ? json_encode(['status' => 'success', 'redirect' => 'index?msg=account_created']) 
                        : json_encode(['status' => 'error', 'message' => 'Error al crear cuenta.']);
        }
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}