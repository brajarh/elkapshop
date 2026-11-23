<?php

require_once __DIR__ . '/../Models/Vendor.php';

class VendorController extends Controller
{
    private Vendor $model;

    public function __construct()
    {
        $this->model = new Vendor();
    }

    public function index(): void
    {
        $data = $this->model->all();

        $this->view('vendor/index', [
            'title' => 'Vendor',
            'rows' => $data,
            'aktif' => false
        ]);
    }

    public function aktif(): void
    {
        $data = $this->model->aktif();

        $this->view('vendor/index', [
            'title' => 'Vendor Aktif',
            'rows' => $data,
            'aktif' => true
        ]);
    }

    public function create(): void
    {
        $this->view('vendor/form', [
            'title' => 'Tambah Vendor',
            'row' => []
        ]);
    }

    public function store(): void
    {
        $this->model->tambah(
            $this->post('nama_vendor', 's', 100),
            $this->post('badan_hukum', 's', 1),
            $this->post('status', 's', 1)
        );

        $this->redirect('vendor');
    }

    public function edit(): void
    {
        $id = $this->id();
        $row = $this->model->find($id);
        if (!$row) {
            throw new RuntimeException('Data tidak ditemukan atau VIEW belum menyediakan ID.');
        }
        foreach (['nama_vendor', 'badan_hukum', 'status'] as $key) {
            if (!array_key_exists($key, $row)) {
                throw new RuntimeException('VIEW belum menyediakan kolom: ' . $key);
            }
        }
        $this->view('vendor/form', [
            'title' => 'Edit Vendor',
            'row' => $row
        ]);
    }

    public function update(): void
    {
        $id = $this->id();
        if ($id <= 0 || !$this->model->find($id)) {
            throw new RuntimeException('Data tidak ditemukan.');
        }
        if (!in_array($this->post('status', 's'), ['0', '1'], true)) {
            throw new InvalidArgumentException('Status tidak valid.');
        }
        $this->model->update(
            $id,
            $this->post('nama_vendor', 's', 100),
            $this->post('badan_hukum', 's', 1),
            $this->post('status', 's', 1)
        );
        $this->redirect('vendor');
    }

    public function delete(): void
    {
        $id = $this->id();
        if ($id <= 0 || !$this->model->find($id)) {
            throw new RuntimeException('Data tidak ditemukan.');
        }
        $this->model->hapus($id);
        $this->redirect('vendor');
    }
}
