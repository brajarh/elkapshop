
<section class="panel">

    <div class="toolbar">
        <h2>
            Pengadaan #<?= e($pengadaan['idpengadaan']) ?>
        </h2>

        <a
            class="btn secondary"
            href="<?= e(url('pengadaan')) ?>"
        >
            Kembali
        </a>
    </div>

    <p>
    User:
    <?= e($pengadaan['username']) ?>
</p>

<p>
    Vendor:
    <?= e($pengadaan['nama_vendor']) ?>
</p>

    <p>
        Status:
        <strong>
            <?= $pengadaan['status'] === 'D'
                ? 'Draft'
                : 'Selesai' ?>
        </strong>
    </p>

</section>

<section class="panel">

    <h2>Daftar Produk Pengadaan</h2>

    <div class="scroll">
        <table>
            <thead>
                <tr>
                    <th>Detail</th>
                    <th>Produk</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($details as $row): ?>
                    <tr>
                        <td>
                            <?= e(
                                $row['iddetail_pengadaan']
                            ) ?>
                        </td>

                        <td>
    <?= e($row['namaProduk']) ?>
</td>

                        <td>
                            Rp <?= number_format(
                                $row['harga_satuan'],
                                0,
                                ',',
                                '.'
                            ) ?>
                        </td>

                        <td>
                            <?= e($row['jumlah']) ?>
                        </td>

                        <td>
                            Rp <?= number_format(
                                $row['sub_total'],
                                0,
                                ',',
                                '.'
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (!$details): ?>
                    <tr>
                        <td colspan="5">
                            Belum ada produk.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</section>

<?php if ($pengadaan['status'] === 'D'): ?>

    <section class="panel form-panel">

        <h2>Tambah Produk</h2>

        <form
            method="post"
            action="<?= e(url(
                'pengadaan',
                'addDetail'
            )) ?>"
        >
            <input
                type="hidden"
                name="csrf"
                value="<?= e($_SESSION['csrf']) ?>"
            >

            <input
                type="hidden"
                name="idpengadaan"
                value="<?= e(
                    $pengadaan['idpengadaan']
                ) ?>"
            >

            <label for="idproduk">Produk</label>
        <select id="idproduk" name="idproduk" required>
            <option value="">-- Pilih Produk --</option>
            <?php foreach ($produks as $p): ?>
                <option value="<?= e($p['idProduk']) ?>"><?= e($p['namaProduk']) ?></option>
            <?php endforeach; ?>
        </select>

            <label for="harga">
                Harga Satuan
            </label>

            <input
                type="number"
                id="harga"
                name="harga"
                min="0"
                required
            >

            <label for="jumlah">
                Jumlah
            </label>

            <input
                type="number"
                id="jumlah"
                name="jumlah"
                min="1"
                required
            >

            <button type="submit">
                + Simpan Produk
            </button>
        </form>

    </section>

<?php endif; ?>

<section class="panel">

    <h2>Ringkasan Pengadaan</h2>

    <p>
        Subtotal:
        <strong>
            Rp <?= number_format(
                $pengadaan['subtotal_nilai'],
                0,
                ',',
                '.'
            ) ?>
        </strong>
    </p>

    <p>
        PPN:
        <strong>
            Rp <?= number_format(
                $pengadaan['ppn'],
                0,
                ',',
                '.'
            ) ?>
        </strong>
    </p>

    <h3>
        Total:
        Rp <?= number_format(
            $pengadaan['total_nilai'],
            0,
            ',',
            '.'
        ) ?>
    </h3>

    <?php if (
        $pengadaan['status'] === 'D'
        && count($details) > 0
    ): ?>

        <form
            method="post"
            action="<?= e(url(
                'pengadaan',
                'finish'
            )) ?>"
        >
            <input
                type="hidden"
                name="csrf"
                value="<?= e($_SESSION['csrf']) ?>"
            >

            <input
                type="hidden"
                name="idpengadaan"
                value="<?= e(
                    $pengadaan['idpengadaan']
                ) ?>"
            >

            <button
                type="submit"
                onclick="return confirm(
                    'Yakin ingin menyelesaikan pengadaan?'
                )"
            >
                Selesaikan Pengadaan
            </button>
        </form>

    <?php endif; ?>

</section>


<?php if ($pengadaan['status'] === 'D'): ?>
<section class="panel">
    <div class="toolbar">
        <a class="btn secondary" href="<?= e(url('pengadaan', 'edit', ['id' => (int) $pengadaan['idpengadaan']])) ?>">Edit transaksi</a>
        <form method="post" action="<?= e(url('pengadaan', 'delete', ['id' => (int) $pengadaan['idpengadaan']])) ?>" onsubmit="return confirm('Hapus transaksi Draft beserta detailnya?')">
            <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
            <button type="submit">Hapus Draft</button>
        </form>
    </div>
</section>
<section class="panel form-panel">
    <h2>Edit / Hapus Detail Draft</h2>
    <?php foreach ($details as $item): ?>
        <?php if (isset($item['iddetail_pengadaan'])): ?>
            <p><?= e($item['namaProduk']) ?></p>
            <form method="post" action="<?= e(url('pengadaan', 'updateDetail', ['id' => (int) $pengadaan['idpengadaan']])) ?>">
                <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
                <input type="hidden" name="detail" value="<?= e($item['iddetail_pengadaan']) ?>">
                <label>Harga Satuan <input type="number" name="harga" min="0" required value="<?= e($item['harga_satuan']) ?>"></label>
                <label>Jumlah <input type="number" name="jumlah" min="1" required value="<?= e($item['jumlah']) ?>"></label>
                <button type="submit">Simpan Detail</button>
            </form>
            <form method="post" action="<?= e(url('pengadaan', 'deleteDetail', ['id' => (int) $pengadaan['idpengadaan']])) ?>" onsubmit="return confirm('Hapus detail ini?')">
                <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
                <input type="hidden" name="detail" value="<?= e($item['iddetail_pengadaan']) ?>">
                <button type="submit">Hapus Detail</button>
            </form>
        <?php else: ?>
            <p>VIEW detail belum menyediakan ID detail.</p>
        <?php endif; ?>
    <?php endforeach; ?>
</section>
<?php endif; ?>
