<?php
abstract class Model
{
    protected mysqli $db;
    public function __construct()
    {
        $this->db = dbconnection();
    }

    protected function read(string $sql, string $types = '', array $params = []): array
    {
        $stmt = $this->db->prepare($sql);
        if ($types !== '') {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $rows;
    }

    // Prepared statement untuk UPDATE dan DELETE langsung.
    protected function write(string $sql, string $types, array $params): int
    {
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            return $stmt->affected_rows;
        } finally {
            $stmt->close();
        }
    }

    protected function atomic(callable $operation): void
    {
        $this->db->begin_transaction();
        try {
            $operation();
            $this->db->commit();
        } catch (Throwable $e) {
            $this->db->rollback();
            throw $e;
        }
    }

    protected function call(string $sql, string $types, array $params): void
    {
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        try {
            $stmt->execute();
            do {
                $stmt->free_result();
            } while ($stmt->more_results() && $stmt->next_result());
        } finally {
            $stmt->close();
        }
    }
}
