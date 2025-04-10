    <?php
    session_start();

    require_once 'config/database.php';
    require_once 'controllers/SupplierController.php';
    require_once 'controllers/BarangController.php';
    require_once 'controllers/DistribusiController.php';
    require_once 'controllers/DetailDistribusiController.php';
    require_once 'controllers/HomeController.php';

    $db = new Database();

    // Inisialisasi controller
    $controllers = [
        'supplier' => new SupplierController($db),
        'barang' => new BarangController($db),
        'detail_distribusi' => new DetailDistribusiController($db),
        'distribusi' => new DistribusiController($db),
        'home' => new HomeController($db),
    ];

    // Ambil parameter halaman dan aksi
    $page = htmlspecialchars($_GET['page'] ?? 'home', ENT_QUOTES, 'UTF-8');
    $action = htmlspecialchars($_GET['action'] ?? 'index', ENT_QUOTES, 'UTF-8');
    $allowedActions = ['index', 'show', 'store', 'update', 'destroy', 'konfirmasi'];

    // Layout header dan sidebar
    require_once 'views/layouts/header.php';
    require_once 'views/layouts/sidebar.php';

    try {
        // Jika controller tidak terdaftar
        if (!array_key_exists($page, $controllers)) {
            $viewFile = "views/content/{$page}.php";
            if (file_exists($viewFile)) {
                include $viewFile;
            } else {
                throw new Exception("Halaman tidak ditemukan!");
            }
        } else {
            $controller = $controllers[$page];

            // Tangani request POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $idField = "id_" . $page;

                switch ($action) {
                    case 'store':
                        $controller->store($_POST);
                        break;
                    case 'update':
                        $controller->update($_POST[$idField] ?? null, $_POST);
                        break;
                    case 'destroy':
                        $controller->destroy($_POST[$idField] ?? null);
                        break;
                    case 'konfirmasi':
                        $controller->konfirmasi($_POST);
                        break;
                    default:
                        throw new Exception("Aksi POST tidak valid!");
                }

            // Tangani request GET
            } elseif (in_array($action, $allowedActions) && method_exists($controller, $action)) {
                if ($action === 'show') {
                    $controller->show($_GET['id'] ?? null);
                } else {
                    $controller->$action();
                }
            } else {
                throw new Exception("Aksi tidak valid!");
            }
        }

    } catch (Exception $e) {
        echo "<div class='container mt-5'><div class='alert alert-danger'>{$e->getMessage()}</div></div>";
    }

    require_once 'views/layouts/footer.php';
    ?>
