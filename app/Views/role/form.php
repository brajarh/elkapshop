<section class="panel form-panel">
    <form method="post" action="<?= e(url('role', 'store')) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
        <label for="idrole">ID Role</label>
        <input id="idrole" name="idrole" type="number" required>

        <label for="nama_role">Nama Role</label>
        <input id="nama_role" name="nama_role" type="text" required maxlength="100">

        <div class="toolbar">
            <a href="<?= e(url('role')) ?>">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>
</section>
