<?php
session_start();

$host = "localhost";
$db   = "users";
$user = "perugia";
$pass = "PERUGIAPSW";

$conn = pg_connect("host=$host dbname=$db user=$user password=$pass");
if (!$conn) {
    die("Errore di connessione al database.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username !== '' && $password !== '') {

        $query = "SELECT id_user, username, password FROM users WHERE username = $1";
        $result = pg_query_params($conn, $query, array($username));

        if ($result && pg_num_rows($result) > 0) {
            $user = pg_fetch_assoc($result);
            $login_correcto = password_verify($password, $user['password']);
        } else {
            $login_correcto = false;
        }

        if ($login_correcto) {
            session_regenerate_id(true);

            $_SESSION['user_id']  = $user['id_user'];
            $_SESSION['username'] = $user['username'];

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





