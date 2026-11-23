<section class="panel">
    <div class="toolbar">
        <h2>Daftar Satuan<?= $aktif ? ' Aktif' : '' ?></h2>
        <a class="btn" href="<?= e(url('satuan', 'create')) ?>">
            + Tambah
        </a>
    </div>

    <div class="filters">
        <a class="btn <?= $aktif ? 'secondary' : '' ?>" href="<?= e(url('satuan')) ?>">
            Semua Data
        </a>
        <a class="btn <?= $aktif ? '' : 'secondary' ?>" href="<?= e(url('satuan', 'aktif')) ?>">
            Data Aktif
        </a>
    </div>

    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Satuan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= e($row['SATUAN']) ?></td>
                        <td><?= e($row['Status']) ?></td>
                        <td>
                            <?php if (isset($row['idsatuan']) && (int) $row['idsatuan'] > 0): ?>
                                <a class="btn secondary" href="<?= e(url('satuan', 'edit', ['id' => (int) $row['idsatuan']])) ?>">Edit</a>
                                <form method="post" action="<?= e(url('satuan', 'delete', ['id' => (int) $row['idsatuan']])) ?>" style="display:inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                    <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
                                    <button type="submit">Hapus</button>
                                </form>
                            <?php else: ?>
                                <small>VIEW belum menyediakan ID.</small>
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
