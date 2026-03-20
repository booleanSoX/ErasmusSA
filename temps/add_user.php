<?php
session_start();
$host = "localhost";
$db   = "users";
$user = "perugia";
$pass = "PERUGIAPSW";

$connection_string = "host=$host dbname=$db user=$user password=$pass";
$dbconn = pg_connect($connection_string);


if (!$dbconn) {
    die("Error de conexión: " . pg_last_error());
}

$password_plana = 'ERASMUSSA';
$password_hasheada = password_hash($password_plana, PASSWORD_BCRYPT);

$query = "INSERT INTO users (username, email, password, name, last_name, id_domain) 
          VALUES ($1, $2, $3, $4, $5, $6)";

$params = [
    'admin',
    'risetode2@gmail.com',
    $password_hasheada,
    'Sebas',
    'Admin',
    null
];

$result = pg_query_params($dbconn, $query, $params);

if ($result) {
    echo "¡Administrador creado con éxito!";
} else {
    echo "Error en la consulta: " . pg_last_error($dbconn);
}

pg_close($dbconn);
?>

?>