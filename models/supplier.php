<?php
require_once 'config/database.php';

class Supplier {
    private $conn;

    public function __construct() {
        $conn = new Database();
        $this->conn = $conn->getConnection();
    }

    public function getAllSuppliers() {
        $query = "SELECT * FROM supplier";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSupplierById($id) {
        $query = "SELECT * FROM supplier WHERE supplier_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function tambah($data) {
        $nama_supplier = $this->conn->real_escape_string($data['nama_supplier']);
        $kontak = $this->conn->real_escape_string($data['kontak']);
        $telepon = $this->conn->real_escape_string($data['telepon']);
        $email = $this->conn->real_escape_string($data['email']);
        $alamat = $this->conn->real_escape_string($data['alamat']);

        $query = "INSERT INTO supplier (nama_supplier, kontak, telepon, email, alamat) 
                  VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $nama_supplier, $kontak, $telepon, $email, $alamat);
        
        return $stmt->execute();
    }

    public function update($data) {
        $query = "UPDATE supplier SET 
                  nama_supplier = ?, kontak = ?, telepon = ?, email = ?, alamat = ?
                  WHERE supplier_id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssi", $data['nama_supplier'], $data['kontak'], $data['telepon'], 
                          $data['email'], $data['alamat'], $data['supplier_id']);
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM supplier WHERE supplier_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
}
