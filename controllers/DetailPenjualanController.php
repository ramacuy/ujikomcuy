<?php
require_once 'models/DetailPenjualan.php';

class DetailPenjualanController {
    private $distribusimodel;

    public function __construct() {
        $this->distribusimodel = new DetailPenjualan();
    }

    public function index() {
        $details = $this->distribusimodel->getAll();
        include 'views/content/detail_penjualan.php';
    }
}
?>
