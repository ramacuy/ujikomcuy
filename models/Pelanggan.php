<?php

require_once 'config/database.php';

class Pelanggan {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect(); 
    }

    public function getAll() {
        $query = "SELECT * FROM pelanggan";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $id = (int)$id;
        $query = "SELECT * FROM pelanggan WHERE PelangganID = $id";
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }

    public function create($nama, $alamat, $kontak) {
        $nama = $this->conn->real_escape_string($nama);
        $alamat = $this->conn->real_escape_string($alamat);
        $kontak = $this->conn->real_escape_string($kontak);

        $query = "INSERT INTO pelanggan (NamaPelanggan, Alamat, NomorTelepon) 
                  VALUES ('$nama', '$alamat', '$kontak')";
        return $this->conn->query($query);
    }

    public function update($id, $nama, $alamat, $kontak) {
        $id = (int)$id;
        $nama = $this->conn->real_escape_string($nama);
        $alamat = $this->conn->real_escape_string($alamat);
        $kontak = $this->conn->real_escape_string($kontak);

        $query = "UPDATE pelanggan 
                  SET NamaPelanggan = '$nama', Alamat = '$alamat', NomorTelepon = '$kontak' 
                  WHERE PelangganID = $id";
        return $this->conn->query($query);
    }

    public function delete($id) {
        $id = (int)$id;
        $query = "DELETE FROM pelanggan WHERE PelangganID = $id";
        return $this->conn->query($query);
    }
}
