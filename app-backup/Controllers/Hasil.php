<?php

namespace App\Controllers;

use App\Models\HasilModel;

class Hasil extends BaseController
{
    protected $hasil;
    protected $dataBulan;
    protected $dataTahun;

    public function __construct()
    {
        $this->hasil = new HasilModel();

        // membuat bulan untuk keperluan periode
        $this->dataBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        // membuat range tahun untuk keperluan periode
        $thnAwal = 2022;
        $thnAkhir = intval(date('Y'));
        $jumlahThn = $thnAkhir - $thnAwal;
        $this->dataTahun = [];
        for ($i = 0; $i <= $jumlahThn; $i++) {
            $this->dataTahun[] = $thnAwal + $i;
        }
    }

    public function index($bulan = null, $tahun = null)
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }
        // Cek apakah bulan dan tahun sudah ditentukan
        if ($bulan != null && $tahun != null) {
            // Ambil data berdasarkan bulan dan tahun
            $dataHasil = $this->hasil->getPeriode($bulan, $tahun);
        } else {
            // Ambil semua data
            $dataHasil = $this->hasil->findAll();
        }

        $data = [
            'title' => 'Data Hasil',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'dataBulan' => $this->dataBulan,
            'dataTahun' => $this->dataTahun,
            'hasil' => $dataHasil,
            'countHasil' => $this->hasil->getCountHasilUnik(),
        ];
        return view('Hasil/index', $data);
    }

    public function cetak($bulan = 1, $tahun = 22)
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'cetak/hasil/periode',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'dataBulan' => $this->dataBulan,
            'dataTahun' => $this->dataTahun,
            'hasil' => $this->hasil->getPeriode($bulan, $tahun),
        ];
        return view('Hasil/cetak', $data);
    }

    public function hapus($id_bulan = null, $id_tahun = null)
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        // Pastikan $id_bulan dan $id_tahun tidak null
        if ($id_bulan !== null && $id_tahun !== null) {
            // Gunakan where clause untuk kondisi spesifik sebelum delete
            $this->hasil->where([
                'id_bulan' => $id_bulan,
                'id_tahun' => $id_tahun,
            ])->delete();

            // Set pesan berhasil
            session()->setFlashdata('pesan', 'Data berhasil dihapus!');
        } else {
            // Set pesan error jika id_bulan atau id_tahun null
            session()->setFlashdata('pesan', 'Gagal menghapus data. ID bulan atau tahun tidak valid.');
        }

        return redirect()->to('/hasil');
    }
}
