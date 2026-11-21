<?php

class Role extends Model
{
    public function all(): array
    {
        return $this->read('SELECT * FROM `v_role`');
    }

    // Disiapkan untuk integrasi SP; update dan hapus belum diaktifkan.

    public function tambah($idrole, $nama_role): void
    {
        $this->call(
            'CALL sp_role_tambah(?, ?)',
            'is',
            [$idrole, $nama_role]
        );
    }

    public function update($idrole, $nama_role): void
    {
        $this->call(
            'CALL sp_role_update(?, ?)',
            'is',
            [$idrole, $nama_role]
        );
    }

    public function hapus(int $id): void
    {
        $this->call(
            'CALL sp_role_hapus(?)',
            'i',
            [$id]
        );
    }
}
