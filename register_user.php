<?php
session_start();
$host = "localhost";
$db   = "users";
$user = "perugia";
$pass = "PERUGIAPSW";




<?php
// 1. Datos de conexión
$host = 'localhost';
$db   = 'users';
$user = 'perugia';
$pass = 'PERUGIAPSW';

// La cadena de conexión para pg_connect es diferente a la de PDO
$connection_string = "host=$host dbname=$db user=$user password=$pass";
$dbconn = pg_connect($connection_string);

if (!$dbconn) {
    die("Error de conexión: " . pg_last_error());
}

// 2. Contraseña
$password_plana = $_POST['password'] ?? '';
$password_hasheada = password_hash($password_plana, PASSWORD_BCRYPT);

// 3. Inserción (Las funciones pg_ usan $1, $2... en lugar de :nombre)
$query = "INSERT INTO users (username, email, password, name, last_name, id_domain) 
          VALUES ($1, $2, $3, $4, $5, $6)";

$params = [
    'admin',
    'risetode2@gmail.com',
    $password_hasheada,
    'Sebas',
    'Admin',
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