<?php

require_once 'config/database.php';

class Supplier {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect(); 
    }

    public function getTotalSupplier() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM supplier");
        $stmt->execute();
    }

    // Ambil semua supplier
    public function getAll() {
        $query = "SELECT * FROM supplier";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil supplier berdasarkan ID
    public function getById($id) {
        $query = "SELECT * FROM supplier WHERE id_supplier = $id";
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }

    // Tambah supplier baru
    public function create($nama, $kontak, $alamat) {
        $query = "INSERT INTO supplier (nama, kontak, alamat, created_at) VALUES ('$nama', '$kontak', '$alamat', NOW())";
        return $this->conn->query($query);
    }

    // Update supplier
    public function update($id, $nama, $kontak, $alamat) {
        $query = "UPDATE supplier SET nama = '$nama', kontak = '$kontak', alamat = '$alamat' WHERE id_supplier = $id";
        return $this->conn->query($query);
    }

    // Hapus supplier
    public function delete($id) {
        $query = "DELETE FROM supplier WHERE id_supplier = $id";
        return $this->conn->query($query);
    }
}

?>
