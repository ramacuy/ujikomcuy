<?php
include_once 'config/database.php';

class Penjualan {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect(); 
    }


    public function getAll() {
        $sql = "SELECT p.*, pl.NamaPelanggan 
                FROM penjualan p 
                JOIN pelanggan pl ON p.PelangganID = pl.PelangganID 
                ORDER BY p.TanggalPenjualan DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function find($id) {
        $stmt = $this->conn->prepare("SELECT * FROM penjualan WHERE PenjualanID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function detail($penjualanID) {
        $stmt = $this->conn->prepare("
            SELECT dp.*, pr.NamaProduk 
            FROM detail_penjualan dp 
            JOIN produk pr ON dp.ProdukID = pr.ProdukID 
            WHERE dp.PenjualanID = ?
        ");
        $stmt->bind_param("i", $penjualanID);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create($pelangganID, $tanggal, $produkList) {
        $this->conn->begin_transaction();

        try {
            $totalHarga = array_sum(array_column($produkList, 'subtotal'));

            $stmtPenjualan = $this->conn->prepare("
                INSERT INTO penjualan (TanggalPenjualan, TotalHarga, PelangganID) 
                VALUES (?, ?, ?)
            ");
            $stmtPenjualan->bind_param("sdi", $tanggal, $totalHarga, $pelangganID);
            $stmtPenjualan->execute();
            $penjualanID = $stmtPenjualan->insert_id;

            $stmtDetail = $this->conn->prepare("
                INSERT INTO detail_penjualan (PenjualanID, ProdukID, JumlahProduk, Harga) 
                VALUES (?, ?, ?, ?)
            ");

            $stmtStok = $this->conn->prepare("
                UPDATE produk SET Stok = Stok - ? WHERE ProdukID = ?
            ");

            foreach ($produkList as $p) {
                $produkID = $p['ProdukID'];
                $jumlah = $p['JumlahProduk'];
                $harga = $p['subtotal'] / $jumlah;

                // Tambah ke detail_penjualan
                $stmtDetail->bind_param("iiid", $penjualanID, $produkID, $jumlah, $harga);
                $stmtDetail->execute();

                // Update stok produk
                $stmtStok->bind_param("ii", $jumlah, $produkID);
                $stmtStok->execute();
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            return false;
        }
    }

    public function getPelangganList() {
        $result = $this->conn->query("SELECT * FROM pelanggan");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProdukList() {
        $result = $this->conn->query("SELECT * FROM produk");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
