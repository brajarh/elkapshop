<?php

session_start();

$_SESSION['csrf'] ??= bin2hex(
    random_bytes(32)
);

require __DIR__ . '/../config/dbconnection.php';
require __DIR__ . '/../core/Controller.php';
require __DIR__ . '/../core/Model.php';
require __DIR__ . '/../routes/web.php';

try {
    $page = $_GET['page'] ?? 'dashboard';
    $action = $_GET['action'] ?? 'index';

    $actions = [
        'index',
        'create',
        'store',
        'edit',
        'update',
        'delete'
    ];

    // Action untuk VIEW data aktif
    if (in_array(
        $page,
        [
            'produk',
            'satuan',
            'vendor',
            'margin-penjualan'
        ],
        true
    )) {
        $actions[] = 'aktif';
    }

    // Action khusus pengadaan
    if ($page === 'pengadaan') {
        $actions[] = 'show';
        $actions[] = 'addDetail';
        $actions[] = 'finish';
    }

    // Action khusus penerimaan
if ($page === 'penerimaan') {
    $actions[] = 'show';
    $actions[] = 'storeDetail';
    $actions[] = 'simpan';
}

    if (in_array($page, ['pengadaan', 'penerimaan'], true)) {
        $actions[] = 'updateDetail';
        $actions[] = 'deleteDetail';
    }

    // Memeriksa halaman dan action
    if (
        !is_string($page) ||
        !is_string($action) ||
        !isset($routes[$page]) ||
        !in_array(
            $action,
            $page === 'dashboard'
                ? ['index']
                : $actions,
            true
        )
    ) {
        http_response_code(404);

        throw new RuntimeException(
            'Halaman tidak ditemukan.'
        );
    }

    // Action yang harus memakai POST
    $write = in_array(
    $action,
    [
        'store',
        'update',
        'delete',
        'addDetail',
        'finish',
        'storeDetail',
        'updateDetail',
        'deleteDetail',
        'simpan'
    ],
    true
    );
    

    $method = $write ? 'POST' : 'GET';

    if ($_SERVER['REQUEST_METHOD'] !== $method) {
        http_response_code(405);

        throw new RuntimeException(
            'Metode HTTP tidak diizinkan.'
        );
    }

    // Memeriksa token CSRF
    if ($write) {
        $token = $_POST['csrf'] ?? null;

        if (
            !is_string($token) ||
            !hash_equals(
                $_SESSION['csrf'],
                $token
            )
        ) {
            http_response_code(403);

            throw new RuntimeException(
                'Token form tidak valid.'
            );
        }
    }

    // Menjalankan Controller
    $class = $routes[$page];

    require __DIR__
        . '/../app/Controllers/'
        . $class
        . '.php';

    $controller = new $class();

    $controller->$action();

} catch (Throwable $error) {

    if (http_response_code() < 400) {
        http_response_code(500);
    }

    $title = 'Terjadi kesalahan';

    require __DIR__
        . '/../app/Views/layouts/header.php';

    require __DIR__
        . '/../app/Views/layouts/error.php';

    require __DIR__
        . '/../app/Views/layouts/footer.php';
}
