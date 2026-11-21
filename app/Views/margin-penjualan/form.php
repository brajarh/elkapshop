<section class="panel form-panel">
    <form method="post" action="<?= e(url('margin-penjualan', 'store')) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
        <label for="idmargin_penjualan">ID Margin</label>
        <input id="idmargin_penjualan" name="idmargin_penjualan" type="number" required>

        <label for="created_at">Dibuat</label>
        <input id="created_at" name="created_at" type="datetime-local" required>

        <label for="persen">Persen</label>
        <input id="persen" name="persen" type="number" required step="any">

        <label for="status">Status</label>
        <input id="status" name="status" type="number" required>

        <label for="iduser">ID User</label>
        <input id="iduser" name="iduser" type="number" required>

        <label for="updated_at">Diperbarui</label>
        <input id="updated_at" name="updated_at" type="datetime-local" required>

        <div class="toolbar">
            <a href="<?= e(url('margin-penjualan')) ?>">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>
</section>
