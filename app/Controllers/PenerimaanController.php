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
            if (isset($row['iddetail_penerimaan']) && (int) $row['iddetail_penerimaan'] === $detail) {
                return;
            }
        }
        throw new RuntimeException('Detail tidak ditemukan pada transaksi ini.');
    }

    public function edit(): void
    {
        $id = $this->id();
        $row = $this->draft($id);
        $this->view('penerimaan/edit', ['title' => 'Edit Penerimaan', 'row' => $row]);
    }

    public function update(): void
    {
        $id = $this->id();
        $this->draft($id);
        $iduser = $this->post('iduser', 'i');
        if ($iduser <= 0) {
            throw new InvalidArgumentException('ID tidak valid.');
        }
        $this->model->update($id, $iduser);
        header('Location: ' . url('penerimaan', 'show', ['id' => $id]));
        exit;
    }

    public function delete(): void
    {
        $id = $this->id();
        $this->draft($id);
        $this->model->hapus($id);
        $this->redirect('penerimaan');
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
        header('Location: ' . url('penerimaan', 'show', ['id' => $id]));
        exit;
    }

    public function deleteDetail(): void
    {
        $id = $this->id();
        $detail = $this->post('detail', 'i');
        $this->detailDraft($id, $detail);
        $this->model->hapusDetail($id, $detail);
        header('Location: ' . url('penerimaan', 'show', ['id' => $id]));
        exit;
    }
}
