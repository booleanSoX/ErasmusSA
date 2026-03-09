<?php
include_once 'data.php';
session_start();

$database = new Database();
$ddbbManager = new DataManager($database->getConnection());

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username !== '' && $password !== '') {
        $query = "SELECT id_user, username, password FROM users WHERE username = $1";
        // USAMOS EL MÉTODO DE LA CLASE:
        $result = $ddbbManager->$database.query($query, [$username]);

        if ($result && pg_num_rows($result) > 0) {
            $user_data = pg_fetch_assoc($result);
            $login_correcto = password_verify($password, $user_data['password']);
        } else {
            $login_correcto = false;
        }

        if ($login_correcto) {
            session_regenerate_id(true);
            $_SESSION['user_id']  = $user_data['id_user'];
            $_SESSION['username'] = $user_data['username'];
            header("Location: main.php");
            exit;
        } else {
            echo "Nome utente o password errati.";
        }
    } else {
        echo "Per favore, compila tutti i campi.";
    }
}
?>

