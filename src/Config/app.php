<?php
// src/Config/app.php

// 1. Definimos las rutas base
define('ROOT_PATH', __DIR__ . '/../../');
define('MODELS_PATH', ROOT_PATH . 'src/Models/');
define('TEMPLATES_PATH', ROOT_PATH . 'templates/');

// 2. CARGA DE LIBRERÍAS (Composer)
// Este archivo gestiona automáticamente la carga de phpdotenv y tus clases
require_once ROOT_PATH . 'vendor/autoload.php';

// 3. INICIALIZAR VARIABLES DE ENTORNO (.env)
try {
    $dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
    $dotenv->load();
} catch (Exception $e) {
    // Si falta el .env, el sistema fallará con un aviso claro
    die("Error: No se encontró el archivo .env en la raíz del proyecto.");
}

// 4. CARGA DE CLASES DEL PROYECTO (Orden de dependencia)
require_once __DIR__ . '/Connection.php';     //
require_once __DIR__ . '/Router.php';         // Asegúrate de que este archivo existe
require_once MODELS_PATH . 'DatabaseManager.php'; //
require_once MODELS_PATH . 'User.php';            //
require_once MODELS_PATH . 'Domain.php';          //