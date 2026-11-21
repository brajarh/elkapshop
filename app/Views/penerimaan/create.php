<section class="panel form-panel">

    <h2>Tambah Penerimaan Baru</h2>

    <p>
        Pilih pengadaan untuk membuat penerimaan barang.
        Penerimaan baru akan dibuat dengan status Draft.
    </p>

    <form method="post" action="<?= e(url('penerimaan', 'store')) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">

        <label for="idpengadaan">Pilih Pengadaan</label>
        <select name="idpengadaan" id="idpengadaan" required>
            <option value="">-- Pilih Pengadaan --</option>
            <?php foreach ($pengadaan as $pg): ?>
                <option value="<?= (int) $pg['idpengadaan'] ?>">
                    Pengadaan #<?= (int) $pg['idpengadaan'] ?> - <?= e($pg['nama_vendor']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <small style="display:block;margin-top:4px;color:#687483;">Hanya pengadaan berstatus selesai yang ditampilkan.</small>

        <label for="iduser">ID User Penerima</label>
        <input type="number" id="iduser" name="iduser" min="1" placeholder="Masukkan ID User" required>
        <small style="display:block;margin-top:4px;color:#687483;">Gunakan ID user yang terdaftar dalam database.</small>

        <div class="toolbar">
            <a class="btn secondary" href="<?= e(url('penerimaan')) ?>">
                Batal
            </a>
            <button type="submit">
                Buat Penerimaan
            </button>
        </div>
    </form>

</section>
