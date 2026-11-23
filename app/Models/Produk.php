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

    public function find(int $id): ?array
    {
        foreach ($this->all() as $row) {
            if (isset($row['idProduk']) && (int) $row['idProduk'] === $id) {
                return $row;
            }
        }
        return null;
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
