<?php
declare(strict_types=1);

class DatabaseManager {
    private Database $Database;

 
    public function __construct(Database $Database) {
        $this->Database = $Database;
    }

 
    public function querySingle(string $sql, array $params = []): ?array {
        $result = pg_query_params($this->Database->getConnection(), $sql, $params);
        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        }
        return null;
    }


    public function query(string $sql, array $params = []) {
        return pg_query_params($this->Database->getConnection(), $sql, $params);
    }

    public function getUsers(): array {
        $result = pg_query($this->Database->getConnection(), "SELECT * FROM users");
        $data = pg_fetch_all($result);
        return $data ?: []; 
    }

    public function getUserByIdOrgetUsers(?int $id = null): array {
        if ($id === null) {
            return $this->getUsers();
        }
        
        $result = pg_query_params($this->Database->getConnection(), "SELECT * FROM users WHERE id_user = $1", [$id]);
        $data = pg_fetch_assoc($result);
        
        return $data ?: [];
    }

    public function getUserByUsername(string $username): ?array {
        $result = pg_query_params($this->Database->getConnection(), "SELECT * FROM users WHERE username = $1", [$username]);
        
        if ($result && pg_num_rows($result) > 0) {
            $data = pg_fetch_assoc($result);
            return $data ?: [];
        }
        
        return null;
    }

    public function getUserByEmail(string $email): ?array {
        $result = pg_query_params($this->Database->getConnection(), "SELECT * FROM users WHERE email = $1", [$email]);
        
        if ($result && pg_num_rows($result) > 0) {
            $data = pg_fetch_assoc($result);
            return $data ?: [];
        }
        
        return null;
    }

    public function checkUserExists(string $username, string $email): bool {
        $user = $this->getUserByUsername($username);
        $email_user = $this->getUserByEmail($email);
        return (bool)$user || (bool)$email_user;
    }

   public function verifyUserAndPassword(string $login, string $password): bool {
    $user = $this->getUserByUsername($login) ?: $this->getUserByEmail($login);
    
    if ($user && isset($user['password'])) {
        return password_verify($password, $user['password']);
    }
    return false;
}

   public function createUser(string $username, string $email, string $password, string $name, string $last_name, string $second_last_name = ''): bool {
    $query = "INSERT INTO users (username, email, password, name, last_name, second_last_name) 
              VALUES ($1, $2, $3, $4, $5, $6)";
              
    $password_hasheada = $this->hashPassword($password);

    $params = [$username, $email, $password_hasheada, $name, $last_name, $second_last_name];

    $result = pg_query_params($this->Database->getConnection(), $query, $params);
    return pg_returning($result) > 0;
}

    public function deleteUser(int $id): bool {
        $result = pg_query_params($this->Database->getConnection(), "DELETE FROM users WHERE id_user = $1", [$id]);
        return (bool)$result;
    }

    public function updateUser(int $id, string $username, string $email, string $name, string $last_name): bool {
        $sql = "UPDATE users SET username = $1, email = $2, name = $3, last_name = $4 WHERE id_user = $5";
        $result = pg_query_params($this->Database->getConnection(), $sql, [$username, $email, $name, $last_name, $id]);
        return (bool)$result;
    }

    public function updateUsername(int $id, string $username): bool {
        $sql = "UPDATE users SET username = $1 WHERE id_user = $2";
        $result = pg_query_params($this->Database->getConnection(), $sql, [$username, $id]);
        return (bool)$result;
    }

    public function updateEmail(int $id, string $email): bool {
        $sql = "UPDATE users SET email = $1 WHERE id_user = $2";
        $result = pg_query_params($this->Database->getConnection(), $sql, [$email, $id]);
        return (bool)$result;
    }

 public function getUserDomains(int $user_id): array {
    $sql = "SELECT domain_name, domain_state 
            FROM domains 
            WHERE id_user = $1 
            ORDER BY domain_name ASC";
    $result = pg_query_params($this->Database->getConnection(), $sql, [$user_id]);
    return pg_fetch_all($result) ?: [];
}

    public function getUserEmailsPerDomain(int $user_id): array {
        $sql = "Select d.domain_name, e.email_address, e.size 
                FROM emails e 
                JOIN domains d ON e.id_domain = d.id_domain 
                WHERE d.id_user = $1 
                ORDER BY d.domain_name ASC, e.email_address ASC";
        $result = pg_query_params($this->Database->getConnection(), $sql, [$user_id]);
        return pg_fetch_all($result) ?: [];
    }


    public function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT);
    }


    

}
?>