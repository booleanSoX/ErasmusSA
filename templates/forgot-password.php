<?php
include_once 'Database.php';
include_once 'DatabaseManager.php';

session_start();

$database = new Database();
$databaseManager = new DatabaseManager($database); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    if ($email !== '') {
        $user_data = $databaseManager->getUserByEmail($email);
            if ($user_data && $user_data['username'] === trim($_POST['user'] ?? '')) {
                $_SESSION['user_id'] = $user_data['id_user']; 
                header("Location: change_password.php"); 
                exit();
        } else {
            echo "No se encontró ningún usuario con ese email y nombre de usuario.";
        }
    } else {    
        echo "Per favore, inserisci un indirizzo email valido.";
    }
} else {
    echo "Per favore, invia una richiesta POST.";
}



?>  