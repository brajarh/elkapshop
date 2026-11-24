# Elkapshop 2.0 — CRUD tabel langsung

Berdasarkan paket CRUD Langsung PHP sebelumnya. Modul master Produk, Vendor, User, Role, Satuan, Margin Penjualan membaca tabel asli untuk daftar, filter aktif, dan pencarian ID edit/hapus. Produk memakai LEFT JOIN SATUAN dan stok dari baris KARTU_STOK terakhir berdasarkan created_at dan idkartu_stok (0 jika belum ada riwayat). User memakai LEFT JOIN ROLE dengan idrole yang benar dan tidak membaca password. Alias hasil pembacaan dipertahankan agar form dan dropdown lama tetap berfungsi. Tidak perlu mengubah VIEW master. SELECT, UPDATE dan DELETE langsung di PHP; INSERT tetap SP. Pastikan aturan dosen memperbolehkan SQL ini.

SP tambah: sp_produk_tambah (5 parameter), sp_vendor_tambah (3), sp_user_tambah (3), sp_role_tambah (1), sp_satuan_tambah (2), sp_margin_penjualan_tambah (6, ID manual). Tidak ada perubahan skema database atau data.

Pengadaan/Penerimaan dan VIEW transaksi tetap sebagaimana paket sebelumnya. Edit/hapus transaksi hanya pada status D. Pastikan SP, VIEW transaksi, fungsi hitung_ppn dan trigger aktual sesuai; uji konsistensi stok dan total. Penjualan dan Retur belum tersedia; kartu stok tidak diedit langsung.

Gunakan data dummy pada aplikasi lokal tanpa autentikasi. User edit meminta password baru; password lama tidak ditampilkan. Foreign key tetap aktif; penghapusan data yang direferensikan dapat ditolak.

## Instalasi
Salin app, core, public, routes dan README ke direktori lama dengan merge file; pertahankan .git, konfigurasi database lokal dan file lokal lainnya. Jalankan php -S localhost:8000 -t public. Uji semua daftar, filter, form edit, update, hapus data dummy tanpa referensi, tambah dan dropdown; uji juga transaksi Draft. Sintaks PHP diperiksa, integrasi MySQL aktual belum diuji.
