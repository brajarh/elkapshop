<?php $edit = !empty($row); ?>
<section class="panel form-panel">
    <form method="post" action="<?= e(url('margin-penjualan', $edit ? 'update' : 'store', $edit ? ['id' => (int) $row['idmargin_penjualan']] : [])) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
        <?php if (!$edit): ?>
        <label for="idmargin_penjualan">ID Margin</label>
        <input id="idmargin_penjualan" name="idmargin_penjualan" type="number" required>
        <?php endif; ?>

        <label for="created_at">Dibuat</label>
        <input id="created_at" name="created_at" type="datetime-local" required value="<?= e(str_replace(' ', 'T', substr((string) ($row['created_at'] ?? ''), 0, 16))) ?>">

        <label for="persen">Persen</label>
        <input id="persen" name="persen" type="number" required step="any" value="<?= e($row['persen'] ?? '') ?>">

        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="">-- Pilih Status --</option>
            <option value="1" <?= (string) ($row['status'] ?? '1') === '1' ? 'selected' : '' ?>>Aktif</option>
            <option value="0" <?= (string) ($row['status'] ?? '1') === '0' ? 'selected' : '' ?>>Tidak Aktif</option>
        </select>

        <label for="iduser">ID User</label>
        <input id="iduser" name="iduser" type="number" required value="<?= e($row['iduser'] ?? '') ?>">

        <label for="updated_at">Diperbarui</label>
        <input id="updated_at" name="updated_at" type="datetime-local" required value="<?= e(str_replace(' ', 'T', substr((string) ($row['updated_at'] ?? ''), 0, 16))) ?>">

        <div class="toolbar">
            <a href="<?= e(url('margin-penjualan')) ?>">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>
</section>
