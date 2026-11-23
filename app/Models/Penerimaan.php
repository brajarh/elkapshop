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

    private function lockDraft(int $id): array
    {
        $rows = $this->read('SELECT status, idpengadaan FROM PENERIMAAN WHERE idpenerimaan = ? FOR UPDATE', 'i', [$id]);
        if (!$rows || $rows[0]['status'] !== 'D') throw new RuntimeException('Hanya penerimaan Draft yang dapat diubah.');
        return $rows[0];
    }

    public function update(int $id, int $iduser): void
    {
        $this->atomic(function () use ($id, $iduser) {
            $this->lockDraft($id);
            $this->write('UPDATE PENERIMAAN SET iduser = ? WHERE idpenerimaan = ?', 'ii', [$iduser, $id]);
        });
    }

    public function hapus(int $id): void
    {
        $this->atomic(function () use ($id) {
            $this->lockDraft($id);
            $this->write('DELETE FROM detail_penerimaan WHERE idpenerimaan = ?', 'i', [$id]);
            $this->write('DELETE FROM PENERIMAAN WHERE idpenerimaan = ?', 'i', [$id]);
        });
    }

    public function updateDetail(int $id, int $detail, int $harga, int $jumlah): void
    {
        if ($harga < 0 || $jumlah <= 0) throw new InvalidArgumentException('Harga atau jumlah tidak valid.');
        $this->atomic(function () use ($id, $detail, $harga, $jumlah) {
            $header = $this->lockDraft($id);
            $pengadaan = (int) $header['idpengadaan'];
            $this->read('SELECT idpengadaan FROM PENGADAAN WHERE idpengadaan = ? FOR UPDATE', 'i', [$pengadaan]);
            $rows = $this->read('SELECT barang_idbarang FROM detail_penerimaan WHERE idpenerimaan = ? AND iddetail_penerimaan = ? FOR UPDATE', 'ii', [$id, $detail]);
            if (!$rows) throw new RuntimeException('Detail tidak ditemukan.');
            $produk = (int) $rows[0]['barang_idbarang'];
            $ordered = $this->read('SELECT jumlah FROM detail_pengadaan WHERE idpengadaan = ? AND idbarang = ? FOR UPDATE', 'ii', [$pengadaan, $produk]);
            $received = $this->read('SELECT d.jumlah_terima FROM detail_penerimaan d JOIN PENERIMAAN p ON p.idpenerimaan = d.idpenerimaan WHERE p.idpengadaan = ? AND d.barang_idbarang = ? AND d.iddetail_penerimaan <> ? FOR UPDATE', 'iii', [$pengadaan, $produk, $detail]);
            if ($jumlah + array_sum(array_column($received, 'jumlah_terima')) > array_sum(array_column($ordered, 'jumlah'))) throw new RuntimeException('Jumlah melebihi sisa pengadaan.');
            $this->write('UPDATE detail_penerimaan SET harga_satuan_terima = ?, jumlah_terima = ?, sub_total_terima = ? * ? WHERE idpenerimaan = ? AND iddetail_penerimaan = ?', 'iiiiii', [$harga, $jumlah, $harga, $jumlah, $id, $detail]);
        });
    }

    public function hapusDetail(int $id, int $detail): void
    {
        $this->atomic(function () use ($id, $detail) {
            $this->lockDraft($id);
            if (!$this->write('DELETE FROM detail_penerimaan WHERE idpenerimaan = ? AND iddetail_penerimaan = ?', 'ii', [$id, $detail])) throw new RuntimeException('Detail tidak ditemukan.');
        });
    }
}
