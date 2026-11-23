<?php

require_once __DIR__ . '/../Models/Role.php';

class RoleController extends Controller
{
    private Role $model;

    public function __construct()
    {
        $this->model = new Role();
    }

    public function index(): void
    {
        $data = $this->model->all();

        $this->view('role/index', [
            'title' => 'Role',
            'rows' => $data,
            'aktif' => false
        ]);
    }

    public function create(): void
    {
        $this->view('role/form', [
            'title' => 'Tambah Role',
            'row' => []
        ]);
    }

    public function store(): void
    {
        $this->model->tambah(
            $this->post('nama_role', 's', 100)
        );

        $this->redirect('role');
    }

    public function edit(): void
    {
        $id = $this->id();
        $row = $this->model->find($id);
        if (!$row) {
            throw new RuntimeException('Data tidak ditemukan atau VIEW belum menyediakan ID.');
        }
        foreach (['nama_role'] as $key) {
            if (!array_key_exists($key, $row)) {
                throw new RuntimeException('VIEW belum menyediakan kolom: ' . $key);
            }
        }
        $this->view('role/form', [
            'title' => 'Edit Role',
            'row' => $row
        ]);
    }

    public function update(): void
    {
        $id = $this->id();
        if ($id <= 0 || !$this->model->find($id)) {
            throw new RuntimeException('Data tidak ditemukan.');
        }
        $this->model->update(
            $id,
            $this->post('nama_role', 's', 100)
        );
        $this->redirect('role');
    }

    public function delete(): void
    {
        $id = $this->id();
        if ($id <= 0 || !$this->model->find($id)) {
            throw new RuntimeException('Data tidak ditemukan.');
        }
        $this->model->hapus($id);
        $this->redirect('role');
    }
}
