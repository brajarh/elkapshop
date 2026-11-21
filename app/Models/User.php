<?php

class User extends Model
{
    public function all(): array
    {
        return $this->read('SELECT * FROM `V_USER`');
    }

    // Disiapkan untuk integrasi SP; update dan hapus belum diaktifkan.

    public function tambah($iduser, $username, $password, $idrole): void
    {
        $this->call(
            'CALL sp_user_tambah(?, ?, ?, ?)',
            'issi',
            [$iduser, $username, $password, $idrole]
        );
    }

    public function update($iduser, $username, $password, $idrole): void
    {
        $this->call(
            'CALL sp_user_update(?, ?, ?, ?)',
            'issi',
            [$iduser, $username, $password, $idrole]
        );
    }

    public function hapus(int $id): void
    {
        $this->call(
            'CALL sp_user_hapus(?)',
            'i',
            [$id]
        );
    }
}
