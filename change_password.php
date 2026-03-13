<?php
include_once 'Database.php';
include_once 'DatabaseManager.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$database = new Database();
$databaseManager = new DatabaseManager($database); 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_new_password'] ?? ''); 

    if ($password === '' || $confirm_password === '') {
        $_SESSION['error'] = "Por favor, completa todos los campos.";
        header("Location: change_password_view.php");
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Las contraseñas no coinciden.";
        header("Location: change_password_view.php");
        exit();
    }

    if ($databaseManager->updateUserPassword($_SESSION['user_id'], $password)) {
        header("Location: index.html");
        exit();
    } else {
        $_SESSION['error'] = "Hubo un problema al actualizar la base de datos.";
        header("Location: change_password_view.php");
        exit();
    }
} else {
    header("Location: change_password_view.php");
    exit();
}