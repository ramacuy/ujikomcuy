<?php
require_once 'models/Barang.php';
require_once 'models/Distribusi.php';
require_once 'models/Supplier.php';

class HomeController {
    private $barangModel;
    private $detaildistribusiModel;
    private $supplierModel;

    public function __construct($db) {
        $this->barangModel = new Barang($db);
        $this->detaildistribusiModel = new DetailDistribusi($db);
        $this->supplierModel = new Supplier($db);
    }

    public function index() {
        $dataBarang = $this->barangModel->getAll();
        $jumlahBarang = count($dataBarang);

        $distribusiBarang = $this->detaildistribusiModel->getAll();
        $jumlahDetailDistribusi = count($distribusiBarang);

        $dataSupplier = $this->supplierModel->getAll();
        $jumlahSupplier = count($dataSupplier);

        // variabel ini akan tersedia di view
        include 'views/content/home.php';
    }
}
