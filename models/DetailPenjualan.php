<?php
require_once 'config/database.php';

class DetailPenjualan {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->Connect();
    }

    public function getAll() {
        $query = "SELECT dp.DetailID, dp.PenjualanID, dp.ProdukID, p.NamaProduk, dp.JumlahProduk, dp.SubTotal
                  FROM detailpenjualan dp
                  JOIN produk p ON dp.ProdukID = p.ProdukID";

        $result = $this->conn->query($query);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
?>
