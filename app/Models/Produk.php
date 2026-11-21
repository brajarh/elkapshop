<?php

class Produk extends Model
{
    public function all(): array
    {
        return $this->read('SELECT * FROM `v_produk`');
    }

    public function aktif(): array
    {
        return $this->read('SELECT * FROM `v_produk_aktif`');
    }

    // Disiapkan untuk integrasi SP; update dan hapus belum diaktifkan.

    public function tambah($idProduk, $jenis, $namaProduk, $idsatuan, $status, $harga): void
    {
        $this->call(
            'CALL sp_produk_tambah(?, ?, ?, ?, ?, ?)',
            'issiii',
            [$idProduk, $jenis, $namaProduk, $idsatuan, $status, $harga]
        );
    }

    public function update($idProduk, $jenis, $namaProduk, $idsatuan, $status, $harga): void
    {
        $this->call(
            'CALL sp_produk_update(?, ?, ?, ?, ?, ?)',
            'issiii',
            [$idProduk, $jenis, $namaProduk, $idsatuan, $status, $harga]
        );
    }

    public function hapus(int $id): void
    {
        $this->call(
            'CALL sp_produk_hapus(?)',
            'i',
            [$id]
        );
    }
}
