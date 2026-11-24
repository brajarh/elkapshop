<?php

require_once __DIR__ . '/../Models/MarginPenjualan.php';

class MarginPenjualanController extends Controller
{
    private MarginPenjualan $model;

    public function __construct()
    {
        $this->model = new MarginPenjualan();
    }

    public function index(): void
    {
        $data = $this->model->all();

        $this->view('margin-penjualan/index', [
            'title' => 'Margin Penjualan',
            'rows' => $data,
            'aktif' => false
        ]);
    }

    public function aktif(): void
    {
        $data = $this->model->aktif();

        $this->view('margin-penjualan/index', [
            'title' => 'Margin Penjualan Aktif',
            'rows' => $data,
            'aktif' => true
        ]);
    }

    public function create(): void
    {
        $this->view('margin-penjualan/form', [
            'title' => 'Tambah Margin Penjualan',
            'row' => []
        ]);
    }

    public function store(): void
    {
        $this->model->tambah(
            $this->post('idmargin_penjualan', 'i'),
            $this->post('created_at', 't'),
            $this->post('persen', 'd'),
            $this->post('status', 'i'),
            $this->post('iduser', 'i'),
            $this->post('updated_at', 't')
        );

        $this->redirect('margin-penjualan');
    }

    public function edit(): void
    {
        $id = $this->id();
        $row = $this->model->find($id);
        if (!$row) {
            throw new RuntimeException('Data tidak ditemukan.');
        }
        foreach (['created_at', 'persen', 'status', 'iduser', 'updated_at'] as $key) {
            if (!array_key_exists($key, $row)) {
                throw new RuntimeException('Data tabel belum menyediakan kolom: ' . $key);
            }
        }
        $this->view('margin-penjualan/form', [
            'title' => 'Edit MarginPenjualan',
            'row' => $row
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
            $this->post('created_at', 't'),
            $this->post('persen', 'd'),
            $this->post('status', 'i'),
            $this->post('iduser', 'i'),
            $this->post('updated_at', 't')
        );
        $this->redirect('margin-penjualan');
    }

    public function delete(): void
    {
        $id = $this->id();
        if ($id <= 0 || !$this->model->find($id)) {
            throw new RuntimeException('Data tidak ditemukan.');
        }
        $this->model->hapus($id);
        $this->redirect('margin-penjualan');
    }
}
