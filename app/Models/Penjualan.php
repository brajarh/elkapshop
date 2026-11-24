<?php

class Penjualan extends Model
{
    public function all(): array
    {
        return $this->read('SELECT * FROM v_penjualan');
    }

    public function find(int $id): ?array
    {
        $rows = $this->read('SELECT * FROM v_penjualan WHERE idpenjualan = ?', 'i', [$id]);
        return $rows[0] ?? null;
    }

    public function detail(int $id): array
    {
        return $this->read('SELECT * FROM v_detail_penjualan WHERE penjualan_idpenjualan = ?', 'i', [$id]);
    }

    public function tambah(int $iduser): int
    {
        $stmt = $this->db->prepare('CALL sp_penjualan_tambah(?)');
        $stmt->bind_param('i', $iduser);
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result ? $result->fetch_assoc() : null;
            if ($result) $result->free();
            while ($stmt->more_results() && $stmt->next_result()) {
                $next = $stmt->get_result();
                if ($next) $next->free();
            }
            if (empty($row['idpenjualan'])) throw new RuntimeException('SP tidak mengembalikan ID penjualan.');
            return (int) $row['idpenjualan'];
        } finally {
            $stmt->close();
        }
    }

    public function tambahDetail(int $id, int $produk, int $jumlah): void
    {
        try {
            $this->call('CALL sp_detail_penjualan_tambah(?, ?, ?)', 'iii', [$id, $produk, $jumlah]);
        } catch (Throwable $error) {
            // Hanya membatalkan transaksi yang masih terbuka, bukan COMMIT SP sebelumnya.
            $this->db->rollback();
            throw $error;
        }
    }
}
