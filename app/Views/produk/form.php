<?php $edit = !empty($row); ?>
<section class="panel form-panel">
    <form method="post" action="<?= e(url('produk', $edit ? 'update' : 'store', $edit ? ['id' => (int) $row['idProduk']] : [])) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">

        <label for="jenis">Jenis</label>
        <input id="jenis" name="jenis" type="text" required maxlength="1" value="<?= e($row['jenis'] ?? '') ?>">

        <label for="namaProduk">Nama Produk</label>
        <input id="namaProduk" name="namaProduk" type="text" required maxlength="45" value="<?= e($row['namaProduk'] ?? '') ?>">

        <label for="idsatuan">Satuan</label>
        <select id="idsatuan" name="idsatuan" required>
            <option value="">-- Pilih Satuan --</option>
            <?php $selected = (string) ($row['idsatuan'] ?? ''); $found = false; ?>
            <?php foreach ($satuan as $s): ?>
                <?php $match = (string) $s['idsatuan'] === $selected; $found = $found || $match; ?>
                <option value="<?= e($s['idsatuan']) ?>" <?= $match ? 'selected' : '' ?>><?= e($s['SATUAN']) ?></option>
            <?php endforeach; ?>
            <?php if ($selected !== '' && !$found): ?>
                <option value="<?= e($selected) ?>" selected>Satuan saat ini (#<?= e($selected) ?>)</option>
            <?php endif; ?>
        </select>

        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="">-- Pilih Status --</option>
            <option value="1" <?= (string) ($row['status'] ?? '1') === '1' ? 'selected' : '' ?>>Aktif</option>
            <option value="0" <?= (string) ($row['status'] ?? '1') === '0' ? 'selected' : '' ?>>Tidak Aktif</option>
        </select>

        <label for="harga">Harga</label>
        <input id="harga" name="harga" type="number" required value="<?= e($row['harga'] ?? '') ?>">

        <div class="toolbar">
            <a href="<?= e(url('produk')) ?>">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>
</section>
