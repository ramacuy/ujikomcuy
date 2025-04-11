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
            $totalHarga = floatval(array_sum(array_column($produkList, 'subtotal')));
    
            // Insert ke tabel penjualan
            $stmtPenjualan = $this->conn->prepare("
                INSERT INTO penjualan (TanggalPenjualan, TotalHarga, PelangganID) 
                VALUES (?, ?, ?)
            ");
            $stmtPenjualan->bind_param("sdi", $tanggal, $totalHarga, $pelangganID);
            if (!$stmtPenjualan->execute()) {
                throw new Exception("Gagal insert penjualan: " . $stmtPenjualan->error);
            }
            $penjualanID = $stmtPenjualan->insert_id;
    
            $stmtDetail = $this->conn->prepare("
                INSERT INTO detailpenjualan (PenjualanID, ProdukID, JumlahProduk, SubTotal) 
                VALUES (?, ?, ?, ?)
            ");
            $stmtStok = $this->conn->prepare("
                UPDATE produk SET Stok = Stok - ? WHERE ProdukID = ?
            ");
    
            foreach ($produkList as $p) {
                $produkID = $p['ProdukID'];
                $jumlah = (int) $p['JumlahProduk'];
                if ($jumlah <= 0) throw new Exception("Jumlah produk harus lebih dari 0 untuk produk ID $produkID");
    
                $hargaSatuan = $p['subtotal'] / $jumlah;
                $stokSekarang = $this->getStokProduk($produkID);
                if ($jumlah > $stokSekarang) {
                    throw new Exception("Stok tidak cukup untuk produk ID $produkID");
                }
    
                $stmtDetail->bind_param("iiid", $penjualanID, $produkID, $jumlah, $hargaSatuan);
                if (!$stmtDetail->execute()) {
                    throw new Exception("Gagal insert detail: " . $stmtDetail->error);
                }
    
                $stmtStok->bind_param("ii", $jumlah, $produkID);
                if (!$stmtStok->execute()) {
                    throw new Exception("Gagal update stok: " . $stmtStok->error);
                }
            }
    
            $this->conn->commit();
            return true;
    
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Penjualan error: " . $e->getMessage());
            $_SESSION['message'] = "Gagal menambahkan penjualan: " . $e->getMessage();
            return false;
        }
    }
    
    private function getStokProduk($id) {
        $stmt = $this->conn->prepare("SELECT Stok FROM produk WHERE ProdukID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? (int)$result['Stok'] : 0;
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
