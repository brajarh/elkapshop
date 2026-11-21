<section class="panel">
    <div class="toolbar">
        <h2>Daftar Margin Penjualan<?= $aktif ? ' Aktif' : '' ?></h2>
        <a class="btn" href="<?= e(url('margin-penjualan', 'create')) ?>">
            + Tambah
        </a>
    </div>

    <div class="filters">
        <a class="btn <?= $aktif ? 'secondary' : '' ?>" href="<?= e(url('margin-penjualan')) ?>">
            Semua Data
        </a>
        <a class="btn <?= $aktif ? '' : 'secondary' ?>" href="<?= e(url('margin-penjualan', 'aktif')) ?>">
            Data Aktif
        </a>
    </div>

    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Persen</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= e($row['persen']) ?></td>
                        <td><?= e($row['status']) ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if (!$rows): ?>
                    <tr>
                        <td colspan="3">Belum ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
