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

    private function lockDraft(int $id): void
    {
        $rows = $this->read('SELECT status FROM PENGADAAN WHERE idpengadaan = ? FOR UPDATE', 'i', [$id]);
        if (!$rows || $rows[0]['status'] !== 'D') {
            throw new RuntimeException('Hanya pengadaan Draft yang dapat diubah.');
        }
    }

    private function hitungUlang(int $id): void
    {
        $this->write('UPDATE PENGADAAN SET subtotal_nilai = (SELECT COALESCE(SUM(sub_total), 0) FROM detail_pengadaan WHERE idpengadaan = ?) WHERE idpengadaan = ?', 'ii', [$id, $id]);
        $this->write('UPDATE PENGADAAN SET ppn = hitung_ppn(subtotal_nilai) WHERE idpengadaan = ?', 'i', [$id]);
        $this->write('UPDATE PENGADAAN SET total_nilai = subtotal_nilai + ppn WHERE idpengadaan = ?', 'i', [$id]);
    }

    public function update(int $id, int $iduser, int $idvendor): void
    {
        $this->atomic(function () use ($id, $iduser, $idvendor) {
            $this->lockDraft($id);
            $this->write('UPDATE PENGADAAN SET user_iduser = ?, vendor_idvendor = ? WHERE idpengadaan = ?', 'iii', [$iduser, $idvendor, $id]);
        });
    }

    public function hapus(int $id): void
    {
        $this->atomic(function () use ($id) {
            $this->lockDraft($id);
            $this->write('DELETE FROM detail_pengadaan WHERE idpengadaan = ?', 'i', [$id]);
            $this->write('DELETE FROM PENGADAAN WHERE idpengadaan = ?', 'i', [$id]);
        });
    }

    public function updateDetail(int $id, int $detail, int $harga, int $jumlah): void
    {
        if ($harga < 0 || $jumlah <= 0) throw new InvalidArgumentException('Harga atau jumlah tidak valid.');
        $this->atomic(function () use ($id, $detail, $harga, $jumlah) {
            $this->lockDraft($id);
            $rows = $this->read('SELECT iddetail_pengadaan FROM detail_pengadaan WHERE idpengadaan = ? AND iddetail_pengadaan = ? FOR UPDATE', 'ii', [$id, $detail]);
            if (!$rows) throw new RuntimeException('Detail tidak ditemukan.');
            $this->write('UPDATE detail_pengadaan SET harga_satuan = ?, jumlah = ?, sub_total = ? * ? WHERE idpengadaan = ? AND iddetail_pengadaan = ?', 'iiiiii', [$harga, $jumlah, $harga, $jumlah, $id, $detail]);
            $this->hitungUlang($id);
        });
    }

    public function hapusDetail(int $id, int $detail): void
    {
        $this->atomic(function () use ($id, $detail) {
            $this->lockDraft($id);
            if (!$this->write('DELETE FROM detail_pengadaan WHERE idpengadaan = ? AND iddetail_pengadaan = ?', 'ii', [$id, $detail])) throw new RuntimeException('Detail tidak ditemukan.');
            $this->hitungUlang($id);
        });
    }
}
