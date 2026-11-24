
<section class="panel">

    <div class="toolbar">
        <h2>Detail Produk</h2>

        <a class="btn secondary"
           href="<?= e(url('produk')) ?>">
            Kembali
        </a>
    </div>

    <table>
        <tr>
            <th>ID Produk</th>
            <td><?= e($row['idProduk']) ?></td>
        </tr>

        <tr>
            <th>Nama Produk</th>
            <td><?= e($row['namaProduk']) ?></td>
        </tr>

        <tr>
            <th>Jenis</th>
            <td><?= e($row['jenis']) ?></td>
        </tr>

        <tr>
            <th>Harga Dasar</th>
            <td>
                Rp <?= number_format(
                    (float) $row['harga'], 0, ',', '.'
                ) ?>
            </td>
        </tr>

        <tr>
            <th>Status</th>
            <td>
                <?= (int) $row['status'] === 1
                    ? 'Aktif'
                    : 'Tidak Aktif' ?>
            </td>
        </tr>

        <tr>
            <th>Stok Terkini</th>
            <td><?= e($details[0]['stock'] ?? 0) ?></td>
        </tr>
    </table>

</section>

<section class="panel">

    <div class="toolbar">
        <h2>Kartu Stok</h2>
    </div>

    <div class="scroll">

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>ID Transaksi</th>
                    <th>Jenis Transaksi</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                    <th>Saldo Stok</th>
                </tr>
            </thead>

            <tbody>

                <?php $no = 1; ?>

                <?php foreach ($details as $d): ?>

                    <tr>
                        <td><?= $no++ ?></td>

                        <td><?= e($d['created_at']) ?></td>

                        <td><?= e($d['idtransaksi']) ?></td>

                        <td>
                            <?php if ($d['jenis_transaksi'] === 'M'): ?>
                                Masuk
                            <?php elseif ($d['jenis_transaksi'] === 'K'): ?>
                                Keluar
                            <?php else: ?>
                                <?= e($d['jenis_transaksi']) ?>
                            <?php endif; ?>
                        </td>

                        <td><?= e($d['masuk']) ?></td>

                        <td><?= e($d['keluar']) ?></td>

                        <td><?= e($d['stock']) ?></td>
                    </tr>

                <?php endforeach; ?>

                <?php if (empty($details)): ?>

                    <tr>
                        <td colspan="7">
                            Belum ada riwayat kartu stok.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>
        </table>

    </div>

</section>
