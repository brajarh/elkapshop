<section class="panel form-panel">
    <form method="post" action="<?= e(url('penerimaan', 'update', ['id' => (int) $row['idpenerimaan']])) ?>">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
        <label for="iduser">ID User</label>
        <input id="iduser" name="iduser" type="number" min="1" required value="<?= e($row['iduser'] ?? $row['iduser'] ?? '') ?>">
        <div class="toolbar">
            <a href="<?= e(url('penerimaan', 'show', ['id' => (int) $row['idpenerimaan']])) ?>">Batal</a>
            <button type="submit">Simpan perubahan</button>
        </div>
    </form>
</section>
