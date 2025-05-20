<?php
namespace App\Models;

use PDO;

require_once __DIR__ . "/Conexion.php";

class Usuario extends Conexion {

    public function registrar($username, $email, $password){
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->conn->prepare($sql);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hash]);
    }

    public function login($email, $password){
        // Fetch user by email
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // No such user
            return false;
        }

        // 1) Check bcrypt hash
        if (password_verify($password, $user['password'])) {
            // Regenerate session ID for security
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_regenerate_id(true);
            }
            return $user;
        }

        // 2) Optional: check legacy MD5 hash and rehash to bcrypt
        if (md5($password) === $user['password']) {
            // Rehash password with bcrypt
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $upd = $this->conn->prepare("UPDATE users SET password = :p WHERE id = :id");
            $upd->execute(['p' => $newHash, 'id' => $user['id']]);

            if (session_status() === PHP_SESSION_ACTIVE) {
                session_regenerate_id(true);
            }
            return $user;
        }

        // Invalid credentials
        return false;
    }
}
