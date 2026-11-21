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
