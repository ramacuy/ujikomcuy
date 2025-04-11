<?php
require_once 'models/Produk.php';

class ProdukController {
    private $produkModel;

    public function __construct($db) {
        $this->produkModel = new Produk();
    }

    public function index() {
        $produk = $this->produkModel->getAll();
        $kategori = $this->produkModel->getEnumKategori(); // enum dari DB
        include 'views/content/produk.php';
    }

    public function store($data) {
        if (isset($data['nama'], $data['kategori'], $data['stok'], $data['harga'])) {
            $this->produkModel->create($data['nama'], $data['kategori'], $data['stok'], $data['harga']);
        }
        header("Location: index.php?page=produk");
        exit();
    }

    public function update($id, $data) {
        if (isset($data['nama'], $data['kategori'], $data['stok'], $data['harga'])) {
            $this->produkModel->update($id, $data['nama'], $data['kategori'], $data['stok'], $data['harga']);
        }
        header("Location: index.php?page=produk");
        exit();
    }

    public function destroy($id) {
        $this->produkModel->delete($id);
        $_SESSION['message'] = 'Barang berhasil dihapus.';
        header("Location: index.php?page=produk");
        exit();
    }
}
