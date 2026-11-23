# Integrasi Edit dan Hapus — Elkapshop 2.0

Kode PHP berdasarkan ZIP terbaru elkapshop 2.0 2.zip. AUTO_INCREMENT lima master dan dropdown produk dipertahankan; dropdown pengadaan ditambahkan. Query UPDATE/DELETE langsung di PHP atas permintaan pengguna. Pastikan diizinkan dosen. Paket belum diuji dengan MySQL aktual. Dropdown membutuhkan v_satuan_aktif (idsatuan, SATUAN), V_USER (ID, USERNAME), v_vendor_aktif (idvendor, nama_vendor), dan v_produk_aktif (idProduk, namaProduk).

## Modul master

Controller edit/update/delete diaktifkan, form tambah dipakai ulang untuk edit, ID diambil dari URL untuk update/delete, POST + CSRF dipakai untuk perubahan. Model find() menggunakan hasil all() yang sudah ada; tidak menambah query SELECT baru. Tombol tidak muncul bila VIEW tidak menyediakan ID; form edit menolak jika kolom wajib belum tersedia. Pada USER, password lama tidak dibaca/ditampilkan; edit saat ini meminta password baru sesuai kontrak SP lama. Gunakan hanya data dummy pada demo; proyek asal belum memiliki autentikasi/otorisasi.

VIEW semua data perlu menyediakan kolom berikut (di samping kolom tampilan yang sudah ada):

| VIEW | Kolom untuk CRUD |
|---|---|
| v_produk | idProduk, jenis, namaProduk, idsatuan, status, harga |
| V_satuan | idsatuan, SATUAN, Status |
| V_VENDOR | idvendor, nama_vendor, badan_hukum, status |
| V_USER | ID (iduser), USERNAME, idrole (bukan password) |
| v_role | idrole, nama_role |
| v_margin | idmargin_penjualan, created_at, persen, status, iduser, updated_at |

VIEW aktif juga memerlukan ID sesuai modul agar aksi muncul. Nama key PHP case-sensitive. Pastikan V_USER menampilkan ID user yang benar. UPDATE dan DELETE sekarang menggunakan prepared statement MySQLi langsung pada Model; SP tambah dan konfirmasi tetap dipakai. Tidak perlu membuat SP update/hapus. Foreign key tetap aktif. Untuk master yang sudah digunakan transaksi, gunakan status nonaktif jika tersedia.

## Transaksi

Pengadaan dan penerimaan hanya dapat diubah pada status D. Model memakai transaksi InnoDB dan SELECT FOR UPDATE pada header, serta rollback jika gagal. Detail pengadaan dihitung ulang dengan fungsi hitung_ppn yang terdapat pada file SQL awal; pastikan fungsi dan aturan PPN aktual sesuai. Detail penerimaan menghitung subtotal dan membatasi jumlah berdasarkan pesanan dikurangi semua detail penerimaan lain (termasuk Draft). Pastikan aturan ini sesuai dengan VIEW dan SP penerimaan aktual. Uji interaksi dengan trigger/SP yang ada; tidak diketahui apakah semuanya memakai penguncian yang konsisten.

PENJUALAN, detail_penjualan, RETUR, detail_retur dan KARTU_STOK belum memiliki modul pada ZIP sumber; tidak ditambahkan. Jangan edit stok langsung.

## Testing

1. Backup database dan gunakan data uji. Pastikan VIEW, SP tambah/konfirmasi dan fungsi hitung_ppn tersedia; jangan mengaktifkan penggunaan di produksi.
2. Jalankan php -S localhost:8000 -t public.
3. Tambah, edit, hapus data master yang belum direferensikan; cek ID tetap sama saat edit. Coba hapus master yang digunakan transaksi: harus ditolak oleh database.
4. Edit/hapus detail/header Draft; periksa total dan sisa pengadaan. Uji bahwa transaksi Pending/Selesai ditolak, termasuk POST secara manual. Uji CSRF tidak valid.
5. Uji kembali tambah data lima master, lalu alur pengadaan dan penerimaan yang lama.
