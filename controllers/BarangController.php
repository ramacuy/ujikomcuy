<?php

require_once '../config/database.php';
require_once '../models/Barang.php';

class BarangController {
    private $model;

    public function __construct($db) {
        $this->model = new Barang($db);
    }

    // Ambil semua barang
    public function index() {
        return $this->model->getAll();
    }

    // Ambil barang berdasarkan ID
    public function show($id) {
        return $this->model->getById($id);
    }

    // Tambah barang baru
    public function store($data) {
        if (isset($data['nama'], $data['kategori'], $data['stok'], $data['supplier_id'])) {
            return $this->model->create($data['nama'], $data['kategori'], $data['stok'], $data['supplier_id']);
        }
        return ["error" => "Data tidak lengkap"];
    }

    // Update barang
    public function update($id, $data) {
        if (isset($data['nama'], $data['kategori'], $data['stok'], $data['supplier_id'])) {
            return $this->model->update($id, $data['nama'], $data['kategori'], $data['stok'], $data['supplier_id']);
        }
        return ["error" => "Data tidak lengkap"];
    }

    // Hapus barang
    public function destroy($id) {
        return $this->model->delete($id);
    }
}

?>
