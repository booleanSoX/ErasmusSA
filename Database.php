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
            die("Error de conexión a la base de datos.");
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