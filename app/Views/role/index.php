<section class="panel">
    <div class="toolbar">
        <h2>Daftar Role<?= $aktif ? ' Aktif' : '' ?></h2>
        <a class="btn" href="<?= e(url('role', 'create')) ?>">
            + Tambah
        </a>
    </div>

    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= e($row['nama_role']) ?></td>
                        <td>
                            <?php if (isset($row['idrole']) && (int) $row['idrole'] > 0): ?>
                                <a class="btn secondary" href="<?= e(url('role', 'edit', ['id' => (int) $row['idrole']])) ?>">Edit</a>
                                <form method="post" action="<?= e(url('role', 'delete', ['id' => (int) $row['idrole']])) ?>" style="display:inline" onsubmit="return confirm('Yakin hapus data ini?')">
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
                        <td colspan="3">Belum ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
