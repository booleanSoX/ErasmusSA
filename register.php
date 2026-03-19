<?php
include_once 'Database.php';
include_once 'DatabaseManager.php';

session_start();

// Indicamos que la respuesta es JSON
header('Content-Type: application/json');

$database = new Database();
$databaseManager = new DatabaseManager($database); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $second_last_name = $_POST['second_last_name'] ?? '';

    if ($databaseManager->checkUserExists($email, $username)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'El nombre de usuario o el correo electrónico ya están en uso.'
        ]);
        exit;
    } else {
        $result = $databaseManager->createUser($username, $email, $password, $name, $last_name, $second_last_name);
        
        if ($result) {
            // AQUÍ ESTÁ EL CAMBIO: Enviamos la señal en la URL
            echo json_encode(['status' => 'success', 'redirect' => 'index.html?msg=account_created']);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error técnico al crear la cuenta.']);
            exit;
        }
    }
}