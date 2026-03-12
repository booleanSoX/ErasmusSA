<?php
include_once 'Database.php';
include_once 'DatabaseManager.php';

session_start();

$database = new Database();
$databaseManager = new DatabaseManager($database); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $name = $_POST['name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $second_last_name = $_POST['second_last_name'] ?? '';

    if ($databaseManager->checkUserExists($username, $email)) {
        echo "Error: El nombre de usuario o el correo electrónico ya están en uso.";
        exit;
    } else {
        $result = $databaseManager->createUser(
            $username, 
            $email, 
            $password, 
            $name, 
            $last_name, 
            $second_last_name
        );
        
        if ($result) {
            header("Location: main.php");
            exit;
        } else {
            echo "Error en la consulta: " . pg_last_error($database->getConnection());
        }
    }
}
?>