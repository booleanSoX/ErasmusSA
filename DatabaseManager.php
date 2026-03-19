<?php

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
        if ($result) {
            $data = pg_fetch_all($result);
            return $data ?: [];
        }
        return [];
    }

    // Fixed method name for clarity
    public function getUserByIdOrGetUsers(?int $id = null): array {
        if ($id === null) {
            return $this->getUsers();
        }
        $result = pg_query_params($this->Database->getConnection(), "SELECT * FROM users WHERE id_user = $1", [$id]);
        if ($result && pg_num_rows($result) > 0) {
            $data = pg_fetch_assoc($result);
            return $data ? [$data] : [];
        }
        return [];
    }

    public function getUserByUsername(string $username): ?array {
        $result = pg_query_params($this->Database->getConnection(), "SELECT * FROM users WHERE username = $1", [$username]);
        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        }
        return null;
    }

    public function getUserByEmail(string $email): ?array {
        $result = pg_query_params($this->Database->getConnection(), "SELECT * FROM users WHERE email = $1", [$email]);
        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        }
        return null;
    }


    public function getEmailsPerUser(String $id_user): array {
        $sql = "SELECT e.email_address, d. domain_name, e.current_size, e.quota_limit, e.last_login
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

    public function checkUserExists(string $email, string $username): bool {
        // Clearer logic: check if either method returns non-null
        return $this->getUserByUsername($username) !== null || $this->getUserByEmail($email) !== null;
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
        // Fixed variable name
        $hashed_password = $this->hashPassword($password);
        $params = [$username, $email, $hashed_password, $name, $last_name, $second_last_name];
        $result = pg_query_params($this->Database->getConnection(), $query, $params);
        return (bool)$result;
    }

    public function getUserDomains(int $user_id): array {
        $sql = "SELECT domain_name, domain_state, registration_date, expiration_date 
                FROM domains 
                WHERE id_user = $1 
                ORDER BY domain_name ASC";
       $result = pg_query_params($this->Database->getConnection(), $sql, [$user_id]);

        if (!$result) {
        return [];
        }
        return pg_fetch_all($result) ?: [];
    }

    public function getUserEmailsPerDomain(int $user_id): array {
        $sql = "SELECT e.email_address, e.current_size, d.domain_name, e.quota_limit, e.last_login
                FROM emails e 
                JOIN domains d ON e.id_domain = d.id_domain 
                WHERE d.id_user = $1
                ORDER BY e.email_address ASC";
        $result = pg_query_params($this->Database->getConnection(), $sql, [$user_id]);
        return [];
    }

    public function getUserFiles(int $user_id): array {
        $sql = "SELECT id_file, file_name, extension, mime_type, file_size 
                FROM files 
                WHERE id_user = $1 
                ORDER BY file_name ASC";
        $result = pg_query_params($this->Database->getConnection(), $sql, [$user_id]);
        if ($result) {
            return pg_fetch_all($result) ?: [];
        }
        return [];
    }

    public function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function updateUserPassword(int $user_id, string $new_password): bool {
        $hashed_password = $this->hashPassword($new_password);
        $sql = "UPDATE users SET password = $1 WHERE id_user = $2";
        $result = pg_query_params($this->Database->getConnection(), $sql, [$hashed_password, $user_id]);
        return (bool)$result;
    }
}
?>