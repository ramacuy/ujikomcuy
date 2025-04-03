<?php
class Database {
    private $host = "localhost";
    private $db_name = "sortiran";
    private $username = "root";
    private $password = "";
    private $conn;

    // Fungsi untuk melakukan koneksi ke database
    public function connect() {
        // Membuat koneksi
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

        // Mengecek apakah koneksi berhasil
        if ($this->conn->connect_error) {
            die("Koneksi gagal: " . $this->conn->connect_error);
        }

        return $this->conn; // Mengembalikan objek koneksi
    }

    // Fungsi untuk menutup koneksi
    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
