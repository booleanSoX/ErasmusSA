<?php
session_start();
$host = "localhost";
$db   = "users";
$user = "perugia";
$pass = "PERUGIAPSW";

$connection_string = "host=$host dbname=$db user=$user password=$pass";
$dbconn = pg_connect($connection_string);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (!$dbconn) {
    die("Error de conexión: " . pg_last_error());
}

$password_plana = $_POST['password'] ?? '';
$password_hasheada = password_hash($password_plana, PASSWORD_BCRYPT);

$query = "INSERT INTO users (username, email, password, name, last_name, second_last_name) 
          VALUES ($1, $2, $3, $4, $5, $6)";



$params = [
    $_POST['username'] ?? '', 
    $_POST['email'] ?? '',
    $password_hasheada,
    $_POST['name'] ?? '',
    $_POST['last_name'] ?? '',
    $_POST['second_last_name'] ?? '',

];


$check_query = "SELECT 1 FROM users WHERE username = $1 OR email = $2";

$check_result = pg_query_params($dbconn, $check_query, [
    $_POST['username'], 
    $_POST['email']
]);

if (pg_num_rows($check_result) > 0) {

    //queda ponerlo en un mensaje de error en la página de registro
    echo "Error: El nombre de usuario o el correo electrónico ya están en uso.";
exit;
} else {
    $result = pg_query_params($dbconn, $query, $params);
    if ($result) {
        header("Location: main.php");
        exit;
    } else {
        //esto tambien debería ser un mensaje de error en la página de registro
        echo "Error en la consulta: " . pg_last_error($dbconn);
    }
}}

pg_close($dbconn);
?>