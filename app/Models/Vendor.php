<?php

class Vendor extends Model
{
    public function all(): array
    {
        return $this->read('SELECT * FROM `V_VENDOR`');
    }

    public function aktif(): array
    {
        return $this->read('SELECT * FROM `v_vendor_aktif`');
    }

    // Disiapkan untuk integrasi SP; update dan hapus belum diaktifkan.

    public function tambah($idvendor, $nama_vendor, $badan_hukum, $status): void
    {
        $this->call(
            'CALL sp_vendor_tambah(?, ?, ?, ?)',
            'isss',
            [$idvendor, $nama_vendor, $badan_hukum, $status]
        );
    }

    public function update($idvendor, $nama_vendor, $badan_hukum, $status): void
    {
        $this->call(
            'CALL sp_vendor_update(?, ?, ?, ?)',
            'isss',
            [$idvendor, $nama_vendor, $badan_hukum, $status]
        );
    }

    public function hapus(int $id): void
    {
        $this->call(
            'CALL sp_vendor_hapus(?)',
            'i',
            [$id]
        );
    }
}
