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

    public function find(int $id): ?array
    {
        foreach ($this->all() as $row) {
            if (isset($row['idmargin_penjualan']) && (int) $row['idmargin_penjualan'] === $id) {
                return $row;
            }
        }
        return null;
    }

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
        $this->write(
            'UPDATE `MARGIN_PENJUALAN` SET `created_at` = ?, `persen` = ?, `status` = ?, `iduser` = ?, `updated_at` = ? WHERE `idmargin_penjualan` = ?',
            'sdiisi',
            [$created_at, $persen, $status, $iduser, $updated_at, $idmargin_penjualan]
        );
    }

    public function hapus(int $id): void
    {
        $this->write('DELETE FROM `MARGIN_PENJUALAN` WHERE `idmargin_penjualan` = ?', 'i', [$id]);
    }
}
