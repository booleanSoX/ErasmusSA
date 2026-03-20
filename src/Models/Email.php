<?php
class Email {
    private Connection $conn;

    public function __construct(Connection $conn) {
        $this->conn = $conn;
    }

    public function getEmailsPerUser(String $id_user): array {
        $sql = "SELECT e.email_address, d.domain_name, e.current_size, e.quota_limit, e.last_login
                FROM emails e 
                JOIN domains d ON e.id_domain = d.id_domain 
                WHERE d.id_user = $1
                ORDER BY e.email_address ASC, d.domain_name ASC";  
    
        $result = pg_query_params($this->Database->getConnection(), $sql, [$id_user]);
        if ($result) {
            return pg_fetch_all($result) ?: [];
        }
        return [];
    }

    




    }
