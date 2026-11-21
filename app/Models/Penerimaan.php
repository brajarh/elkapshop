<?php

class Penerimaan extends Model
{
    // Menampilkan seluruh penerimaan
    public function all(): array
    {
        return $this->read(
            'SELECT * FROM v_penerimaan'
        );
    }

    // Mengambil satu penerimaan
    public function find(int $id): ?array
    {
        $rows = $this->read(
            'SELECT * FROM v_penerimaan
             WHERE idpenerimaan = ?',
            'i',
            [$id]
        );

        return $rows[0] ?? null;
    }

    // Menampilkan detail produk yang diterima
    public function detail(int $id): array
    {
        return $this->read(
            'SELECT * FROM v_detail_penerimaan
             WHERE idpenerimaan = ?',
            'i',
            [$id]
        );
    }

    // Menampilkan pengadaan yang bisa dipilih
    public function daftarPengadaan(): array
    {
        return $this->read(
            "SELECT * FROM v_pengadaan
             WHERE status = 'S'"
        );
    }

    // Menampilkan pilihan produk dari pengadaan
    public function pilihanProduk(int $idpengadaan): array
    {
        return $this->read(
            'SELECT * FROM v_sisa_pengadaan
             WHERE idpengadaan = ?
               AND sisa_pengadaan > 0',
            'i',
            [$idpengadaan]
        );
    }

    // Membuat header penerimaan
    public function tambah(
        int $idpengadaan,
        int $iduser
    ): int {
        $stmt = $this->db->prepare(
            'CALL sp_penerimaan_tambah(?, ?)'
        );

        $stmt->bind_param(
            'ii',
            $idpengadaan,
            $iduser
        );

        try {
            $stmt->execute();

            $result = $stmt->get_result();

            if (!$result) {
                throw new RuntimeException(
                    'ID penerimaan tidak dikembalikan.'
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

            return (int) $row['idpenerimaan'];
        } finally {
            $stmt->close();
        }
    }

    // Menambahkan satu produk penerimaan
    public function tambahDetail(
        int $idpenerimaan,
        int $idproduk,
        int $jumlah,
        int $harga
    ): void {
        $this->call(
            'CALL sp_detail_penerimaan_tambah(
                ?, ?, ?, ?
            )',
            'iiii',
            [
                $idpenerimaan,
                $idproduk,
                $jumlah,
                $harga
            ]
        );
    }

    // Mengonfirmasi penerimaan
    public function simpan(int $idpenerimaan): void
    {
        $this->call(
            'CALL sp_penerimaan_simpan(?)',
            'i',
            [$idpenerimaan]
        );
    }
}
