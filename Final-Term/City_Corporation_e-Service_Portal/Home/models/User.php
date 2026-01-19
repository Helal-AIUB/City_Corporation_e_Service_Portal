<?php
class Users {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function register($name, $email, $role, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, role, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $email, $role, $hashedPassword]);
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Add inside class Users in Home/models/User.php

public function saveResetToken($email, $token_hash, $expiry) {
    $sql = "UPDATE users SET reset_token_hash = :token_hash, reset_token_expires_at = :expiry WHERE email = :email";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute(['token_hash' => $token_hash, 'expiry' => $expiry, 'email' => $email]);
}

public function getUserByToken($token_hash) {
    $sql = "SELECT * FROM users WHERE reset_token_hash = :token_hash";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['token_hash' => $token_hash]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updatePassword($id, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Update password and clear the token
    $sql = "UPDATE users SET password = :password, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute(['password' => $hashed_password, 'id' => $id]);
}

}
?>