<section class="panel">

    <div class="toolbar">
        <h2>Data Penerimaan</h2>

        <a class="btn" href="<?= e(url('penerimaan', 'create')) ?>">
            + Tambah Penerimaan
        </a>
    </div>

    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>ID Pengadaan</th>
                    <th>Vendor</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($penerimaan)): ?>
                    <tr>
                        <td colspan="7">Belum ada data penerimaan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($penerimaan as $pn): ?>
                        <?php
                            $status = $pn['status'];
                            if ($status === 'D') {
                                $label = 'Draft';
                            } elseif ($status === 'P') {
                                $label = 'Pending';
                            } elseif ($status === 'S') {
                                $label = 'Selesai';
                            } else {
                                $label = 'Tidak diketahui';
                            }
                        ?>
                        <tr>
                            <td><?= (int) $pn['idpenerimaan'] ?></td>
                            <td><?= e($pn['created_at']) ?></td>
                            <td>#<?= (int) $pn['idpengadaan'] ?></td>
                            <td><?= e($pn['nama_vendor']) ?></td>
                            <td><?= e($pn['username']) ?></td>
                            <td><strong><?= $label ?></strong></td>
                            <td>
                                <a class="btn secondary" href="<?= e(url('penerimaan', 'show', ['id' => (int) $pn['idpenerimaan']])) ?>">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</section>
