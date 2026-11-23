<?php

require_once __DIR__ . '/../Models/Pengadaan.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Vendor.php';
require_once __DIR__ . '/../Models/Produk.php';

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
            'title' => 'Buat Pengadaan',
            'users' => (new User())->all(),
            'vendors' => (new Vendor())->aktif()
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
            'details' => $details,
            'produks' => $pengadaan['status'] === 'D' ? (new Produk())->aktif() : []
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

    private function draft(int $id): array
    {
        $row = $this->model->find($id);
        if (!$row || $row['status'] !== 'D') {
            throw new RuntimeException('Hanya transaksi Draft yang dapat diubah.');
        }
        return $row;
    }

    private function detailDraft(int $id, int $detail): void
    {
        $this->draft($id);
        foreach ($this->model->detail($id) as $row) {
            if (isset($row['iddetail_pengadaan']) && (int) $row['iddetail_pengadaan'] === $detail) {
                return;
            }
        }
        throw new RuntimeException('Detail tidak ditemukan pada transaksi ini.');
    }

    public function edit(): void
    {
        $id = $this->id();
        $row = $this->draft($id);
        $this->view('pengadaan/edit', ['title' => 'Edit Pengadaan', 'row' => $row]);
    }

    public function update(): void
    {
        $id = $this->id();
        $this->draft($id);
        $iduser = $this->post('iduser', 'i');
        $idvendor = $this->post('idvendor', 'i');
        if ($iduser <= 0 || $idvendor <= 0) {
            throw new InvalidArgumentException('ID tidak valid.');
        }
        $this->model->update($id, $iduser, $idvendor);
        header('Location: ' . url('pengadaan', 'show', ['id' => $id]));
        exit;
    }

    public function delete(): void
    {
        $id = $this->id();
        $this->draft($id);
        $this->model->hapus($id);
        $this->redirect('pengadaan');
    }

    public function updateDetail(): void
    {
        $id = $this->id();
        $detail = $this->post('detail', 'i');
        $harga = $this->post('harga', 'i');
        $jumlah = $this->post('jumlah', 'i');
        $this->detailDraft($id, $detail);
        if ($harga < 0 || $jumlah <= 0) {
            throw new InvalidArgumentException('Harga atau jumlah tidak valid.');
        }
        $this->model->updateDetail($id, $detail, $harga, $jumlah);
        header('Location: ' . url('pengadaan', 'show', ['id' => $id]));
        exit;
    }

    public function deleteDetail(): void
    {
        $id = $this->id();
        $detail = $this->post('detail', 'i');
        $this->detailDraft($id, $detail);
        $this->model->hapusDetail($id, $detail);
        header('Location: ' . url('pengadaan', 'show', ['id' => $id]));
        exit;
    }
}
