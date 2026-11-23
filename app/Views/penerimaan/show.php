<?php
$id = (int) $penerimaan['idpenerimaan'];
$isDraft = $penerimaan['status'] === 'D';

$statusLabel = [
    'D' => 'Draft',
    'P' => 'Pending',
    'S' => 'Selesai'
];

$status = $penerimaan['status'];
$label = $statusLabel[$status] ?? 'Tidak diketahui';

$totalJumlah = 0;
$totalNilai = 0;

foreach ($details as $detail) {
    $totalJumlah += (int) $detail['jumlah_terima'];
    $totalNilai += (int) $detail['sub_total_terima'];
}
?>

<section class="panel">
    <div class="toolbar">
        <h2>Detail Penerimaan #<?= $id ?></h2>
        <a class="btn secondary" href="<?= e(url('penerimaan')) ?>">
            Kembali
        </a>
    </div>

    <p>ID Pengadaan: <strong>#<?= (int) $penerimaan['idpengadaan'] ?></strong></p>
    <p>Vendor: <strong><?= e($penerimaan['nama_vendor']) ?></strong></p>
    <p>User Penerima: <strong><?= e($penerimaan['username']) ?></strong></p>
    <p>Tanggal Penerimaan: <strong><?= e($penerimaan['created_at']) ?></strong></p>
    <p>Status: <strong><?= $label ?></strong></p>
</section>

<?php if ($isDraft): ?>
    <section class="panel form-panel">
        <h2>Tambah Barang Diterima</h2>

        <?php if (empty($produk)): ?>
            <p>Tidak ada produk dengan sisa pengadaan.</p>
        <?php else: ?>
            <form method="post" action="<?= e(url('penerimaan', 'storeDetail', ['id' => $id])) ?>">
                <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">

                <label for="idproduk">Produk</label>
                <select name="idproduk" id="idproduk" required>
                    <option value="">-- Pilih Produk --</option>
                    <?php foreach ($produk as $p): ?>
                        <option value="<?= (int) ($p['idbarang'] ?? $p['idproduk'] ?? $p['idProduk'] ?? 0) ?>">
                            <?= e($p['namaProduk']) ?> (Sisa: <?= (int) $p['sisa_pengadaan'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="jumlah">Jumlah Diterima</label>
                <input type="number" id="jumlah" name="jumlah" min="1" required>

                <label for="harga">Harga Satuan Terima</label>
                <input type="number" id="harga" name="harga" min="0" required>

                <div class="toolbar">
                    <button type="submit">+ Tambah Barang</button>
                </div>
            </form>
        <?php endif; ?>
    </section>
<?php endif; ?>

<section class="panel">
    <h2>Daftar Barang Diterima</h2>

    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($details)): ?>
                    <tr>
                        <td colspan="4">Belum ada barang yang diterima.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($details as $d): ?>
                        <tr>
                            <td><?= e($d['namaProduk']) ?></td>
                            <td><?= (int) $d['jumlah_terima'] ?></td>
                            <td>Rp <?= number_format((int) $d['harga_satuan_terima'], 0, ',', '.') ?></td>
                            <td>Rp <?= number_format((int) $d['sub_total_terima'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total</th>
                    <th><?= $totalJumlah ?></th>
                    <th>-</th>
                    <th>Rp <?= number_format($totalNilai, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

<?php if ($isDraft && !empty($details)): ?>
    <section class="panel">
        <h2>Konfirmasi Penerimaan</h2>
        <p>Setelah dikonfirmasi, penerimaan tidak dapat ditambahkan detail lagi dan stok barang akan diperbarui.</p>
        <form method="post" action="<?= e(url('penerimaan', 'simpan', ['id' => $id])) ?>">
            <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
            <button type="submit" onclick="return confirm('Yakin ingin mengonfirmasi penerimaan ini?')">
                Konfirmasi Penerimaan
            </button>
        </form>
    </section>
<?php endif; ?>


<?php if ($penerimaan['status'] === 'D'): ?>
<section class="panel">
    <div class="toolbar">
        <a class="btn secondary" href="<?= e(url('penerimaan', 'edit', ['id' => (int) $penerimaan['idpenerimaan']])) ?>">Edit transaksi</a>
        <form method="post" action="<?= e(url('penerimaan', 'delete', ['id' => (int) $penerimaan['idpenerimaan']])) ?>" onsubmit="return confirm('Hapus transaksi Draft beserta detailnya?')">
            <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
            <button type="submit">Hapus Draft</button>
        </form>
    </div>
</section>
<section class="panel form-panel">
    <h2>Edit / Hapus Detail Draft</h2>
    <?php foreach ($details as $item): ?>
        <?php if (isset($item['iddetail_penerimaan'])): ?>
            <p><?= e($item['namaProduk']) ?></p>
            <form method="post" action="<?= e(url('penerimaan', 'updateDetail', ['id' => (int) $penerimaan['idpenerimaan']])) ?>">
                <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
                <input type="hidden" name="detail" value="<?= e($item['iddetail_penerimaan']) ?>">
                <label>Harga Satuan <input type="number" name="harga" min="0" required value="<?= e($item['harga_satuan_terima']) ?>"></label>
                <label>Jumlah <input type="number" name="jumlah" min="1" required value="<?= e($item['jumlah_terima']) ?>"></label>
                <button type="submit">Simpan Detail</button>
            </form>
            <form method="post" action="<?= e(url('penerimaan', 'deleteDetail', ['id' => (int) $penerimaan['idpenerimaan']])) ?>" onsubmit="return confirm('Hapus detail ini?')">
                <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
                <input type="hidden" name="detail" value="<?= e($item['iddetail_penerimaan']) ?>">
                <button type="submit">Hapus Detail</button>
            </form>
        <?php else: ?>
            <p>VIEW detail belum menyediakan ID detail.</p>
        <?php endif; ?>
    <?php endforeach; ?>
</section>
<?php endif; ?>
