<?php
require_once 'config/database.php';

class User {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function login($username, $password) {
        $password = md5($password); // Gunakan MD5 sesuai struktur awal

        // ✅ Pastikan nama tabel adalah `user`, bukan `users`
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        return ($result->num_rows > 0) ? $result->fetch_assoc() : false;
    }
}
