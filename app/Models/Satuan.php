<?php

class Satuan extends Model
{
    public function all(): array
    {
        return $this->read('SELECT idsatuan, namaSatuan AS SATUAN, Status FROM SATUAN ORDER BY idsatuan');
    }

    public function aktif(): array
    {
        return $this->read('SELECT idsatuan, namaSatuan AS SATUAN, Status FROM SATUAN WHERE Status = 1 ORDER BY idsatuan');
    }

    public function find(int $id): ?array
    {
        $rows = $this->read('SELECT idsatuan, namaSatuan AS SATUAN, Status FROM SATUAN WHERE idsatuan = ?', 'i', [$id]);
        return $rows[0] ?? null;
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
