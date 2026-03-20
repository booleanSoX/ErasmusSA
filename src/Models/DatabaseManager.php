<?php

class DatabaseManager {
    protected Connection $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    protected function querySingle(string $sql, array $params = []): ?array {
        $result = pg_query_params($this->db->getConnection(), $sql, $params);
        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        }
        return null;
    }

    protected function queryAll(string $sql, array $params = []): array {
        $result = pg_query_params($this->db->getConnection(), $sql, $params);
        if ($result) {
            return pg_fetch_all($result) ?: [];
        }
        return [];
    }

    protected function execute(string $sql, array $params = []): bool {
        $result = pg_query_params($this->db->getConnection(), $sql, $params);
        return (bool)$result;
    }
}