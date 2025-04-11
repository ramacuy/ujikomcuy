<?php

require_once 'config/database.php';
require_once 'models/Pelanggan.php';

class PelangganController {
    private $model;

    public function __construct($db) {
        $this->model = new Pelanggan($db);
    }

    public function index() {
        $pelanggan = $this->model->getAll();
        include 'views/content/pelanggan.php'; 
    }

    // Ambil supplier berdasarkan ID
    public function show($id) {
        return $this->model->getById($id);
    }

    // Tambah supplier baru
    public function store($data) {
        if (isset($data['nama'], $data['alamat'], $data['nomortelepon'])) {
            $result = $this->model->create($data['nama'], $data['alamat'], $data['nomortelepon']);
            header("Location: index.php?page=pelanggan&action=index");
            exit();
        }
        return false;
    }

    // Update supplier
    public function update($id, $data) {
        if (isset($data['nama'], $data['alamat'], $data['nomortelepon'])) {
            $result = $this->model->update($id, $data['nama'], $data['alamat'], $data['nomortelepon']);
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
