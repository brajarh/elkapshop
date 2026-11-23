> Untuk perubahan terbaru, baca README_CRUD.md; catatan di bawah menggambarkan versi awal.
# Elkap Barbershop — PHP Native MVC (revisi VIEW)

Proyek praktikum lokal, enam modul master terpisah, tanpa transaksi atau login.

## Menjalankan

1. Ekstrak ZIP ke folder baru. Buka folder elkap-app di VS Code.
2. Pastikan PHP 8.1+ dengan mysqli dan mysqlnd, serta MySQL berjalan.
3. Database elkap harus berisi VIEW yang kamu buat. Jangan impor seluruh catatan SQL eksperimen tanpa memeriksanya.
4. Jalankan `php -S localhost:8000 -t public` dari folder elkap-app.
5. Buka http://localhost:8000. Jika server lama masih berjalan, hentikan dulu dengan Ctrl+C.

Koneksi menggunakan 127.0.0.1, port 3306, root, password kosong, database elkap. Ini mengikuti perbaikan koneksi TCP sebelumnya. Tidak perlu mengubah PHP jika konfigurasi lokal sama.

## VIEW yang dibaca

| Modul | Semua data | Data aktif | Kolom tampilan |
|---|---|---|---|
| Produk | v_produk | v_produk_aktif | namaProduk, jenis, namaSatuan, harga |
| Satuan | V_satuan | v_satuan_aktif | SATUAN, Status |
| Vendor | V_VENDOR | v_vendor_aktif | nama_vendor, badan_hukum, status |
| User | V_USER | — | ID, USERNAME, ROLE |
| Role | v_role | — | nama_role |
| Margin Penjualan | v_margin | v_margin_aktif | persen, status |

Kapitalisasi mengikuti definisi terbaru pengguna. VIEW aktif juga mengembalikan ID, tetapi daftar menampilkan kolom yang konsisten dengan daftar semua data. Tidak ada filter ulang PHP. JOIN USER tidak diubah. Perintah DROP VIEW v_satuan dalam catatan terbaru dapat menghapus VIEW yang dibutuhkan; pastikan V_satuan masih tersedia. Jika tidak, buat kembali sendiri menggunakan definisimu. Tidak ada fallback ke tabel atau VIEW lain.

## Alur MVC

`public/index.php` menerima page/action, `routes/web.php` memetakan Controller.
`index()` memanggil Model `all()`, sedangkan `aktif()` memanggil Model `aktif()`.
Model membaca VIEW melalui `core/Model.php`, yang mengembalikan associative array.
Controller meneruskan data sebagai `rows` dan mode tampilan sebagai `aktif`.
`core/Controller.php` menggunakan extract dan require untuk memuat View PHP.
Setiap modul memiliki Model, Controller, index.php dan form.php tersendiri.

## Stored Procedure

Form Tambah tetap tersedia seperti modul Produk sebelumnya; simpan memakai POST dan CSRF. Edit dan Hapus sementara dinonaktifkan pada semua modul karena kontrak VIEW belum lengkap untuk CRUD. Method SP update/hapus tetap disimpan di Model untuk pengembangan berikutnya, tidak dipanggil oleh Controller.

| SP tambah (dan kontrak update sementara) | Parameter berurutan |
|---|---|
| sp_produk_tambah | idProduk, jenis, namaProduk, idsatuan, status, harga |
| sp_satuan_tambah | idsatuan, namaSatuan, Status |
| sp_vendor_tambah | idvendor, nama_vendor, badan_hukum, status |
| sp_user_tambah | iduser, username, password, idrole |
| sp_role_tambah | idrole, nama_role |
| sp_margin_penjualan_tambah | idmargin_penjualan, created_at, persen, status, iduser, updated_at |

SP update memakai suffix _update dan parameter yang sama; SP hapus memakai suffix _hapus serta satu ID. Kontrak selain sp_produk_tambah belum diverifikasi pada database nyata. ID dan foreign key serta timestamp margin diisi manual. Status mengikuti nilai database. Password tidak ditampilkan dan diteruskan ke SP sesuai kontrak sebelumnya; jangan gunakan password nyata. Tidak ada SQL DDL baru, INSERT/UPDATE/DELETE langsung, ataupun fallback. Error database ditampilkan. Jangan gunakan aplikasi tanpa autentikasi ini di internet.

## Pengujian

Sintaks PHP dan rendering dengan data simulasi diuji. Integrasi MySQL asli belum diuji karena ekstensi mysqli dan server tidak tersedia di lingkungan pembuatan. Pastikan semua VIEW ada dan SP tambah sesuai kontrak sebelum menyimpan data.
