<?php
include_once 'Database.php';
include_once 'DatabaseManager.php';
include_once 'DatabaseViewer.php';

$database = new Database();
$databaseManager = new DatabaseManager($database);
$databaseViewer = new DatabaseViewer($databaseManager); 









?>