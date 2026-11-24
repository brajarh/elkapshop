<?php

require_once __DIR__ . '/../Models/Produk.php';
require_once __DIR__ . '/../Models/Satuan.php';

class ProdukController extends Controller
{
    private Produk $model;

    public function __construct()
    {
        $this->model = new Produk();
    }

    public function index(): void
    {
        $data = $this->model->all();

        $this->view('produk/index', [
            'title' => 'Produk',
            'rows' => $data,
            'aktif' => false
        ]);
    }

    public function aktif(): void
    {
        $data = $this->model->aktif();

        $this->view('produk/index', [
            'title' => 'Produk Aktif',
            'rows' => $data,
            'aktif' => true
        ]);
    }

   public function create(): void
{
    $satuan = new Satuan();

    $this->view('produk/form', [
        'title' => 'Tambah Produk',
        'row' => [],
        'satuan' => $satuan->aktif()
    ]);
}

    public function store(): void
{
    $status = $this->post('status', 'i');

    if ($status !== 0 && $status !== 1) {
        throw new InvalidArgumentException(
            'Status produk tidak valid.'
        );
    }

    $this->model->tambah(
        $this->post('jenis', 's', 1),
        $this->post('namaProduk', 's', 45),
        $this->post('idsatuan', 'i'),
        $status,
        $this->post('harga', 'i')
    );

    $this->redirect('produk');
}

    public function edit(): void
    {
        $id = $this->id();
        $row = $this->model->find($id);
        if (!$row) {
            throw new RuntimeException('Data tidak ditemukan.');
        }
        foreach (['jenis', 'namaProduk', 'idsatuan', 'status', 'harga'] as $key) {
            if (!array_key_exists($key, $row)) {
                throw new RuntimeException('Data tabel belum menyediakan kolom: ' . $key);
            }
        }
        $this->view('produk/form', [
            'title' => 'Edit Produk',
            'row' => $row,
            'satuan' => (new Satuan())->aktif()
        ]);
    }

    public function update(): void
    {
        $id = $this->id();
        if ($id <= 0 || !$this->model->find($id)) {
            throw new RuntimeException('Data tidak ditemukan.');
        }
        if (!in_array($this->post('status', 'i'), [0, 1], true)) {
            throw new InvalidArgumentException('Status tidak valid.');
        }
        $this->model->update(
            $id,
            $this->post('jenis', 's', 1),
            $this->post('namaProduk', 's', 45),
            $this->post('idsatuan', 'i'),
            $this->post('status', 'i'),
            $this->post('harga', 'i')
        );
        $this->redirect('produk');
    }

    public function delete(): void
    {
        $id = $this->id();
        if ($id <= 0 || !$this->model->find($id)) {
            throw new RuntimeException('Data tidak ditemukan.');
        }
        $this->model->hapus($id);
        $this->redirect('produk');
    }
}
