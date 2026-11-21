<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'Elkap') ?> | Elkap</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <aside>
        <div class="brand">
            ELKAP<span>BARBERSHOP / ADMIN</span>
        </div>
        <nav>
            <a href="<?= e(url('dashboard')) ?>">Dashboard</a>
            <a href="<?= e(url('produk')) ?>">Produk</a>
            <a href="<?= e(url('satuan')) ?>">Satuan</a>
            <a href="<?= e(url('vendor')) ?>">Vendor</a>
            <a href="<?= e(url('user')) ?>">User</a>
            <a href="<?= e(url('role')) ?>">Role</a>
            <a href="<?= e(url('margin-penjualan')) ?>">Margin Penjualan</a>
            <a href="<?= e(url('pengadaan')) ?>">Pengadaan</a>
            <a href="<?= e(url('penerimaan')) ?>">Penerimaan</a>
        </nav>
    </aside>
    <main>
        <header>
            <small>MASTER DATA / PBD</small>
            <h1><?= e($title ?? 'Elkap') ?></h1>
        </header>
        <?php if (isset($_SESSION['flash'])): ?>
            <p class="flash"><?= e($_SESSION['flash']) ?></p>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
