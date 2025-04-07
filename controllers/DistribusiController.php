<?php

require_once 'config/database.php';
require_once 'models/Distribusi.php';

class DistribusiController {
    private $model;

    public function __construct($db) {
        $this->model = new Distribusi($db);
    }

    // Ambil semua distribusi
    public function index() {
        return $this->model->getAll();
    }

    // Ambil distribusi berdasarkan ID
    public function show($id) {
        return $this->model->getById($id);
    }

    // Tambah distribusi baru
    public function store($data) {
        if (isset($data['barang_id'], $data['jumlah'], $data['tujuan'], $data['tanggal_distribusi'])) {
            return $this->model->create($data['barang_id'], $data['jumlah'], $data['tujuan'], $data['tanggal_distribusi']);
        }
        return ["error" => "Data tidak lengkap"];
    }

    // Update distribusi
    public function update($id, $data) {
        if (isset($data['barang_id'], $data['jumlah'], $data['tujuan'], $data['tanggal_distribusi'])) {
            return $this->model->update($id, $data['barang_id'], $data['jumlah'], $data['tujuan'], $data['tanggal_distribusi']);
        }
        return ["error" => "Data tidak lengkap"];
    }

    // Hapus distribusi
    public function destroy($id) {
        return $this->model->delete($id);
    }
}

?>
