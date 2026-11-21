
<section class="panel">

    <div class="toolbar">
        <h2>Daftar Pengadaan</h2>

        <a
            class="btn"
            href="<?= e(url('pengadaan', 'create')) ?>"
        >
            + Buat Pengadaan
        </a>
    </div>

    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Vendor</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td>
                            <?= e($row['idpengadaan']) ?>
                        </td>

                        <td>
                            <?= e($row['username']) ?>
                        </td>

                        <td>
                            <?= e($row['nama_vendor']) ?>
                        </td>

                        <td>
                            <?= $row['status'] === 'D'
                                ? 'Draft'
                                : 'Selesai' ?>
                        </td>

                        <td>
                            Rp <?= number_format(
                                $row['total_nilai'],
                                0,
                                ',',
                                '.'
                            ) ?>
                        </td>

                        <td>
                            <a
                                class="btn secondary"
                                href="<?= e(url(
                                    'pengadaan',
                                    'show',
                                    [
                                        'id' =>
                                        $row['idpengadaan']
                                    ]
                                )) ?>"
                            >
                                Detail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (!$rows): ?>
                    <tr>
                        <td colspan="6">
                            Belum ada pengadaan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</section>
