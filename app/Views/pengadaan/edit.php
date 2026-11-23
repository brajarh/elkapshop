<section class="panel form-panel">
    <form method="post" action="<?= e(url('pengadaan', 'update', ['id' => (int) $row['idpengadaan']])) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
        <label for="iduser">ID User</label>
        <input id="iduser" name="iduser" type="number" min="1" required value="<?= e($row['user_iduser'] ?? $row['iduser'] ?? '') ?>">
        <label for="idvendor">ID Vendor</label>
        <input id="idvendor" name="idvendor" type="number" min="1" required value="<?= e($row['vendor_idvendor'] ?? $row['idvendor'] ?? '') ?>">
        <div class="toolbar">
            <a href="<?= e(url('pengadaan', 'show', ['id' => (int) $row['idpengadaan']])) ?>">Batal</a>
            <button type="submit">Simpan perubahan</button>
        </div>
    </form>
</section>
