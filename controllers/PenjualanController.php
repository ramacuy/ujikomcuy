<?php

require_once 'config/database.php';
require_once 'models/Penjualan.php';

class PenjualanController {
    private $model;

    public function __construct() {
        $this->model = new Penjualan();
    }

    public function index() {
        $penjualan = $this->model->all();
        $pelangganList = $this->model->getPelangganList();
        $produkList = $this->model->getProdukList();

        include 'views/content/penjualan.php';
    }

    public function create() {
        if (isset($_POST['PelangganID'], $_POST['tanggal_penjualan'], $_POST['ProdukID'], $_POST['JumlahProduk'], $_POST['Harga'])) {
            $produkList = [];

            foreach ($_POST['ProdukID'] as $i => $produkID) {
                $jumlah = (int) $_POST['JumlahProduk'][$i];
                $harga = (float) $_POST['Harga'][$i];
                $produkList[] = [
                    'ProdukID' => $produkID,
                    'JumlahProduk' => $jumlah,
                    'subtotal' => $jumlah * $harga
                ];
            }

            $success = $this->model->create($_POST['PelangganID'], $_POST['tanggal_penjualan'], $produkList);

            $_SESSION['message'] = $success ? "Penjualan berhasil ditambahkan" : "Gagal menambahkan penjualan";
        } else {
            $_SESSION['message'] = "Data tidak lengkap";
        }

        header("Location: index.php?page=penjualan");
        exit;
    }

    public function detail() {
        if (!isset($_GET['id'])) {
            echo "ID tidak ditemukan";
            return;
        }

        $penjualan = $this->model->find($_GET['id']);
        $detail = $this->model->detail($_GET['id']);

        include 'views/content/detailpenjualan.php';
    }
}
