<?php
require_once 'models/Produk.php';
require_once 'models/DetailPenjualan.php';
require_once 'models/Pelanggan.php';

class HomeController {
    private $produkModel;
    private $penjualanModel;
    private $pelangganModel;

    public function __construct($db) {
        $this->produkModel = new Produk($db);
        $this->penjualanModel = new Penjualan($db);
        $this->pelangganModel = new Pelanggan($db);
    }

    public function index() {
        $dataProduk = $this->produkModel->getAll();
        $jumlahProduk = count($dataProduk);

        $dataPenjualan = $this->penjualanModel->getAll();
        $jumlahPenjualan = count($dataPenjualan);

        $dataPelanggan = $this->pelangganModel->getAll();
        $jumlahPelanggan = count($dataPelanggan);

        // Kirim data ke view
        include 'views/content/home.php';
    }
}
