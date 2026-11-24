<?php

class Vendor extends Model
{
    public function all(): array
    {
        return $this->read('SELECT * FROM VENDOR ORDER BY idvendor');
    }

    public function aktif(): array
    {
        return $this->read('SELECT * FROM VENDOR WHERE status = \'1\' ORDER BY idvendor');
    }

    public function find(int $id): ?array
    {
        $rows = $this->read('SELECT * FROM VENDOR WHERE idvendor = ?', 'i', [$id]);
        return $rows[0] ?? null;
    }

    public function tambah($nama_vendor, $badan_hukum, $status): void
    {
        $this->call(
            'CALL sp_vendor_tambah(?, ?, ?)',
            'sss',
            [$nama_vendor, $badan_hukum, $status]
        );
    }

    public function update($idvendor, $nama_vendor, $badan_hukum, $status): void
    {
        $this->write(
            'UPDATE `VENDOR` SET `nama_vendor` = ?, `badan_hukum` = ?, `status` = ? WHERE `idvendor` = ?',
            'sssi',
            [$nama_vendor, $badan_hukum, $status, $idvendor]
        );
    }

    public function hapus(int $id): void
    {
        $this->write('DELETE FROM `VENDOR` WHERE `idvendor` = ?', 'i', [$id]);
    }
}
