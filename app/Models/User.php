<?php

class User extends Model
{
    public function all(): array
    {
        return $this->read('SELECT * FROM `V_USER`');
    }

    public function find(int $id): ?array
    {
        foreach ($this->all() as $row) {
            if (isset($row['ID']) && (int) $row['ID'] === $id) {
                return $row;
            }
        }
        return null;
    }

    public function tambah($username, $password, $idrole): void
    {
        $this->call(
            'CALL sp_user_tambah(?, ?, ?)',
            'ssi',
            [$username, $password, $idrole]
        );
    }

    public function update($iduser, $username, $password, $idrole): void
    {
        $this->write(
            'UPDATE `USER` SET `username` = ?, `password` = ?, `idrole` = ? WHERE `iduser` = ?',
            'ssii',
            [$username, $password, $idrole, $iduser]
        );
    }

    public function hapus(int $id): void
    {
        $this->write('DELETE FROM `USER` WHERE `iduser` = ?', 'i', [$id]);
    }
}
