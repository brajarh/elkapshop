
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

        <label for="iduser">
            ID User
        </label>

        <input
            type="number"
            id="iduser"
            name="iduser"
            min="1"
            required
        >

        <label for="idvendor">
            ID Vendor
        </label>

        <input
            type="number"
            id="idvendor"
            name="idvendor"
            min="1"
            required
        >

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
