<?php

require_once 'models/Pelanggan.php';

class PelangganController {
    private $model;

    public function __construct() {
        $this->model = new Pelanggan();
    }

    public function index() {
        $pelanggan = $this->model->getAll();
        include 'views/content/pelanggan.php'; 
    }

    public function show($id) {
        return $this->model->getById($id);
    }

    public function store($data) {
        if (isset($data['nama'], $data['alamat'], $data['nomortelepon'])) {
            $this->model->create($data['nama'], $data['alamat'], $data['nomortelepon']);
        }
        header("Location: index.php?page=pelanggan&action=index");
        exit();
    }

    public function update($id, $data) {
        if (isset($data['nama'], $data['alamat'], $data['nomortelepon'])) {
            $this->model->update($id, $data['nama'], $data['alamat'], $data['nomortelepon']);
        }
        header("Location: index.php?page=pelanggan&action=index");
        exit();
    }

    public function destroy($id) {
        $this->model->delete($id);
        header("Location: index.php?page=pelanggan&action=index");
        exit();
    }
}
