<?php
class Domain {
    private Connection $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function getDomainsByUser(int $userId) {
    }
}