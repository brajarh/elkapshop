<?php

class Satuan extends Model
{
    public function all(): array
    {
        return $this->read('SELECT * FROM `V_satuan`');
    }

    public function aktif(): array
    {
        return $this->read('SELECT * FROM `v_satuan_aktif`');
    }

    // Disiapkan untuk integrasi SP; update dan hapus belum diaktifkan.

    public function tambah($idsatuan, $namaSatuan, $Status): void
    {
        $this->call(
            'CALL sp_satuan_tambah(?, ?, ?)',
            'isi',
            [$idsatuan, $namaSatuan, $Status]
        );
    }

    public function update($idsatuan, $namaSatuan, $Status): void
    {
        $this->call(
            'CALL sp_satuan_update(?, ?, ?)',
            'isi',
            [$idsatuan, $namaSatuan, $Status]
        );
    }

    public function hapus(int $id): void
    {
        $this->call(
            'CALL sp_satuan_hapus(?)',
            'i',
            [$id]
        );
    }
}
