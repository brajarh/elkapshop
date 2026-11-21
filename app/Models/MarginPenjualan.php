<?php

class MarginPenjualan extends Model
{
    public function all(): array
    {
        return $this->read('SELECT * FROM `v_margin`');
    }

    public function aktif(): array
    {
        return $this->read('SELECT * FROM `v_margin_aktif`');
    }

    // Disiapkan untuk integrasi SP; update dan hapus belum diaktifkan.

    public function tambah($idmargin_penjualan, $created_at, $persen, $status, $iduser, $updated_at): void
    {
        $this->call(
            'CALL sp_margin_penjualan_tambah(?, ?, ?, ?, ?, ?)',
            'isdiis',
            [$idmargin_penjualan, $created_at, $persen, $status, $iduser, $updated_at]
        );
    }

    public function update($idmargin_penjualan, $created_at, $persen, $status, $iduser, $updated_at): void
    {
        $this->call(
            'CALL sp_margin_penjualan_update(?, ?, ?, ?, ?, ?)',
            'isdiis',
            [$idmargin_penjualan, $created_at, $persen, $status, $iduser, $updated_at]
        );
    }

    public function hapus(int $id): void
    {
        $this->call(
            'CALL sp_margin_penjualan_hapus(?)',
            'i',
            [$id]
        );
    }
}
