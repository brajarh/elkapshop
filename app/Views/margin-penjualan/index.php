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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= e($row['persen']) ?></td>
                        <td><?= e($row['status']) ?></td>
                        <td>
                            <?php if (isset($row['idmargin_penjualan']) && (int) $row['idmargin_penjualan'] > 0): ?>
                                <a class="btn secondary" href="<?= e(url('margin-penjualan', 'edit', ['id' => (int) $row['idmargin_penjualan']])) ?>">Edit</a>
                                <form method="post" action="<?= e(url('margin-penjualan', 'delete', ['id' => (int) $row['idmargin_penjualan']])) ?>" style="display:inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                    <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
                                    <button type="submit">Hapus</button>
                                </form>
                            <?php else: ?>
                                <small>ID data tidak valid.</small>
                            <?php endif; ?>
                        </td>
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
