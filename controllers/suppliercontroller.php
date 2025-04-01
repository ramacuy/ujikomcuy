<?php
require_once "models/Supplier.php";

class SupplierController {
    private $supplierModel;

    public function __construct() { 
        $this->supplierModel = new supplier();
    }

    public function getBarangModel() {
        return $this->supplierModel;
    }

    // Display the supplier page
    public function index() {
        $suppliers = $this->supplierModel->getAllSupplier();
        include "views/supplier/index.php";
    }

    // Process add supplier
    public function store() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Retrieve POST data and sanitize input
            $nama = $_POST['nama_supplier'] ?? '';
            $kontak = $_POST['kontak'] ?? '';
            $telepon = $_POST['nomor'] ?? '';
            $email = $_POST['email'] ?? '';
            $alamat = $_POST['alamat'] ?? '';

            // Validate input (simple validation as an example)
            if (empty($nama) || empty($kontak) || empty($telepon) || empty($email) || empty($alamat)) {
                header("Location: index.php?page=supplier&status=error&message=All fields are required.");
                exit();
            }

            // Attempt to add supplier
            if ($this->model->addSupplier($nama, $kontak, $telepon, $email, $alamat)) {
                header("Location: index.php?page=supplier&status=success");
                exit();
            } else {
                header("Location: index.php?page=supplier&status=error&message=Failed to add supplier.");
                exit();
            }
        }
    }

    // Process update supplier
    public function update() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Retrieve POST data and sanitize input
            $id = $_POST['id'] ?? '';
            $nama = $_POST['nama_supplier'] ?? '';
            $kontak = $_POST['kontak'] ?? '';
            $telepon = $_POST['nomor'] ?? '';
            $email = $_POST['email'] ?? '';
            $alamat = $_POST['alamat'] ?? '';

            // Validate input (simple validation as an example)
            if (empty($id) || empty($nama) || empty($kontak) || empty($telepon) || empty($email) || empty($alamat)) {
                header("Location: index.php?page=supplier&status=error&message=All fields are required.");
                exit();
            }

            // Attempt to update supplier
            if ($this->model->updateSupplier($id, $nama, $kontak, $telepon, $email, $alamat)) {
                header("Location: index.php?page=supplier&status=updated");
                exit();
            } else {
                header("Location: index.php?page=supplier&status=error&message=Failed to update supplier.");
                exit();
            }
        }
    }

    // Process delete supplier
    public function delete() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['supplier_id'])) {
            // Attempt to delete supplier
            if ($this->model->deleteSupplier($_POST['supplier_id'])) {
                header("Location: index.php?page=supplier&status=deleted");
                exit();
            } else {
                header("Location: index.php?page=supplier&status=error&message=Failed to delete supplier.");
                exit();
            }
        }
    }
}
?>
