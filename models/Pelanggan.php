<?php

require_once 'config/database.php';

class Pelanggan {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect(); 
    }

    // Ambil semua supplier
    public function getAll() {
        $query = "SELECT * FROM pelanggan";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil supplier berdasarkan ID
    public function getById($id) {
        $query = "SELECT * FROM pelanggan WHERE PelangganID = $id";
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }

    // Tambah supplier baru
    public function create($nama, $kontak, $alamat) {
        $query = "INSERT INTO pelanggan (NamaPelanggan, Alamat, NomorTelepon) VALUES ('$nama', '$kontak', '$alamat')";
        return $this->conn->query($query);
    }

    // Update supplier
    public function update($id, $nama, $kontak, $alamat) {
        $query = "UPDATE pelanggan SET NamaPelanggan = '$nama', Alamat = '$nomortelepon', NomorTelepon = '$alamat' WHERE PelangganID = $id";
        return $this->conn->query($query);
    }

    // Hapus supplier
    public function delete($id) {
        $query = "DELETE FROM pelanggan WHERE PelangganID = $id";
        return $this->conn->query($query);
    }
}

?>
