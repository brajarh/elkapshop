<section class="panel form-panel">
    <form method="post" action="<?= e(url('user', 'store')) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
        <label for="iduser">ID User</label>
        <input id="iduser" name="iduser" type="number" required>

        <label for="username">Username</label>
        <input id="username" name="username" type="text" required maxlength="45">

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required maxlength="100">

        <small>Jangan gunakan password asli pada demo lokal.</small>

        <label for="idrole">ID Role</label>
        <input id="idrole" name="idrole" type="number" required>

        <div class="toolbar">
            <a href="<?= e(url('user')) ?>">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>
</section>
