<section class="panel">
    <div class="toolbar">
        <h2>Daftar Produk<?= $aktif ? ' Aktif' : '' ?></h2>
        <a class="btn" href="<?= e(url('produk', 'create')) ?>">
            + Tambah
        </a>
    </div>

    <div class="filters">
        <a class="btn <?= $aktif ? 'secondary' : '' ?>" href="<?= e(url('produk')) ?>">
            Semua Data
        </a>
        <a class="btn <?= $aktif ? '' : 'secondary' ?>" href="<?= e(url('produk', 'aktif')) ?>">
            Data Aktif
        </a>
    </div>

    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Jenis</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= e($row['namaProduk']) ?></td>
                        <td><?= e($row['jenis']) ?></td>
                        <td><?= e($row['namaSatuan']) ?></td>
                        <td><?= e($row['harga'] === null ? '-' : 'Rp ' . number_format((float) $row['harga'], 0, ',', '.')) ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if (!$rows): ?>
                    <tr>
                        <td colspan="5">Belum ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
