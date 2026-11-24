<?php

class Produk extends Model
{
    public function all(): array
    {
        return $this->read('SELECT p.*, s.namaSatuan, COALESCE((SELECT k.stock FROM KARTU_STOK k WHERE k.idproduk = p.idProduk ORDER BY k.created_at DESC, k.idkartu_stok DESC LIMIT 1), 0) AS stok_terkini FROM PRODUK p LEFT JOIN SATUAN s ON s.idsatuan = p.idsatuan ORDER BY p.idProduk');
    }

    public function aktif(): array
    {
        return $this->read('SELECT p.*, s.namaSatuan, COALESCE((SELECT k.stock FROM KARTU_STOK k WHERE k.idproduk = p.idProduk ORDER BY k.created_at DESC, k.idkartu_stok DESC LIMIT 1), 0) AS stok_terkini FROM PRODUK p LEFT JOIN SATUAN s ON s.idsatuan = p.idsatuan WHERE p.status = 1 ORDER BY p.idProduk');
    }

    public function find(int $id): ?array
    {
        $rows = $this->read('SELECT * FROM PRODUK WHERE idProduk = ?', 'i', [$id]);
        return $rows[0] ?? null;
    }

    public function tambah($jenis, $namaProduk, $idsatuan, $status, $harga): void
    {
        $this->call(
            'CALL sp_produk_tambah(?, ?, ?, ?, ?)',
            'ssiii',
            [$jenis, $namaProduk, $idsatuan, $status, $harga]
        );
    }

    public function update($idProduk, $jenis, $namaProduk, $idsatuan, $status, $harga): void
    {
        $this->write(
            'UPDATE `PRODUK` SET `jenis` = ?, `namaProduk` = ?, `idsatuan` = ?, `status` = ?, `harga` = ? WHERE `idProduk` = ?',
            'ssiiii',
            [$jenis, $namaProduk, $idsatuan, $status, $harga, $idProduk]
        );
    }

    public function hapus(int $id): void
    {
        $this->write('DELETE FROM `PRODUK` WHERE `idProduk` = ?', 'i', [$id]);
    }
}
