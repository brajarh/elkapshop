<section class="panel form-panel">
    <form method="post" action="<?= e(url('satuan', 'store')) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
        <label for="idsatuan">ID Satuan</label>
        <input id="idsatuan" name="idsatuan" type="number" required>

        <label for="namaSatuan">Nama Satuan</label>
        <input id="namaSatuan" name="namaSatuan" type="text" required maxlength="45">

        <label for="Status">Status</label>
        <input id="Status" name="Status" type="number" required>

        <div class="toolbar">
            <a href="<?= e(url('satuan')) ?>">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>
</section>
