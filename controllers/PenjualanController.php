<?php
require_once 'config/database.php';
require_once 'models/Penjualan.php';

class PenjualanController {
    private $model;

    public function __construct() {
        $this->model = new Penjualan();
    }

    public function index() {
        $penjualan = $this->model->getAll();
        $pelangganList = $this->model->getPelangganList();
        $produkList = $this->model->getProdukList();

        include 'views/content/penjualan.php';
    }

    public function store($data = null) {
        $data = $data ?? $_POST;

        if (isset($data['PelangganID'], $data['tanggal_penjualan'], $data['ProdukID'], $data['JumlahProduk'], $data['Harga'])) {
            $produkList = [];

            foreach ($data['ProdukID'] as $i => $produkID) {
                $jumlah = (int) $data['JumlahProduk'][$i];
                $harga = (float) $data['Harga'][$i];

                // Validasi jumlah > 0
                if ($jumlah > 0 && $harga >= 0) {
                    $produkList[] = [
                        'ProdukID' => $produkID,
                        'JumlahProduk' => $jumlah,
                        'subtotal' => $jumlah * $harga
                    ];
                }
            }

            if (empty($produkList)) {
                $_SESSION['message'] = "Tidak ada produk yang valid ditambahkan.";
            } else {
                $success = $this->model->create($data['PelangganID'], $data['tanggal_penjualan'], $produkList);
                $_SESSION['message'] = $success ? "Penjualan berhasil ditambahkan" : ($_SESSION['message'] ?? "Gagal menambahkan penjualan");
            }
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
