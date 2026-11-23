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

    public function find(int $id): ?array
    {
        foreach ($this->all() as $row) {
            if (isset($row['idsatuan']) && (int) $row['idsatuan'] === $id) {
                return $row;
            }
        }
        return null;
    }

    public function tambah($namaSatuan, $Status): void
    {
        $this->call(
            'CALL sp_satuan_tambah(?, ?)',
            'si',
            [$namaSatuan, $Status]
        );
    }

    public function update($idsatuan, $namaSatuan, $Status): void
    {
        $this->write(
            'UPDATE `SATUAN` SET `namaSatuan` = ?, `Status` = ? WHERE `idsatuan` = ?',
            'sii',
            [$namaSatuan, $Status, $idsatuan]
        );
    }

    public function hapus(int $id): void
    {
        $this->write('DELETE FROM `SATUAN` WHERE `idsatuan` = ?', 'i', [$id]);
    }
}
