<?php
include_once 'Database.php';
include_once 'DatabaseManager.php';
include_once 'DatabaseViewer.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}


$timeout = 900; 


$database = new Database();
$databaseManager = new DatabaseManager($database);
$databaseViewer = new DatabaseViewer($databaseManager);

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




$domains_result = $databaseManager->getUserDomains($_SESSION['user_id']);
$emails_result = $databaseManager->getUserEmailsPerDomain($_SESSION['user_id']);
include 'main_view.php';
?>