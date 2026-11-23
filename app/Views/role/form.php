<?php $edit = !empty($row); ?>
<section class="panel form-panel">
    <form method="post" action="<?= e(url('role', $edit ? 'update' : 'store', $edit ? ['id' => (int) $row['idrole']] : [])) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">

        <label for="nama_role">Nama Role</label>
        <input id="nama_role" name="nama_role" type="text" required maxlength="100" value="<?= e($row['nama_role'] ?? '') ?>">

        <div class="toolbar">
            <a href="<?= e(url('role')) ?>">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>
</section>
