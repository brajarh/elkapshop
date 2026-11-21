<?php

require_once __DIR__ . '/../Models/Pengadaan.php';

class PengadaanController extends Controller
{
    private Pengadaan $model;

    public function __construct()
    {
        $this->model = new Pengadaan();
    }

    // Halaman daftar pengadaan
    public function index(): void
    {
        $rows = $this->model->all();

        $this->view('pengadaan/index', [
            'title' => 'Daftar Pengadaan',
            'rows' => $rows
        ]);
    }

    // Form membuat pengadaan
    public function create(): void
    {
        $this->view('pengadaan/form', [
            'title' => 'Buat Pengadaan'
        ]);
    }

    // Menyimpan header pengadaan
    public function store(): void
    {
        $iduser = $this->post('iduser', 'i');
        $idvendor = $this->post('idvendor', 'i');

        if ($iduser <= 0 || $idvendor <= 0) {
            throw new InvalidArgumentException(
                'ID User dan Vendor harus positif.'
            );
        }

        $idpengadaan = $this->model->tambah(
            $iduser,
            $idvendor
        );

        $this->goToDetail($idpengadaan);
    }

    // Halaman detail pengadaan
    public function show(): void
    {
        $id = $this->id();

        $pengadaan = $this->model->find($id);

        if (!$pengadaan) {
            throw new RuntimeException(
                'Pengadaan tidak ditemukan.'
            );
        }

        $details = $this->model->detail($id);

        $this->view('pengadaan/show', [
            'title' => 'Detail Pengadaan',
            'pengadaan' => $pengadaan,
            'details' => $details
        ]);
    }

    // Menambahkan satu produk
    public function addDetail(): void
    {
        $idpengadaan = $this->post(
            'idpengadaan',
            'i'
        );

        $idproduk = $this->post(
            'idproduk',
            'i'
        );

        $harga = $this->post(
            'harga',
            'i'
        );

        $jumlah = $this->post(
            'jumlah',
            'i'
        );

        if (
            $idpengadaan <= 0 ||
            $idproduk <= 0 ||
            $harga < 0 ||
            $jumlah <= 0
        ) {
            throw new InvalidArgumentException(
                'Data produk tidak valid.'
            );
        }

        $pengadaan = $this->model->find(
            $idpengadaan
        );

        if (!$pengadaan) {
            throw new RuntimeException(
                'Pengadaan tidak ditemukan.'
            );
        }

        if ($pengadaan['status'] !== 'D') {
            throw new RuntimeException(
                'Pengadaan sudah selesai.'
            );
        }

        $this->model->tambahDetail(
            $idpengadaan,
            $idproduk,
            $harga,
            $jumlah
        );

        $this->goToDetail($idpengadaan);
    }

    // Menyelesaikan pengadaan
    public function finish(): void
    {
        $idpengadaan = $this->post(
            'idpengadaan',
            'i'
        );

        $pengadaan = $this->model->find(
            $idpengadaan
        );

        if (!$pengadaan) {
            throw new RuntimeException(
                'Pengadaan tidak ditemukan.'
            );
        }

        if ($pengadaan['status'] !== 'D') {
            throw new RuntimeException(
                'Pengadaan bukan berstatus Draft.'
            );
        }

        $this->model->simpan($idpengadaan);

        $hasil = $this->model->find(
            $idpengadaan
        );

        if (!$hasil || $hasil['status'] !== 'S') {
            throw new RuntimeException(
                'Pengadaan belum bisa diselesaikan. '
                . 'Periksa apakah detail produk sudah ada.'
            );
        }

        $this->goToDetail($idpengadaan);
    }

    // Kembali ke halaman detail
    private function goToDetail(int $id): void
    {
        header(
            'Location: ' . url(
                'pengadaan',
                'show',
                ['id' => $id]
            )
        );

        exit;
    }
}
