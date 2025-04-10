<?php

require_once 'config/database.php';

class Barang {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect(); 
    }
    
    public function getAllBarang() {
        $query = "SELECT * FROM barang";
        $result = $this->conn->query($query);
        
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    // Ambil semua barang
    public function getAll() {
        $query = "SELECT b.id_barang, b.nama, b.kategori, b.stok, b.harga, s.nama AS supplier 
                  FROM barang b 
                  JOIN supplier s ON b.supplier_id = s.id_supplier";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil barang berdasarkan ID
    public function getById($id) {
        $query = "SELECT * FROM barang WHERE id_barang = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getAllSupplier() {
        $query = "SELECT id_supplier, nama FROM supplier";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Validasi supplier_id sebelum menambahkan barang
    private function supplierExists($supplier_id) {
        $query = "SELECT id_supplier FROM supplier WHERE id_supplier = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $supplier_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    // Tambah barang baru (harus memiliki supplier_id yang valid)
    public function create($nama, $kategori, $stok, $supplier_id, $harga) {
        if (!$this->supplierExists($supplier_id)) {
            return ["error" => "Supplier tidak ditemukan"];
        }

        $query = "INSERT INTO barang (nama, kategori, stok, supplier_id, harga, create_at) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssiis", $nama, $kategori, $stok, $supplier_id, $harga);
        
        if ($stmt->execute()) {
            return ["success" => "Barang berhasil ditambahkan"];
        } else {
            return ["error" => "Gagal menambahkan barang"];
        }
    }

    // Update barang
    public function update($id, $nama, $kategori, $stok, $supplier_id, $harga) {
        if (!$this->supplierExists($supplier_id)) {
            return ["error" => "Supplier tidak ditemukan"];
        }

        $query = "UPDATE barang SET nama = ?, kategori = ?, stok = ?, supplier_id = ?, harga = ?, WHERE id_barang = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssiisi", $nama, $kategori, $stok, $supplier_id, $harga, $id);
        
        if ($stmt->execute()) {
            return ["success" => "Barang berhasil diperbarui"];
        } else {
            return ["error" => "Gagal memperbarui barang"];
        }
    }

    // Hapus barang
    public function delete($id) {
        $query = "DELETE FROM barang WHERE id_barang = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return ["success" => "Barang berhasil dihapus"];
        } else {
            return ["error" => "Gagal menghapus barang"];
        }
    }
}

?>
