<?php
declare(strict_types=1);

class DatabaseManager {
    // Tipado de propiedad
    private Database $Database;

    // Inyección de dependencia estricta
    public function __construct(Database $Database) {
        $this->Database = $Database;
    }

    // Retorna un array de usuarios (vacío si no hay resultados)
    public function getUsers(): array {
        $result = pg_query($this->Database->getConnection(), "SELECT * FROM users");
        $data = pg_fetch_all($result);
        return $data ?: []; 
    }

    // Parámetro opcional entero, retorna siempre un array
    public function getUserByIdOrgetUsers(?int $id = null): array {
        if ($id === null) {
            return $this->getUsers();
        }
        
        $result = pg_query_params($this->Database->getConnection(), "SELECT * FROM users WHERE id_user = $1", [$id]);
        $data = pg_fetch_assoc($result);
        
        return $data ?: [];
    }

    // Parámetro string, retorna entero o null si no lo encuentra
    public function getIdByUsername(string $username): ?int {
        $result = pg_query_params($this->Database->getConnection(), "SELECT id_user FROM users WHERE username = $1", [$username]);
        
        if ($result && pg_num_rows($result) > 0) {
            $data = pg_fetch_assoc($result);
            return (int)$data['id_user'];
        }
        
        return null;
    }

    // Parámetro entero, retorna booleano indicando el éxito de la operación
    public function deleteUser(int $id): bool {
        $result = pg_query_params($this->Database->getConnection(), "DELETE FROM users WHERE id_user = $1", [$id]);
        return (bool)$result;
    }

    // Parámetros estrictos, retorna booleano
    public function updateUser(int $id, string $username, string $email, string $name, string $last_name): bool {
        $sql = "UPDATE users SET username = $1, email = $2, name = $3, last_name = $4 WHERE id_user = $5";
        $result = pg_query_params($this->Database->getConnection(), $sql, [$username, $email, $name, $last_name, $id]);
        return (bool)$result;
    }

    // Parámetros estrictos, retorna booleano
    public function updateUsername(int $id, string $username): bool {
        $sql = "UPDATE users SET username = $1 WHERE id_user = $2";
        $result = pg_query_params($this->Database->getConnection(), $sql, [$username, $id]);
        return (bool)$result;
    }

    // Parámetros estrictos, retorna booleano
    public function updateEmail(int $id, string $email): bool {
        $sql = "UPDATE users SET email = $1 WHERE id_user = $2";
        $result = pg_query_params($this->Database->getConnection(), $sql, [$email, $id]);
        return (bool)$result;
    }
}
?>