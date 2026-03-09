<?php
include_once 'data.php';
include_once 'dataManagement.php';
session_start();

$timeout = 900; 
if (isset($_SESSION['last_activity'])) {
    $inactive = time() - $_SESSION['last_activity'];
    if ($inactive > $timeout) {
        session_unset();
        session_destroy();
        header("Location: index.html?timeout=1");
        exit;
    }
}
$_SESSION['last_activity'] = time();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}

$conn = new Database();
$ddbbManager = new DatabaseManager($conn->getConnection());

$user_id = $_SESSION['user_id'];
$user_data = $ddbbManager->querySingle("SELECT name, last_name, email, username FROM users WHERE id_user = $user_id");

include 'profile_view.php';
?>