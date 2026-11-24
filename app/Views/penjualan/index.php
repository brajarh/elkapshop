<section class="panel">
    <div class="toolbar"><h2>Daftar Penjualan</h2><a class="btn" href="<?= e(url('penjualan','create')) ?>">+ Buat Penjualan</a></div>
    <div class="scroll"><table><thead><tr><th>ID</th><th>Waktu</th><th>User</th><th>Subtotal</th><th>PPN</th><th>Total</th><th>Aksi</th></tr></thead><tbody>
    <?php foreach ($rows as $row): ?><tr><td><?= e($row['idpenjualan']) ?></td><td><?= e($row['created_at']) ?></td><td><?= e($row['username']) ?></td><td>Rp <?= number_format((float)$row['subtotal_nilai'],0,',','.') ?></td><td>Rp <?= number_format((float)$row['ppn'],0,',','.') ?></td><td>Rp <?= number_format((float)$row['total_nilai'],0,',','.') ?></td><td><a class="btn secondary" href="<?= e(url('penjualan','show',['id'=>$row['idpenjualan']])) ?>">Detail</a></td></tr><?php endforeach; ?>
    <?php if (!$rows): ?><tr><td colspan="7">Belum ada penjualan.</td></tr><?php endif; ?>
    </tbody></table></div>
</section>
