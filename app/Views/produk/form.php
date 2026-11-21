<section class="panel form-panel">
    <form method="post" action="<?= e(url('produk', 'store')) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
        <label for="idProduk">ID Produk</label>
        <input id="idProduk" name="idProduk" type="number" required>

        <label for="jenis">Jenis</label>
        <input id="jenis" name="jenis" type="text" required maxlength="1">

        <label for="namaProduk">Nama Produk</label>
        <input id="namaProduk" name="namaProduk" type="text" required maxlength="45">

        <label for="idsatuan">ID Satuan</label>
        <input id="idsatuan" name="idsatuan" type="number" required>

        <label for="status">Status</label>
        <input id="status" name="status" type="number" required>

        <label for="harga">Harga</label>
        <input id="harga" name="harga" type="number" required>

        <div class="toolbar">
            <a href="<?= e(url('produk')) ?>">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>
</section>
