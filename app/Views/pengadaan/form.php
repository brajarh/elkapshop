
<section class="panel form-panel">

    <h2>Buat Pengadaan Baru</h2>

    <p>
        Masukkan informasi pengadaan terlebih dahulu.
        Produk dapat ditambahkan setelah pengadaan dibuat.
    </p>

    <form
        method="post"
        action="<?= e(url('pengadaan', 'store')) ?>"
    >
        <input
            type="hidden"
            name="csrf"
            value="<?= e($_SESSION['csrf']) ?>"
        >

        <label for="iduser">User</label>
        <select id="iduser" name="iduser" required>
            <option value="">-- Pilih User --</option>
            <?php foreach ($users as $u): ?>
                <option value="<?= e($u['ID']) ?>"><?= e($u['USERNAME']) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="idvendor">Vendor</label>
        <select id="idvendor" name="idvendor" required>
            <option value="">-- Pilih Vendor --</option>
            <?php foreach ($vendors as $v): ?>
                <option value="<?= e($v['idvendor']) ?>"><?= e($v['nama_vendor']) ?></option>
            <?php endforeach; ?>
        </select>

        <p>
            Status awal: Draft (D)
        </p>

        <div class="toolbar">
            <a href="<?= e(url('pengadaan')) ?>">
                Batal
            </a>

            <button type="submit">
                Simpan & Lanjut ke Detail
            </button>
        </div>
    </form>

</section>
