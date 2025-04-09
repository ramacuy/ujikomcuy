<?php

require_once 'config/database.php';
require_once 'models/Barang.php';

class BarangController {
    private $barangModel;

    public function __construct() {
        $this->barangModel = new Barang();
    }

    public function getAllBarang() {
        return $this->barangModel->getAll(); // getAll() ini method di model Barang
    }
    
    // Ambil semua barang
    public function index() {
        $barang = $this->barangModel->getAll();
        $supplier = $this->barangModel->getAllSupplier();
        include 'views/content/barang.php';
    }

    // Ambil barang berdasarkan ID
    public function show($id) {
        return $this->barangModel->getById($id);
    }

    // Tambah barang baru
    public function store($data) {
        if (isset($data['nama'], $data['kategori'], $data['stok'], $data['supplier_id'])) {
            $this->barangModel->create($data['nama'], $data['kategori'], $data['stok'], $data['supplier_id']);
        }
        header("Location: index.php?page=barang");
        exit();
    }

    // Update barang
    public function update($id, $data) {
        if (isset($data['nama'], $data['kategori'], $data['stok'], $data['supplier_id'])) {
            $this->barangModel->update($id, $data['nama'], $data['kategori'], $data['stok'], $data['supplier_id']);
        }
        header("Location: index.php?page=barang");
        exit();
    }

    // Hapus barang
    public function destroy($id) {
        $this->barangModel->delete($id);
        header("Location: index.php?page=barang");
        exit();
    }
}

?>
