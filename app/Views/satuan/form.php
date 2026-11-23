<?php $edit = !empty($row); ?>
<section class="panel form-panel">
    <form method="post" action="<?= e(url('satuan', $edit ? 'update' : 'store', $edit ? ['id' => (int) $row['idsatuan']] : [])) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">

        <label for="namaSatuan">Nama Satuan</label>
        <input id="namaSatuan" name="namaSatuan" type="text" required maxlength="45" value="<?= e($row['SATUAN'] ?? '') ?>">

        <label for="Status">Status</label>
        <select id="Status" name="Status" required>
            <option value="">-- Pilih Status --</option>
            <option value="1" <?= (string) ($row['Status'] ?? '1') === '1' ? 'selected' : '' ?>>Aktif</option>
            <option value="0" <?= (string) ($row['Status'] ?? '1') === '0' ? 'selected' : '' ?>>Tidak Aktif</option>
        </select>

        <div class="toolbar">
            <a href="<?= e(url('satuan')) ?>">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>
</section>
