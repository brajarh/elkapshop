<?php $edit = !empty($row); ?>
<section class="panel form-panel">
    <form method="post" action="<?= e(url('user', $edit ? 'update' : 'store', $edit ? ['id' => (int) $row['ID']] : [])) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">

        <label for="username">Username</label>
        <input id="username" name="username" type="text" required maxlength="45" value="<?= e($row['USERNAME'] ?? '') ?>">

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required maxlength="100">

        <small><?= $edit ? 'Masukkan password baru; password lama tidak ditampilkan.' : 'Jangan gunakan password asli pada demo lokal.' ?></small>

        <label for="idrole">ID Role</label>
        <input id="idrole" name="idrole" type="number" required value="<?= e($row['idrole'] ?? '') ?>">

        <div class="toolbar">
            <a href="<?= e(url('user')) ?>">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>
</section>
