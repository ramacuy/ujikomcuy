<?php

require_once 'config/database.php';

class Distribusi {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect(); 
    }
    
    // Ambil semua data distribusi + relasi barang
    public function getAll() {
        $query = "SELECT d.id_distribusi, d.barang_id, b.nama AS nama_barang, d.jumlah, d.tujuan, d.tanggal_distribusi 
                  FROM distribusi d
                  JOIN barang b ON d.barang_id = b.id_barang";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Ambil distribusi berdasarkan ID
    public function getById($id) {
        $query = "SELECT * FROM distribusi WHERE id_distribusi = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Validasi barang_id sebelum input
    private function barangExists($barang_id) {
        $query = "SELECT id_barang FROM barang WHERE id_barang = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $barang_id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    // Tambah data distribusi baru
    public function create($barang_id, $jumlah, $tujuan, $tanggal_distribusi) {
        if (!$this->barangExists($barang_id)) {
            return ["error" => "Barang tidak ditemukan"];
        }
    
        // Ambil stok barang dulu
        $stokQuery = "SELECT stok FROM barang WHERE id_barang = ?";
        $stokStmt = $this->conn->prepare($stokQuery);
        $stokStmt->bind_param("i", $barang_id);
        $stokStmt->execute();
        $stokResult = $stokStmt->get_result();
        $barang = $stokResult->fetch_assoc();
    
        if (!$barang) {
            return ["error" => "Barang tidak ditemukan saat cek stok"];
        }
    
        if ($barang['stok'] < $jumlah) {
            return ["error" => "Stok tidak mencukupi"];
        }
    
        // Simpan distribusi
        $query = "INSERT INTO distribusi (barang_id, jumlah, tujuan, tanggal_distribusi) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiss", $barang_id, $jumlah, $tujuan, $tanggal_distribusi);
        
        if ($stmt->execute()) {
            // Kurangi stok barang
            $updateStokQuery = "UPDATE barang SET stok = stok - ? WHERE id_barang = ?";
            $updateStokStmt = $this->conn->prepare($updateStokQuery);
            $updateStokStmt->bind_param("ii", $jumlah, $barang_id);
            $updateStokStmt->execute();
    
            return ["success" => "Distribusi berhasil ditambahkan dan stok berkurang"];
        } else {
            return ["error" => "Gagal menambahkan distribusi"];
        }
    }

    public function konfirmasi($id_distribusi) {
        // Ambil data distribusi
        $query = "SELECT d.*, b.harga FROM distribusi d 
                  JOIN barang b ON d.barang_id = b.id_barang 
                  WHERE d.id_distribusi = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_distribusi);
        $stmt->execute();
        $result = $stmt->get_result();
        $distribusi = $result->fetch_assoc();
    
        if (!$distribusi) {
            return ["error" => "Distribusi tidak ditemukan"];
        }
    
        // Insert ke detail_distribusi
        $insert = "INSERT INTO detail_distribusi (distribusi_id, barang_id, jumlah, harga, tujuan, tanggal_distribusi, keterangan) 
           VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = $this->conn->prepare($insert);
        $keterangan = "Berhasil Terkirim";
        $stmtInsert->bind_param(
            "iiidsss", 
        $distribusi['id_distribusi'],
        $distribusi['barang_id'],
        $distribusi['jumlah'],
        $distribusi['harga'],
        $distribusi['tujuan'],
        $distribusi['tanggal_distribusi'],
        $keterangan
    );

    
        if ($stmtInsert->execute()) {
            // Setelah berhasil insert ke detail_distribusi, hapus dari distribusi
            $delete = "DELETE FROM distribusi WHERE id_distribusi = ?";
            $stmtDelete = $this->conn->prepare($delete);
            $stmtDelete->bind_param("i", $id_distribusi);
            $stmtDelete->execute();
    
            return ["success" => "Distribusi berhasil dikonfirmasi, dipindah, dan dihapus"];
        } else {
            return ["error" => "Gagal menyimpan ke detail distribusi: " . $stmtInsert->error];
        }
    }        
    
    // Hapus distribusi
    public function delete($id) {
        // Ambil data distribusi dulu (untuk tahu barang_id dan jumlah)
        $getQuery = "SELECT barang_id, jumlah FROM distribusi WHERE id_distribusi = ?";
        $getStmt = $this->conn->prepare($getQuery);
        $getStmt->bind_param("i", $id);
        $getStmt->execute();
        $result = $getStmt->get_result();
        $distribusi = $result->fetch_assoc();
    
        if (!$distribusi) {
            return ["error" => "Data distribusi tidak ditemukan"];
        }
    
        $barang_id = $distribusi['barang_id'];
        $jumlah = $distribusi['jumlah'];
    
        // Hapus distribusi
        $deleteQuery = "DELETE FROM distribusi WHERE id_distribusi = ?";
        $deleteStmt = $this->conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $id);
    
        if ($deleteStmt->execute()) {
            // Kembalikan stok barang
            $updateStokQuery = "UPDATE barang SET stok = stok + ? WHERE id_barang = ?";
            $updateStokStmt = $this->conn->prepare($updateStokQuery);
            $updateStokStmt->bind_param("ii", $jumlah, $barang_id);
            $updateStokStmt->execute();
    
            return ["success" => "Distribusi berhasil dihapus dan stok barang dikembalikan"];
        } else {
            return ["error" => "Gagal menghapus distribusi"];
        }
    }
}

?>