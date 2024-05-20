<?php

namespace App\Controllers;

use App\Models\HasilModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
                "Kebiasaan yang baik dalam membayar pinjaman di CU?" => 0.04,
                "Kebiasaan yang baik dalam membayar pinjaman di tempat lain?" => 0.04,
            ],
            "Kemauan yang baik/reputasi" => [
                "Memiliki reputasi yang baik dikalangan dunia bisnis dan organisasi lainnya" => 0.01,
                "Yang bersangkutan adalah orang berpengaruh dimasyarakat" => 0.01,
            ],
            "Memiliki tempat tinggal permanen (rumah pribadi)" => [
                "Lama < 2 tahun" => 0,
                "Lama 4-5 tahun" => 0.01,
                "Lama > 5 tahun" => 0.02,
            ],
            "Hubungan baik dengan sesama" => [
                "Dengan keluarga" => 0.01,
                "Di tempat kerja" => 0.01,
                "Di masyarakat" => 0.01,
            ],
        ];
        $CapacitytoPay1 = [
            "Apakah yang bersangkutan memiliki bisnis/gaji yang stabil?" => [
                "Tidak" => 0,
                "Lama < 5 tahun" => 0.03,
                "Lama > 5 tahun" => 0.05,
            ],
            "Apakah yang bersangkutan masih punya sisa pinjaman di tempat lain?" => [
                "Tidak" => 0.2,
                "Ya" => 0.05,
            ],

        ];
        $CapacitytoPay = [

            "Apakah tujuan pinjaman yang bersangkutan mampu mendapatkan keuntungan yang bersih?" => 0.1,
            "Apakah bisnis/gaji yang bersangkutan berkembang selama beberapa tahun terakhir?" => 0.05,
            "Apakah pemasukan dari usaha cukup untuk membayar angsuran dan bunga pinjaman?" => 0.2,
            "Apakah ROI (Return of Investment=laba atas investasi) bisnis/gaji yang bersangkutan mencukupi untuk membayar pinjaman?" => 0.05,
            "Apakah jangka waktu pengembalian pinjaman sesuai dengan jangka waktu hidup bisnis/gaji yang bersangkutan?" => 0.05,

        ];

        $Coolaterals = [
            "Apakah barang jaminan yang ditawarkan dapat diubah menjadi uang tunai dengan mudah setiap saat?" => 0.01,
            "Apakah nilai barang jaminan lebih tinggi daripada jumlah pinjaman yang diajukan dan sesuai kebijakan penilaian barang jaminan?" => 0.01,
            "Apakah barang jaminannya mudah disita?" => 0.01,
            "Apakah para penjamin bersedia menjaminkan simpanannya atau bersedia dipotong gajinya apabila yang dijaminnya menunggak?" => 0.01,
            "Apakah suami/istri yang bersangkutan mengetahui dan menyetujui permohonan pinjaman ini?" => 0.01,
        ];
        $modals = [
            "Apakah yang bersangkutan menabung secara teratur di CU?" => 0.015,
            "Apakah ada harta pribadi, tabungan dan asset-asset usaha yang dapat dijadikan jaminan pinjaman?" => 0.015,
            "Apakah asset-asset yang bersangkutan bertambah terus?" => 0.01,
            "Apakah kekayaan bersih yang bersangkutan bertambah setiap tahun?" => 0.01,
        ];
        $CreditCondition = [
            "Apakah proyek/bisnis yang bersangkutan ramah lingkungan dan legal?" => 0.01,
            "Apakah kondisi cuaca sangat berpengaruh atas proyek/bisnis yang akan didanai dari pinjaman ini?" => 0.01,
            "Apakah pasar dapat menerima proyek ini?" => 0.02,
            "Apakah secara ekonomi masyarakat aktif menjamin kesuksesan proyek/bisnis ini?" => 0.01,
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
        $dataHasil  = $this->hasil->getPeriode($bulan, $tahun);
        function hasilKeputusan($nilai)
        {
            $persentase = $nilai * 100;
            if (
                $persentase > 0 && $persentase <= 70
            ) {
                return "Permohonan pinjaman ditolak, karena sangat tinggi kemungkinan yang bersangkutan tidak mampu mengembalikan pinjaman.";
            } elseif ($persentase > 70 && $persentase <= 80) {
                return "Disetujui, tetapi memerlukan barang jaminan yang memadai, jaminan dari penjamin, memiliki jumlah tabungan yang memadai dan pengamatan pasca pinjaman cair yang seksama.";
            } elseif ($persentase > 80 && $persentase <= 90) {
                return "Disetujui, tetapi memerlukan barang jaminan yang memadai dan pengamatan pasca pinjaman cair yang seksama.";
            } elseif ($persentase > 90 && $persentase <= 100) {
                return "Disetujui, dengan atau tanpa barang jaminan.";
            } else {
                return "Nilai persentase tidak valid.";
            }
        }
        // Konversi nilai ke persentase
        foreach ($dataHasil as
        &$row) {
            $point = floatval($row['nilai']);
            $row['keputusan'] = hasilKeputusan($point); // Konversi ke persen tanpa '%'
            $row['nilai'] = floatval($row['nilai']) * 100; // Konversi ke persen tanpa '%'
        }
        unset($row); // Break the reference

        // Urutkan data berdasarkan nilai dalam urutan menurun
        usort($dataHasil, function ($a, $b) {
            return $b['nilai'] <=> $a['nilai'];
        });
        $data = [
            'title' => 'cetak/hasil/periode',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'dataBulan' => $this->dataBulan,
            'dataTahun' => $this->dataTahun,
            'hasil' => $dataHasil,
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
    public function generateExcel($bulan, $tahun)
    {
        // Array nama-nama bulan
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // Mendapatkan nama bulan
        $namaBulanStr = isset($namaBulan[$bulan]) ? $namaBulan[$bulan] : 'Bulan tidak valid';

        // Menggabungkan tahun dengan awalan 20
        $tahunPenuh = 2000 + $tahun;

        // Data hasil
        $dataHasil = $this->hasil->getPeriode($bulan, $tahun);
        usort($dataHasil, function ($a, $b) {
            return floatval($b['nilai']) <=> floatval($a['nilai']);
        });
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Menetapkan nilai untuk sel B2
        $sheet->setCellValue('B1', "Hasil perangkingan SPK metode SAW ");
        $sheet->setCellValue('B2', "Periode");
        $sheet->setCellValue('C2', ":");
        $sheet->setCellValue('D2',  $namaBulanStr . " / " . $tahunPenuh);
        $sheet->mergeCells('B1:G1');

        // Merge cells F3:Q based on the number of data in $dataHasil
        // for ($i = 3; $i < (count($dataHasil) + 5); $i++) {
        //     $sheet->mergeCells('F' . $i . ':Q' . $i);
        // }
        $sheet->getStyle('B1')->getFont()->setBold(true);

        // Mengatur nilai untuk header tabel di Excel dan membuat teks header menjadi tebal
        $sheet->setCellValue('B4', 'No')
            ->getStyle('B4')
            ->getFont()
            ->setBold(true);

        $sheet->setCellValue('C4', 'Nasabah')
            ->getStyle('C4')
            ->getFont()
            ->setBold(true);

        $sheet->setCellValue('D4', 'Penilaian')
            ->getStyle('D4')
            ->getFont()
            ->setBold(true);

        $sheet->setCellValue('E4', 'Status')
            ->getStyle('E4')
            ->getFont()
            ->setBold(true);

        $sheet->setCellValue('F4', 'Keputusan')
            ->getStyle('F4')
            ->getFont()
            ->setBold(true);
        $sheet->setCellValue('G4', 'Rangking')
            ->getStyle('G4')
            ->getFont()
            ->setBold(true);

        // Menambahkan border di sekitar sel dari A1 hingga F7
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle('B4:G' . (count($dataHasil) + 4))->applyFromArray($styleArray);

        // Fungsi evaluasi pinjaman
        function evaluasiPinjaman($nilai)
        {
            $persentase = $nilai * 100;
            if ($persentase > 0 && $persentase <= 70) {
                return "Permohonan pinjaman ditolak, karena sangat tinggi kemungkinan yang bersangkutan tidak mampu mengembalikan pinjaman.";
            } elseif ($persentase > 70 && $persentase <= 80) {
                return "Disetujui, tetapi memerlukan barang jaminan yang memadai, jaminan dari penjamin, memiliki jumlah tabungan yang memadai dan pengamatan pasca pinjaman cair yang seksama.";
            } elseif ($persentase > 80 && $persentase <= 90) {
                return "Disetujui, tetapi memerlukan barang jaminan yang memadai dan pengamatan pasca pinjaman cair yang seksama.";
            } elseif ($persentase > 90 && $persentase <= 100) {
                return "Disetujui, dengan atau tanpa barang jaminan.";
            } else {
                return "Nilai persentase tidak valid.";
            }
        }

        // Mengisi data hasil ke dalam tabel
        $no = 1;
        $numrow = 5;
        foreach ($dataHasil as $row) {
            $nilai = floatval($row['nilai']);
            $persentase = $nilai * 100;
            $kesimpulan = evaluasiPinjaman($nilai);
            $sheet->setCellValue('B' . $numrow, $no);
            $sheet->setCellValue('C' . $numrow, $row['alternatif']);
            $sheet->setCellValue('D' . $numrow, $persentase . '%');
            $sheet->setCellValue('E' . $numrow, $row['status']);
            $sheet->setCellValue('F' . $numrow, $kesimpulan);
            $sheet->setCellValue('G' . $numrow, '(' . $no . ')');
            $no++;
            $numrow++;
        }

        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Hasil penilaian kredit");

        // $pdfWriter = new Mpdf($spreadsheet);
        // $pdfWriter->save('php://output', 'Hasil-penilaian.pdf');

        $writer = new Xlsx($spreadsheet);
        $filename = "Hasil-penilaian-" . $namaBulanStr . "-" . $tahunPenuh . ".xlsx";
        // Set headers for Excel file download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
