<section class="panel">
    <div class="toolbar">
        <h2>Daftar User<?= $aktif ? ' Aktif' : '' ?></h2>
        <a class="btn" href="<?= e(url('user', 'create')) ?>">
            + Tambah
        </a>
    </div>

    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID User</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= e($row['ID']) ?></td>
                        <td><?= e($row['USERNAME']) ?></td>
                        <td><?= e($row['ROLE']) ?></td>
                        <td>
                            <?php if (isset($row['ID']) && (int) $row['ID'] > 0): ?>
                                <a class="btn secondary" href="<?= e(url('user', 'edit', ['id' => (int) $row['ID']])) ?>">Edit</a>
                                <form method="post" action="<?= e(url('user', 'delete', ['id' => (int) $row['ID']])) ?>" style="display:inline" onsubmit="return confirm('Yakin hapus data ini?')">
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
                        <td colspan="5">Belum ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
