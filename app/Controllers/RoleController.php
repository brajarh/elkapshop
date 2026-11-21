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
            $this->post('idrole', 'i'),
            $this->post('nama_role', 's', 100)
        );

        $this->redirect('role');
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
