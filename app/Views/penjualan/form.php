<?php $ready = count($margins) === 1 && is_numeric($margins[0]['persen']) && $margins[0]['persen'] >= 0; ?>
<section class="panel">
    <div class="toolbar"><h2>Buat Penjualan Baru</h2><a class="btn secondary" href="<?= e(url('penjualan')) ?>">Kembali</a></div>
    <?php if (!$ready): ?><p>Aktifkan tepat satu margin penjualan yang valid terlebih dahulu.</p><?php endif; ?>
    <form method="post" action="<?= e(url('penjualan', 'store')) ?>" id="pos-form">
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
        <input type="hidden" name="nonce" value="<?= e($_SESSION['penjualan_nonce']) ?>">
        <label for="iduser">User</label>
        <select name="iduser" id="iduser" required><option value="">-- Pilih User --</option>
            <?php foreach ($users as $u): ?><option value="<?= e($u['ID']) ?>"><?= e($u['USERNAME']) ?></option><?php endforeach; ?>
        </select>
        <p>Margin aktif: <strong><?= $ready ? e($margins[0]['persen']).'%' : 'Tidak tersedia' ?></strong></p>
        <div class="toolbar"><h2>Daftar Produk Penjualan</h2><button type="button" id="add-row" class="secondary">+ Tambah Produk</button></div>
        <div class="scroll"><table><thead><tr><th>Produk</th><th>Stok</th><th>Harga Satuan (estimasi)</th><th>Jumlah</th><th>Subtotal</th><th>Aksi</th></tr></thead><tbody id="cart-rows"></tbody></table></div>
        <template id="cart-row"><tr><td><select name="idproduk[]" required><option value="">-- Pilih Produk --</option>
            <?php foreach ($produks as $p): ?><option value="<?= e($p['idProduk']) ?>" data-price="<?= e($p['harga']) ?>" data-stock="<?= e($p['stok_terkini']) ?>" <?= (int)$p['stok_terkini'] <= 0 ? 'disabled' : '' ?>><?= e($p['namaProduk']) ?><?= (int)$p['stok_terkini'] <= 0 ? ' (stok habis)' : '' ?></option><?php endforeach; ?>
        </select></td><td class="stock">—</td><td class="price">—</td><td><input aria-label="Jumlah" type="number" name="jumlah[]" min="1" value="1" required></td><td class="subtotal">—</td><td><button type="button" class="danger remove">Hapus</button></td></tr></template>
        <section class="panel">
            <h2>Ringkasan Penjualan</h2>
            <p>Subtotal: <strong id="subtotal">Rp 0</strong></p>
            <p>PPN: <strong id="ppn">Rp 0</strong></p>
            <h3>Total (estimasi): <span id="total">Rp 0</span></h3>
            <p id="cart-warning" role="status"></p>
        </section>
        <div class="toolbar"><a href="<?= e(url('penjualan')) ?>">Batal</a><button id="checkout" type="submit" <?= !$ready ? 'disabled' : '' ?>>Simpan Penjualan</button></div>
    </form>
</section>
<script>
(() => {
 const rows = document.getElementById('cart-rows'), template = document.getElementById('cart-row');
 const ready = <?= $ready ? 'true' : 'false' ?>, margin = <?= json_encode($ready ? (float)$margins[0]['persen'] : 0) ?>;
 const money = n => 'Rp ' + n.toLocaleString('id-ID');
 function recalc() {
   let subtotal = 0, valid = ready && rows.children.length > 0, warning = '', quantities = new Map();
   for (const row of rows.children) {
     const choice = row.querySelector('select'), opt = choice.selectedOptions[0], qty = Number(row.querySelector('input').value);
     const stock = Number(opt.dataset.stock), price = Math.round(Number(opt.dataset.price)*(1+margin/100));
     if (!choice.value || !Number.isInteger(qty) || qty < 1 || !Number.isFinite(price)) { valid = false; row.querySelector('.stock').textContent = '—'; row.querySelector('.price').textContent = '—'; row.querySelector('.subtotal').textContent = '—'; continue; }
     const cumulative = (quantities.get(choice.value)||0)+qty; quantities.set(choice.value,cumulative);
     if (cumulative > stock) { valid = false; warning = 'Jumlah pembelian melebihi stok.'; }
     row.querySelector('.stock').textContent = stock; row.querySelector('.price').textContent = money(price); row.querySelector('.subtotal').textContent = money(price*qty); subtotal += price*qty;
   }
   const ppn = Math.round(subtotal*0.11);
   document.getElementById('subtotal').textContent = money(subtotal); document.getElementById('ppn').textContent = money(ppn); document.getElementById('total').textContent = money(subtotal+ppn);
   document.getElementById('cart-warning').textContent = warning; document.getElementById('checkout').disabled = !valid;
 }
 function add() { if (rows.children.length >= 100) return; rows.append(template.content.cloneNode(true)); recalc(); }
 document.getElementById('add-row').addEventListener('click',add); rows.addEventListener('input',recalc); rows.addEventListener('change',recalc);
 rows.addEventListener('click', e => { if(e.target.classList.contains('remove')) { e.target.closest('tr').remove(); recalc(); }});
 document.getElementById('pos-form').addEventListener('submit',e=>{if(!confirm('Yakin ingin menyimpan penjualan?')) e.preventDefault(); else document.getElementById('checkout').disabled=true;}); add();
})();
</script>
