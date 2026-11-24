<section class="panel">
    <div class="toolbar">
        <h2>Penjualan #<?= e($row['idpenjualan']) ?></h2>
        <a class="btn secondary" href="<?= e(url('penjualan')) ?>">Kembali</a>
    </div>
    <p>User: <?= e($row['username']) ?></p>
    <p>Waktu: <?= e($row['created_at']) ?></p>
    <p>Margin: <?= e($row['persen']) ?>%</p>
</section>

<section class="panel">
    <h2>Daftar Produk Penjualan</h2>
    <div class="scroll">
        <table>
            <thead><tr><th>Detail</th><th>Produk</th><th>Harga Satuan</th><th>Jumlah</th><th>Subtotal</th></tr></thead>
            <tbody>
                <?php foreach ($details as $d): ?>
                    <tr>
                        <td><?= e($d['iddetail_penjualan']) ?></td>
                        <td><?= e($d['namaProduk']) ?></td>
                        <td>Rp <?= number_format((float)$d['harga_satuan'], 0, ',', '.') ?></td>
                        <td><?= e($d['jumlah']) ?></td>
                        <td>Rp <?= number_format((float)$d['subtotal'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (!$details): ?>
                    <tr><td colspan="5">Belum ada produk.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<section class="panel">
    <h2>Ringkasan Penjualan</h2>
    <p>Subtotal: <strong>Rp <?= number_format((float)$row['subtotal_nilai'], 0, ',', '.') ?></strong></p>
    <p>PPN: <strong>Rp <?= number_format((float)$row['ppn'], 0, ',', '.') ?></strong></p>
    <h3>Total: Rp <?= number_format((float)$row['total_nilai'], 0, ',', '.') ?></h3>
</section>
