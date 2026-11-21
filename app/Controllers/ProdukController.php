<?php

require_once __DIR__ . '/../Models/Produk.php';

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
        $this->view('produk/form', [
            'title' => 'Tambah Produk',
            'row' => []
        ]);
    }

    public function store(): void
    {
        $this->model->tambah(
            $this->post('idProduk', 'i'),
            $this->post('jenis', 's', 1),
            $this->post('namaProduk', 's', 45),
            $this->post('idsatuan', 'i'),
            $this->post('status', 'i'),
            $this->post('harga', 'i')
        );

        $this->redirect('produk');
    }

    public function edit(): void
    {
        throw new RuntimeException(
            'Fitur edit belum tersedia: VIEW belum menyediakan seluruh data yang diperlukan.'
        );
    }

    public function update(): void
    {
        throw new RuntimeException(
            'Fitur update belum tersedia: VIEW belum menyediakan seluruh data yang diperlukan.'
        );
    }

    public function delete(): void
    {
        throw new RuntimeException(
            'Fitur delete belum tersedia: VIEW belum menyediakan seluruh data yang diperlukan.'
        );
    }
}
