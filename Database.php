<?php
class Database {
    private $connection;
    private $host = "localhost";
    private $db   = "users";
    private $user = "perugia";
    private $pass = "PERUGIAPSW";  

    public function __construct() {
        $this->connection = pg_connect("host=$this->host dbname=$this->db user=$this->user password=$this->pass");
        if (!$this->connection) {
            throw new Exception("Error crítico: No se pudo establecer la conexión con la base de datos PostgreSQL.");
        }
    }

    public function query($sql) {
        return pg_query($this->connection, $sql);
    }

    public function getConnection() {
        return $this->connection;
    }  
}
?>