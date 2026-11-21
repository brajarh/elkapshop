<?php
function e($value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}
function url(string $page, string $action = 'index', array $extra = []): string
{
    return 'index.php?' . http_build_query(['page'=>$page,'action'=>$action] + $extra);
}
abstract class Controller
{
    protected function view(string $file, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        require __DIR__.'/../app/Views/layouts/header.php';
        require __DIR__.'/../app/Views/'.$file.'.php';
        require __DIR__.'/../app/Views/layouts/footer.php';
    }
    protected function redirect(string $page): void
    {
        $_SESSION['flash'] = 'Operasi berhasil.';
        header('Location: '.url($page));
        exit;
    }
    protected function id(): int
    {
        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
        if ($id === false) {
            throw new InvalidArgumentException('ID tidak valid.');
        }
        return $id;
    }
    protected function post(string $key, string $type, ?int $max = null)
    {
        $value = $_POST[$key] ?? null;
        if (!is_string($value) || trim($value) === '') {
            throw new InvalidArgumentException('Isi kolom '.$key.'.');
        }
        if ($type === 'i' || $type === 'd') {
            $n = filter_var($value, $type === 'i' ? FILTER_VALIDATE_INT : FILTER_VALIDATE_FLOAT);
            if ($n === false) {
                throw new InvalidArgumentException('Angka tidak valid: '.$key);
            }
            return $n;
        }
        if ($type === 't') {
            $date = DateTime::createFromFormat('!Y-m-d\TH:i', $value);
            if (!$date || $date->format('Y-m-d\TH:i') !== $value) {
                throw new InvalidArgumentException('Tanggal tidak valid: '.$key);
            }
            return $date->format('Y-m-d H:i:s');
        }
        if ($max !== null && strlen($value) > $max) {
            throw new InvalidArgumentException('Kolom terlalu panjang: '.$key);
        }
        return $value;
    }
}
