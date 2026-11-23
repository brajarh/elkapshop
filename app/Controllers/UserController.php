<?php

require_once __DIR__ . '/../Models/User.php';

class UserController extends Controller
{
    private User $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index(): void
    {
        $data = $this->model->all();

        $this->view('user/index', [
            'title' => 'User',
            'rows' => $data,
            'aktif' => false
        ]);
    }

    public function create(): void
    {
        $this->view('user/form', [
            'title' => 'Tambah User',
            'row' => []
        ]);
    }

    public function store(): void
    {
        $this->model->tambah(
            $this->post('username', 's', 45),
            $this->post('password', 's', 100),
            $this->post('idrole', 'i')
        );

        $this->redirect('user');
    }

    public function edit(): void
    {
        $id = $this->id();
        $row = $this->model->find($id);
        if (!$row) {
            throw new RuntimeException('Data tidak ditemukan atau VIEW belum menyediakan ID.');
        }
        foreach (['USERNAME', 'idrole'] as $key) {
            if (!array_key_exists($key, $row)) {
                throw new RuntimeException('VIEW belum menyediakan kolom: ' . $key);
            }
        }
        $this->view('user/form', [
            'title' => 'Edit User',
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
            $this->post('username', 's', 45),
            $this->post('password', 's', 100),
            $this->post('idrole', 'i')
        );
        $this->redirect('user');
    }

    public function delete(): void
    {
        $id = $this->id();
        if ($id <= 0 || !$this->model->find($id)) {
            throw new RuntimeException('Data tidak ditemukan.');
        }
        $this->model->hapus($id);
        $this->redirect('user');
    }
}
