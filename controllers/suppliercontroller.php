<?php

require_once '../config/database.php';
require_once '../models/Supplier.php';

class SupplierController {
    private $model;

    public function __construct($db) {
        $this->model = new Supplier($db);
    }

    // Ambil semua supplier
    public function index() {
        return $this->model->getAll();
    }

    // Ambil supplier berdasarkan ID
    public function show($id) {
        return $this->model->getById($id);
    }

    // Tambah supplier baru
    public function store($data) {
        if (isset($data['nama'], $data['kontak'], $data['alamat'])) {
            return $this->model->create($data['nama'], $data['kontak'], $data['alamat']);
        }
        return false;
    }

    // Update supplier
    public function update($id, $data) {
        if (isset($data['nama'], $data['kontak'], $data['alamat'])) {
            return $this->model->update($id, $data['nama'], $data['kontak'], $data['alamat']);
        }
        return false;
    }

    // Hapus supplier
    public function destroy($id) {
        return $this->model->delete($id);
    }
}
?>
