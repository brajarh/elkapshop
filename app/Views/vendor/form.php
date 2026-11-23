<?php $edit = !empty($row); ?>
<section class="panel form-panel">
    <form method="post" action="<?= e(url('vendor', $edit ? 'update' : 'store', $edit ? ['id' => (int) $row['idvendor']] : [])) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">

        <label for="nama_vendor">Nama Vendor</label>
        <input id="nama_vendor" name="nama_vendor" type="text" required maxlength="100" value="<?= e($row['nama_vendor'] ?? '') ?>">

        <label for="badan_hukum">Badan Hukum</label>
        <input id="badan_hukum" name="badan_hukum" type="text" required maxlength="1" value="<?= e($row['badan_hukum'] ?? '') ?>">

        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="">-- Pilih Status --</option>
            <option value="1" <?= (string) ($row['status'] ?? '1') === '1' ? 'selected' : '' ?>>Aktif</option>
            <option value="0" <?= (string) ($row['status'] ?? '1') === '0' ? 'selected' : '' ?>>Tidak Aktif</option>
        </select>

        <div class="toolbar">
            <a href="<?= e(url('vendor')) ?>">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>
</section>
