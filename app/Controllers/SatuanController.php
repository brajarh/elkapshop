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
            $this->post('idsatuan', 'i'),
            $this->post('namaSatuan', 's', 45),
            $this->post('Status', 'i')
        );

        $this->redirect('satuan');
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
