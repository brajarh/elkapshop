<?php

class Role extends Model
{
    public function all(): array
    {
        return $this->read('SELECT * FROM `v_role`');
    }

    public function find(int $id): ?array
    {
        foreach ($this->all() as $row) {
            if (isset($row['idrole']) && (int) $row['idrole'] === $id) {
                return $row;
            }
        }
        return null;
    }

    public function tambah($nama_role): void
    {
        $this->call(
            'CALL sp_role_tambah(?)',
            's',
            [$nama_role]
        );
    }

    public function update($idrole, $nama_role): void
    {
        $this->write(
            'UPDATE `ROLE` SET `nama_role` = ? WHERE `idrole` = ?',
            'si',
            [$nama_role, $idrole]
        );
    }

    public function hapus(int $id): void
    {
        $this->write('DELETE FROM `ROLE` WHERE `idrole` = ?', 'i', [$id]);
    }
}
