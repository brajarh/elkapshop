<?php

require_once __DIR__ . '/../Models/Penerimaan.php';

class PenerimaanController extends Controller
{
    private Penerimaan $model;

    public function __construct()
    {
        $this->model = new Penerimaan();
    }

    // Menampilkan daftar penerimaan
    public function index(): void
    {
        $penerimaan = $this->model->all();

        $this->view('penerimaan/index', [
            'title' => 'Daftar Penerimaan',
            'penerimaan' => $penerimaan
        ]);
    }

    // Menampilkan form penerimaan baru
    public function create(): void
    {
        $pengadaan = $this->model->daftarPengadaan();

        $this->view('penerimaan/create', [
            'title' => 'Tambah Penerimaan',
            'pengadaan' => $pengadaan
        ]);
    }

    // Membuat header penerimaan (Draft)
    public function store(): void
    {
        $idpengadaan = $this->post('idpengadaan', 'i');
        $iduser = $this->post('iduser', 'i');

        if ($idpengadaan <= 0 || $iduser <= 0) {
            throw new InvalidArgumentException(
                'Data pengadaan atau user tidak valid.'
            );
        }

        $idpenerimaan = $this->model->tambah(
            $idpengadaan,
            $iduser
        );

        header(
            'Location: ' . url('penerimaan', 'show', ['id' => $idpenerimaan])
        );
        exit;
    }

    // Menampilkan detail penerimaan
    public function show(): void
    {
        $id = $this->id();

        $penerimaan = $this->model->find($id);

        if (!$penerimaan) {
            throw new RuntimeException(
                'Penerimaan tidak ditemukan.'
            );
        }

        $details = $this->model->detail($id);

        // Produk dropdown berdasarkan pengadaan
        $produk = $this->model->pilihanProduk(
            (int) $penerimaan['idpengadaan']
        );

        $this->view('penerimaan/show', [
            'title' => 'Detail Penerimaan #' . $id,
            'penerimaan' => $penerimaan,
            'details' => $details,
            'produk' => $produk
        ]);
    }

    // Menambahkan detail barang
    public function storeDetail(): void
    {
        $id = $this->id();

        $idproduk = $this->post('idproduk', 'i');
        $jumlah = $this->post('jumlah', 'i');
        $harga = $this->post('harga', 'i');

        if ($idproduk <= 0 || $jumlah <= 0 || $harga < 0) {
            throw new InvalidArgumentException(
                'Data detail penerimaan tidak valid.'
            );
        }

        $penerimaan = $this->model->find($id);

        if (!$penerimaan || $penerimaan['status'] !== 'D') {
            throw new RuntimeException(
                'Penerimaan tidak ditemukan atau bukan Draft.'
            );
        }

        $this->model->tambahDetail(
            $id,
            $idproduk,
            $jumlah,
            $harga
        );

        header(
            'Location: ' . url('penerimaan', 'show', ['id' => $id])
        );
        exit;
    }

    // Konfirmasi penerimaan
    public function simpan(): void
    {
        $id = $this->id();

        $penerimaan = $this->model->find($id);

        if (!$penerimaan || $penerimaan['status'] !== 'D') {
            throw new RuntimeException(
                'Hanya penerimaan Draft yang bisa dikonfirmasi.'
            );
        }

        $details = $this->model->detail($id);

        if (empty($details)) {
            throw new RuntimeException(
                'Tambahkan minimal satu produk sebelum konfirmasi.'
            );
        }

        $this->model->simpan($id);

        header(
            'Location: ' . url('penerimaan', 'show', ['id' => $id])
        );
        exit;
    }
}
