<?php
// src/Config/Connection.php

class Connection {
    private $connection;

    public function __construct() {
        // En un entorno de producción, estos valores deben venir de variables de entorno (.env)
        $host = getenv('DB_HOST') ?: 'localhost';
        $db   = getenv('DB_NAME') ?: 'users';
        $user = getenv('DB_USER') ?: 'perugia';
        $pass = getenv('DB_PASS') ?: 'PERUGIAPSW';

        $connString = sprintf("host=%s dbname=%s user=%s password=%s", $host, $db, $user, $pass);
        
        $this->connection = pg_connect($connString);
        
        if (!$this->connection) {
            // Lanza excepción real en lugar de silenciar el error
            throw new Exception("Error crítico: No se pudo conectar a PostgreSQL.");
        }
    }

    public function getConnection() {
        return $this->connection;
    }  
}