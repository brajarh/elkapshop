# Modul Penjualan Elkap

Database tetap `elkap`. Tidak ada file SQL atau konfigurasi database yang diubah.

Buka `index.php?page=penjualan&action=create` atau menu Kasir Penjualan.

## File baru
- app/Models/Penjualan.php
- app/Controllers/PenjualanController.php
- app/Views/penjualan/form.php
- app/Views/penjualan/index.php
- app/Views/penjualan/show.php

## File yang disesuaikan
- routes/web.php
- public/index.php
- app/Views/layouts/header.php

## Prasyarat MySQL
- sp_penjualan_tambah(IN p_iduser INT), mengembalikan idpenjualan
- sp_detail_penjualan_tambah(IN p_idpenjualan INT, IN p_idproduk INT, IN p_jumlah INT)
- fn_harga_jual, fn_subtotal_detail_penjualan, fn_subtotal_penjualan, hitung_ppn
- trg_penjualan_stok_keluar
- tepat satu margin aktif, produk aktif, stok dan user tersedia
- v_penjualan dan v_detail_penjualan untuk halaman riwayat/detail (sesuai definisi yang dibahas sebelumnya)

Estimasi harga/PPN di halaman kasir bukan nilai final; SP menghitung ulang harga dan pajak. PPN pratinjau diasumsikan 11% seperti fungsi lama. Validasi PHP tidak menjamin stok aman dalam transaksi bersamaan. SP lama masing-masing melakukan COMMIT; jika detail gagal, header atau detail sebelumnya mungkin sudah tersimpan. Jangan ulangi transaksi tanpa memeriksa database. Gunakan hanya untuk pengujian hingga transaksi atomik dan validasi stok di database diperbaiki. Tidak ada fitur edit/hapus penjualan yang sudah tercatat karena akan memengaruhi kartu stok.
