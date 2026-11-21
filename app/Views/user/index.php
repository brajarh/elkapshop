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
