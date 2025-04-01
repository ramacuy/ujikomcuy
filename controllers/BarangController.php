<?php
class Supplier {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    // Ambil semua supplier
    public function getAllSupplier() {
        $stmt = $this->db->query("SELECT * FROM supplier ORDER BY supplier_id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Tambah supplier
    public function addSupplier($nama, $kontak, $telepon, $email, $alamat) {
        $stmt = $this->db->prepare("
            INSERT INTO supplier (nama_supplier, kontak, telepon, email, alamat) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$nama, $kontak, $telepon, $email, $alamat]);
    }

    // Edit supplier
    public function updateSupplier($id, $nama, $kontak, $telepon, $email, $alamat) {
        $stmt = $this->db->prepare("
            UPDATE supplier 
            SET nama_supplier=?, kontak=?, telepon=?, email=?, alamat=? 
            WHERE supplier_id=?
        ");
        return $stmt->execute([$nama, $kontak, $telepon, $email, $alamat, $id]);
    }

    // Hapus supplier
    public function deleteSupplier($id) {
        $stmt = $this->db->prepare("DELETE FROM supplier WHERE supplier_id=?");
        return $stmt->execute([$id]);
    }
}
?>
