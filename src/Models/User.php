<?php

class User extends DatabaseManager {

    public function getByUsername(string $username): ?array {
        $sql = "SELECT * FROM users WHERE username = $1";
        return $this->querySingle($sql, [$username]);
    }

    public function getByEmail(string $email): ?array {
        $sql = "SELECT * FROM users WHERE email = $1";
        return $this->querySingle($sql, [$email]);
    }

    public function create(string $username, string $email, string $password, string $name, string $lastName, string $secondLastName = ''): bool {
        $sql = "INSERT INTO users (username, email, password, name, last_name, second_last_name) 
                VALUES ($1, $2, $3, $4, $5, $6)";
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        return $this->execute($sql, [$username, $email, $hashedPassword, $name, $lastName, $secondLastName]);
    }

    public function verifyCredentials(string $login, string $password): ?array {
        $user = $this->getByUsername($login) ?: $this->getByEmail($login);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user; 
        }
        return null; 
    }
}