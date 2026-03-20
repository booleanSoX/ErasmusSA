<?php
// templates/main.php

// No vuelvas a poner session_start() aquí, ya se inició en index.php

if (!isset($_SESSION['user_id'])) {
    // Redirigimos a la ruta lógica 'index', no a una carpeta física
    header("Location: index"); 
    exit();
}
?>