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
            $this->post('iduser', 'i'),
            $this->post('username', 's', 45),
            $this->post('password', 's', 100),
            $this->post('idrole', 'i')
        );

        $this->redirect('user');
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
