<?php

require_once 'config/database.php';

class User {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect(); // koneksi mysqli
    }

    public function login($username, $password) {
        $username = mysqli_real_escape_string($this->conn, $username);
        $password = md5($password); // hash password pakai md5

        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result); // login berhasil
        }

        return false; // login gagal
    }
}
