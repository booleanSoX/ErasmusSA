<?php
include_once 'Database.php';
include_once 'DatabaseManager.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $domain_name = trim($_POST['domain_name'] ?? '');
    $expiration_date = $_POST['expiration_date'] ?? '';
    $user_id = $_SESSION['user_id'];
    
    if (empty($domain_name) || empty($expiration_date)) {
        die("Error: Faltan datos obligatorios.");
    }
    
    if (!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$/', $domain_name)) {
        die("Error: Formato de dominio inválido.");
    }

    $hoy = new DateTime();
    $fecha_exp = new DateTime($expiration_date);

    if ($fecha_exp <= $hoy) {
        die("Error: La fecha de caducidad debe ser posterior a hoy.");
    }

    $registration_date = $hoy->format('Y-m-d');
    $domain_state = 'Pendiente';

    $database = new Database();
    $databaseManager = new DatabaseManager($database);
    
    $success = $databaseManager->addDomain($user_id, $domain_name, $domain_state, $registration_date, $expiration_date);

    if ($success) {
        header("Location: main.php");
        exit;
    } else {
        echo "Error al guardar en la base de datos.";
    }
} else {
    header("Location: main.php");
    exit;
}
?>