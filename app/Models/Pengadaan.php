<?php

class Pengadaan extends Model
{
    // Menampilkan semua pengadaan
    public function all(): array
    {
        return $this->read(
            'SELECT * FROM v_pengadaan'
        );
    }

    // Mengambil satu pengadaan
    public function find(int $id): ?array
    {
        $rows = $this->read(
            'SELECT * FROM v_pengadaan
             WHERE idpengadaan = ?',
            'i',
            [$id]
        );

        return $rows[0] ?? null;
    }

    // Menampilkan produk dalam satu pengadaan
    public function detail(int $id): array
    {
        return $this->read(
            'SELECT * FROM v_detail_pengadaan
             WHERE idpengadaan = ?',
            'i',
            [$id]
        );
    }

    // Memanggil SP pertama
    public function tambah(
        int $iduser,
        int $idvendor
    ): int {
        $stmt = $this->db->prepare(
            'CALL sp_pengadaan_tambah(?, ?)'
        );

        $stmt->bind_param(
            'ii',
            $iduser,
            $idvendor
        );

        try {
            $stmt->execute();

            $result = $stmt->get_result();

            if (!$result) {
                throw new RuntimeException(
                    'SP tidak mengembalikan ID pengadaan.'
                );
            }

            $row = $result->fetch_assoc();
            $result->free();

            while ($stmt->more_results()) {
                $stmt->next_result();

                $next = $stmt->get_result();

                if ($next) {
                    $next->free();
                }
            }

            if (!isset($row['idpengadaan'])) {
                throw new RuntimeException(
                    'ID pengadaan tidak ditemukan.'
                );
            }

            return (int) $row['idpengadaan'];
        } finally {
            $stmt->close();
        }
    }

    // Memanggil SP kedua
    public function tambahDetail(
        int $idpengadaan,
        int $idproduk,
        int $harga,
        int $jumlah
    ): void {
        $this->call(
            'CALL sp_detail_pengadaan_tambah(
                ?, ?, ?, ?
            )',
            'iiii',
            [
                $idpengadaan,
                $idproduk,
                $harga,
                $jumlah
            ]
        );
    }

    // Memanggil SP ketiga
    public function simpan(int $idpengadaan): void
    {
        $this->call(
            'CALL sp_pengadaan_simpan(?)',
            'i',
            [$idpengadaan]
        );
    }
}
