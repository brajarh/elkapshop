<section class="panel">
    <div class="toolbar">
        <h2>Daftar Vendor<?= $aktif ? ' Aktif' : '' ?></h2>
        <a class="btn" href="<?= e(url('vendor', 'create')) ?>">
            + Tambah
        </a>
    </div>

    <div class="filters">
        <a class="btn <?= $aktif ? 'secondary' : '' ?>" href="<?= e(url('vendor')) ?>">
            Semua Data
        </a>
        <a class="btn <?= $aktif ? '' : 'secondary' ?>" href="<?= e(url('vendor', 'aktif')) ?>">
            Data Aktif
        </a>
    </div>

    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Vendor</th>
                    <th>Badan Hukum</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= e($row['nama_vendor']) ?></td>
                        <td><?= e($row['badan_hukum']) ?></td>
                        <td><?= e($row['status']) ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if (!$rows): ?>
                    <tr>
                        <td colspan="4">Belum ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
