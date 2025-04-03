<?php

require_once 'config/database.php';
require_once 'models/Supplier.php';

class SupplierController {
    private $model;

    public function __construct($db) {
        $this->model = new Supplier($db);
    }

    public function index() {
        $supplier = $this->model->getAll();
        include 'views/content/supplier.php'; 
    }

    // Ambil supplier berdasarkan ID
    public function show($id) {
        return $this->model->getById($id);
    }

    // Tambah supplier baru
    public function store($data) {
        if (isset($data['nama'], $data['kontak'], $data['alamat'])) {
            $result = $this->model->create($data['nama'], $data['kontak'], $data['alamat']);
            header("Location: index.php?page=supplier&action=index");
            exit();
        }
        return false;
    }

    // Update supplier
    public function update($id, $data) {
        if (isset($data['nama'], $data['kontak'], $data['alamat'])) {
            $result = $this->model->update($id, $data['nama'], $data['kontak'], $data['alamat']);
            header("Location: index.php?page=supplier&action=index");
            exit(); 
        }
        return false;
    }

    // Hapus supplier
    public function destroy($id) {
        $result = $this->model->delete($id);
        header("Location: index.php?page=supplier&action=index");
        exit();
    }
}
?>
