<?php

require_once __DIR__ . '/../Models/Penjualan.php';
require_once __DIR__ . '/../Models/Produk.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/MarginPenjualan.php';

class PenjualanController extends Controller
{
    public function index(): void
    {
        $this->view('penjualan/index', [
            'title' => 'Penjualan',
            'rows' => (new Penjualan())->all()
        ]);
    }

    public function create(): void
    {
        $_SESSION['penjualan_nonce'] = bin2hex(random_bytes(32));
        $this->view('penjualan/form', [
            'title' => 'Buat Penjualan',
            'users' => (new User())->all(),
            'produks' => (new Produk())->aktif(),
            'margins' => (new MarginPenjualan())->aktif()
        ]);
    }

    public function show(): void
    {
        $id = $this->id();
        $model = new Penjualan();
        $row = $model->find($id);
        if (!$row) throw new RuntimeException('Penjualan tidak ditemukan.');
        $this->view('penjualan/show', [
            'title' => 'Detail Penjualan', 'row' => $row, 'details' => $model->detail($id)
        ]);
    }

    public function store(): void
    {
        $nonce = $_POST['nonce'] ?? null;
        if (!is_string($nonce) || !isset($_SESSION['penjualan_nonce']) || !hash_equals($_SESSION['penjualan_nonce'], $nonce)) {
            throw new RuntimeException('Form sudah digunakan atau kedaluwarsa. Buka form baru.');
        }
        $iduser = $this->post('iduser', 'i');
        if ($iduser <= 0 || !(new User())->find($iduser)) throw new InvalidArgumentException('User tidak valid.');
        $margins = (new MarginPenjualan())->aktif();
        if (count($margins) !== 1 || !is_numeric($margins[0]['persen']) || $margins[0]['persen'] < 0) {
            throw new RuntimeException('Harus ada tepat satu margin aktif yang valid.');
        }
        $ids = $_POST['idproduk'] ?? [];
        $qtys = $_POST['jumlah'] ?? [];
        if (!is_array($ids) || !is_array($qtys) || count($ids) !== count($qtys) || !$ids || count($ids) > 100 || array_keys($ids) !== array_keys($qtys)) {
            throw new InvalidArgumentException('Keranjang tidak valid.');
        }
        $cart = [];
        foreach ($ids as $k => $raw) {
            $id = is_string($raw) ? filter_var($raw, FILTER_VALIDATE_INT) : false;
            $qty = is_string($qtys[$k]) ? filter_var($qtys[$k], FILTER_VALIDATE_INT) : false;
            if (!$id || $id < 1 || !$qty || $qty < 1 || $qty > 2147483647) throw new InvalidArgumentException('Produk atau jumlah tidak valid.');
            $cart[$id] = ($cart[$id] ?? 0) + $qty;
        }
        $available = array_column((new Produk())->aktif(), null, 'idProduk');
        foreach ($cart as $id => $qty) {
            if (!isset($available[$id]) || $qty > (int) $available[$id]['stok_terkini'] || !is_numeric($available[$id]['harga']) || $available[$id]['harga'] < 0) {
                throw new RuntimeException('Produk tidak aktif, harga tidak valid, atau stok kurang: ID '.$id);
            }
        }
        // SP lama memiliki COMMIT sendiri. Jangan membungkus sebagai transaksi atomik semu.
        unset($_SESSION['penjualan_nonce']);
        $model = new Penjualan();
        $id = $model->tambah($iduser);
        try {
            foreach ($cart as $produk => $jumlah) $model->tambahDetail($id, $produk, $jumlah);
        } catch (Throwable $error) {
            throw new RuntimeException('Penjualan #'.$id.' mungkin tersimpan sebagian. Periksa database dan riwayat sebelum mencoba lagi. '.$error->getMessage(), 0, $error);
        }
        $_SESSION['flash'] = 'Penjualan berhasil disimpan.';
        header('Location: '.url('penjualan', 'show', ['id' => $id]));
        exit;
    }
}
