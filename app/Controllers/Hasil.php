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

        $karakter = [
            "Memiliki catatan pembayaran pinjaman yang baik, di CU dan tempat lain" => [
                "Kebiasaan yang baik dalam membayar pinjaman di CU?" => 4,
                "Kebiasaan yang baik dalam membayar pinjaman di tempat lain?" => 4,
            ],
            "Kemauan yang baik/reputasi" => [
                "Memiliki reputasi yang baik dikalangan dunia bisnis dan organisasi lainnya" => 1,
                "Yang bersangkutan adalah orang berpengaruh dimasyarakat" => 1,
            ],
            "Memiliki tempat tinggal permanen (rumah pribadi)" => [
                "Lama < 2 tahun" => 0,
                "Lama 3-5 tahun" => 1,
                "Lama > 5 tahun" => 2,
            ],
            "Hubungan baik dengan sesama" => [
                "Dengan keluarga" => 1,
                "Di tempat kerja" => 1,
                "Di masyarakat" => 1,
            ],
        ];
        $CapacitytoPay = [
          
            "Apakah tujuan pinjaman yang bersangkutan mampu mendapatkan keuntungan yang bersih?" => 10,
            "Apakah bisnis/gaji yang bersangkutan berkembang selama beberapa tahun terakhir?" => 5,
            "Apakah pemasukan dari usaha cukup untuk membayar angsuran dan bunga pinjaman?" => 20,
            "Apakah ROI (Return of Investment=laba atas investasi) bisnis/gaji yang bersangkutan mencukupi untuk membayar pinjaman?" => 5,
            "Apakah jangka waktu pengembalian pinjaman sesuai dengan jangka waktu hidup bisnis/gaji yang bersangkutan?" => 5,

        ];
        $CapacitytoPay1 = [
            "Apakah yang bersangkutan memiliki bisnis/gaji yang stabil?" => [
                "Tidak" => 0,
                "Lama < 5 tahun" => 3,
                "Lama > 5 tahun" => 5,
            ],
            "Apakah yang bersangkutan masih punya sisa pinjaman di tempat lain?" => [
                "Tidak" => 20,
                "Ya" => 5,
            ],
            
        ];
        $Coolaterals = [
            "Apakah barang jaminan yang ditawarkan dapat diubah menjadi uang tunai dengan mudah setiap saat?" => 1,
            "Apakah nilai barang jaminan lebih tinggi daripada jumlah pinjaman yang diajukan dan sesuai kebijakan penilaian barang jaminan?" => 1,
            "Apakah barang jaminannya mudah disita?" => 1,
            "Apakah para penjamin bersedia menjaminkan simpanannya atau bersedia dipotong gajinya apabila yang dijaminnya menunggak?" => 1,
            "Apakah suami/istri yang bersangkutan mengetahui dan menyetujui permohonan pinjaman ini?" => 1,
        ];
        $modals = [
            "Apakah yang bersangkutan menabung secara teratur di CU?" => 1.5,
            "Apakah ada harta pribadi, tabungan dan asset-asset usaha yang dapat dijadikan jaminan pinjaman?" => 1.5,
            "Apakah asset-asset yang bersangkutan bertambah terus?" => 1,
            "Apakah kekayaan bersih yang bersangkutan bertambah setiap tahun?" => 1,
        ];
        $CreditCondition = [
            "Apakah proyek/bisnis yang bersangkutan ramah lingkungan dan legal?" => 1,
            "Apakah kondisi cuaca sangat berpengaruh atas proyek/bisnis yang akan didanai dari pinjaman ini?" => 1,
            "Apakah pasar dapat menerima proyek ini?" => 2,
            "Apakah secara ekonomi masyarakat aktif menjamin kesuksesan proyek/bisnis ini?" => 1,
        ];


        $data = [
            'title' => 'Data Hasil',
            'karakters' => $karakter,
            'CapacitytoPay1' => $CapacitytoPay1,
            'CapacitytoPay' => $CapacitytoPay,
            'Coolaterals' => $Coolaterals,
            'CreditCondition' => $CreditCondition,
            'modals' => $modals,
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
