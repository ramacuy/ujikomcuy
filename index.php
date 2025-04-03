<?php

require_once 'views/layouts/header.php';
require_once 'views/layouts/sidebar.php';

require_once 'controllers/SupplierController.php';
require_once 'controllers/BarangController.php';

$db = new Database();

$controllers = [
    'supplier' => new SupplierController($db),
    'barang' => new BarangController($db),
];

$page = htmlspecialchars($_GET['page'] ?? 'supplier', ENT_QUOTES, 'UTF-8');
$action = htmlspecialchars($_GET['action'] ?? 'index', ENT_QUOTES, 'UTF-8');

$allowedActions = ['index', 'show', 'store', 'update', 'destroy'];

try {
    if (array_key_exists($page, $controllers)) {
        $controller = $controllers[$page];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (in_array($action, ['store', 'update'])) {
        if ($action === 'update') {
            $id = $_POST['is_supplier'];
            $controller->$action($id, $_POST);  
        } else {
            $controller->$action($_POST);
        }
    }
    elseif ($action === 'destroy') {
        $controller->$action($_POST['id_supplier']);
    }
} else {
    if (in_array($action, $allowedActions) && method_exists($controller, $action)) {
        $controller->$action(); 
    } else {
        throw new Exception("Aksi tidak valid atau halaman tidak ditemukan!");
    }
}
    } else {
        $viewFile = "app/views/content/{$page}.php";
        if (file_exists($viewFile)) {
            include $viewFile;
            throw new Exception("Halaman tidak ditemukan!");
        }
    }
} catch (Exception $e) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>{$e->getMessage()}</div></div>";
}

require_once 'views/layouts/footer.php';
