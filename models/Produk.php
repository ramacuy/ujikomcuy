<?php
require_once 'config/database.php';

class Produk {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect(); 
    }

    public function getAll() {
        $query = "SELECT * FROM produk";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM produk WHERE ProdukID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($nama, $kategori, $stok, $harga) {
        $query = "INSERT INTO produk (NamaProduk, KategoriProduk, Stok, Harga) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssii", $nama, $kategori, $stok, $harga);
        return $stmt->execute();
    }

    public function update($id, $nama, $kategori, $stok, $harga) {
        $query = "UPDATE produk SET NamaProduk = ?, KategoriProduk = ?, Stok = ?, Harga = ? WHERE ProdukID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssiii", $nama, $kategori, $stok, $harga, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM produk WHERE ProdukID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getEnumKategori() {
        $query = "SHOW COLUMNS FROM produk LIKE 'KategoriProduk'";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();

        preg_match("/^enum\((.*)\)$/", $row['Type'], $matches);
        $enum = explode(",", str_replace("'", "", $matches[1]));
        return $enum;
    }
}
