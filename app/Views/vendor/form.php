<section class="panel form-panel">
    <form method="post" action="<?= e(url('vendor', 'store')) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
        <label for="idvendor">ID Vendor</label>
        <input id="idvendor" name="idvendor" type="number" required>

        <label for="nama_vendor">Nama Vendor</label>
        <input id="nama_vendor" name="nama_vendor" type="text" required maxlength="100">

        <label for="badan_hukum">Badan Hukum</label>
        <input id="badan_hukum" name="badan_hukum" type="text" required maxlength="1">

        <label for="status">Status</label>
        <input id="status" name="status" type="text" required maxlength="1">

        <div class="toolbar">
            <a href="<?= e(url('vendor')) ?>">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>
</section>
