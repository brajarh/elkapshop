<?php

class User extends Model
{
    public function all(): array
    {
        return $this->read('SELECT u.iduser AS ID, u.username AS USERNAME, u.idrole, r.nama_role AS ROLE FROM `USER` u LEFT JOIN `ROLE` r ON r.idrole = u.idrole ORDER BY u.iduser');
    }

    public function find(int $id): ?array
    {
        $rows = $this->read('SELECT iduser AS ID, username AS USERNAME, idrole FROM `USER` WHERE iduser = ?', 'i', [$id]);
        return $rows[0] ?? null;
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
