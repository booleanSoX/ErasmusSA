<?php
include_once 'Database.php';
include_once 'DatabaseManager.php';
include_once 'DatabaseViewer.php';

session_start();

header('Content-Type: application/json');

$database = new Database();
$ddbbManager = new DatabaseManager($database);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username !== '' && $password !== '') {

        $user_data = $ddbbManager->getUserByUsername($username);
        $login_correcto = false;

        if ($user_data) {
            $login_correcto = password_verify($password, $user_data['password']);
        }

        if ($login_correcto) {
            session_regenerate_id(true);
            $_SESSION['user_id']  = $user_data['id_user'];
            $_SESSION['username'] = $user_data['username'];
            
            echo json_encode(['status' => 'success']);
            exit;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Nombre de usuario o contraseña incorrectos.']);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Por favor, rellena todos los campos.']);
        exit;
    }
}
?>