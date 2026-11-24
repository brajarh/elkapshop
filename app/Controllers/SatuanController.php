<?php

require_once __DIR__ . '/../Models/Satuan.php';

class SatuanController extends Controller
{
    private Satuan $model;

    public function __construct()
    {
        $this->model = new Satuan();
    }

    public function index(): void
    {
        $data = $this->model->all();

        $this->view('satuan/index', [
            'title' => 'Satuan',
            'rows' => $data,
            'aktif' => false
        ]);
    }

    public function aktif(): void
    {
        $data = $this->model->aktif();

        $this->view('satuan/index', [
            'title' => 'Satuan Aktif',
            'rows' => $data,
            'aktif' => true
        ]);
    }

    public function create(): void
    {
        $this->view('satuan/form', [
            'title' => 'Tambah Satuan',
            'row' => []
        ]);
    }

    public function store(): void
    {
        $this->model->tambah(
            $this->post('namaSatuan', 's', 45),
            $this->post('Status', 'i')
        );

        $this->redirect('satuan');
    }

    public function edit(): void
    {
        $id = $this->id();
        $row = $this->model->find($id);
        if (!$row) {
            throw new RuntimeException('Data tidak ditemukan.');
        }
        foreach (['SATUAN', 'Status'] as $key) {
            if (!array_key_exists($key, $row)) {
                throw new RuntimeException('Data tabel belum menyediakan kolom: ' . $key);
            }
        }
        $this->view('satuan/form', [
            'title' => 'Edit Satuan',
            'row' => $row
        ]);
    }

    public function update(): void
    {
        $id = $this->id();
        if ($id <= 0 || !$this->model->find($id)) {
            throw new RuntimeException('Data tidak ditemukan.');
        }
        if (!in_array($this->post('Status', 'i'), [0, 1], true)) {
            throw new InvalidArgumentException('Status tidak valid.');
        }
        $this->model->update(
            $id,
            $this->post('namaSatuan', 's', 45),
            $this->post('Status', 'i')
        );
        $this->redirect('satuan');
    }

    public function delete(): void
    {
        $id = $this->id();
        if ($id <= 0 || !$this->model->find($id)) {
            throw new RuntimeException('Data tidak ditemukan.');
        }
        $this->model->hapus($id);
        $this->redirect('satuan');
    }
}
