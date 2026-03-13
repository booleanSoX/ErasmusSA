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
        // Normalización estructural: Forzamos a que sea un array de listas aunque haya 1 solo resultado
        return $data ? [$data] : [];
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

    public function checkUserExists(string $email, string $username): bool {
        return (bool)($this->getUserByUsername($username) || $this->getUserByEmail($email));
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
        return (bool)$result;
    }

    public function getUserDomains(int $user_id): array {
        $sql = "SELECT domain_name, domain_state, registration_date, expiration_date 
                FROM domains 
                WHERE id_user = $1 
                ORDER BY domain_name ASC";
        $result = pg_query_params($this->Database->getConnection(), $sql, [$user_id]);
        return pg_fetch_all($result) ?: [];
    }

    public function getUserEmailsPerDomain(int $user_id): array {
        $sql = "SELECT e.email_address, e.current_size, e.id_domain, e.quota_limit AS size 
                FROM emails e 
                JOIN domains d ON e.id_domain = d.id_domain 
                WHERE d.id_user = $1 
                ORDER BY e.email_address ASC";
        $result = pg_query_params($this->Database->getConnection(), $sql, [$user_id]);
        return pg_fetch_all($result) ?: [];
    }

    public function getUserFiles(int $user_id): array {
        $sql = "SELECT id_file, file_name, extension, mime_type, file_size 
                FROM files 
                WHERE id_user = $1 
                ORDER BY file_name ASC";
        $result = pg_query_params($this->Database->getConnection(), $sql, [$user_id]);
        return pg_fetch_all($result) ?: [];
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