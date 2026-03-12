<?php
include_once 'Database.php';
include_once 'DatabaseManager.php';

session_start();

$database = new Database();
$databaseManager = new DatabaseManager($database); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $user = trim($_POST['user'] ?? '');

    if ($email !== '' && ) {
        $user_data = $databaseManager->getUserByEmail($email);

        if ($user_data) {
            $new_password = bin2hex(random_bytes(4)); 
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            if ($databaseManager->updateUserPassword($user_data['id_user'], $hashed_password)) {
                echo "La tua nuova password è: " . $new_password;
            } else {
                echo "Errore durante l'aggiornamento della password.";
            }
        } else {
            echo "Nessun utente trovato con questo indirizzo email.";
        }
    } else {
        echo "Per favore, inserisci un indirizzo email valido.";
    }
}