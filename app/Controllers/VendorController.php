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
            $this->post('idvendor', 'i'),
            $this->post('nama_vendor', 's', 100),
            $this->post('badan_hukum', 's', 1),
            $this->post('status', 's', 1)
        );

        $this->redirect('vendor');
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
