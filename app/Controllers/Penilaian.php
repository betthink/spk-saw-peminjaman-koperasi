<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\AlternatifModel;
use App\Models\KriteriaModel;
use App\Models\SubKriteriaModel;
use App\Models\SkalaPenilaianModel;
use CodeIgniter\HTTP\URI;

class Penilaian extends BaseController
{
    protected $penilaian;
    protected $alternatif;
    protected $kriteria;
    protected $SkalaPenilaianM;
    protected $subKriteria;
    protected $dataBulan;
    protected $dataTahun;

    public function __construct()
    {
        $this->penilaian = new PenilaianModel();
        $this->alternatif = new AlternatifModel();
        $this->kriteria = new KriteriaModel();
        $this->subKriteria = new SubKriteriaModel();
        $this->SkalaPenilaianM = new SkalaPenilaianModel();

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

        $alternatifList = $this->alternatif->getPeriode($bulan, $tahun);
        foreach ($alternatifList as $key => $alternatif) {
            // Memeriksa apakah sudah ada penilaian untuk alternatif ini
            $isPenilaianExists = $this->penilaian->where('id_alternatif', $alternatif['id_alternatif'])->countAllResults() > 0;
            $alternatifList[$key]['isPenilaianExists'] = $isPenilaianExists;
        }

        $data = [
            'title' => 'Penilaian',
            'alternatif' => $alternatifList,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'dataBulan' => $this->dataBulan,
            'dataTahun' => $this->dataTahun,
        ];

        return view('Penilaian/index', $data);
    }

    public function tambah($id)
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        // $ambil data id alternatif
        $idAlternatif = $this->alternatif->find($id);

        // Dapatkan semua data kriteria
        $kriteriaList = $this->kriteria->findAll();

        // Inisialisasi array untuk menyimpan data subkriteria
        $subkriteriaData = [];

        // Looping data kriteria
        foreach ($kriteriaList as $kriteria) {

            // Dapatkan data subkriteria berdasarkan ID kriteria
            $subkriteria = $this->subKriteria->where('id_kriteria', $kriteria['id_kriteria'])->findAll();

            // Tambahkan data subkriteria ke dalam array
            $subkriteriaData[] = [
                'kriteria' => $kriteria,
                'subkriteria' => $subkriteria,
            ];
        }

        $data = [
            'title' => 'Tambah Penilaian',
            'idAlternatif' => $idAlternatif,
            'kriteria' => $kriteriaList,
            'subkriteriaData' => $subkriteriaData,
            'bulan' => $this->request->getVar('bulan'),
            'tahun' => $this->request->getVar('tahun'),
            'validation' => \Config\Services::validation()
        ];
        return view('Penilaian/tambah', $data);
    }

    public function simpan($id)
    {
        // Dapatkan array dari input
        $idKriteria = $this->request->getVar('idKriteria[]');
        $nilai = $this->request->getVar('nilai[]');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');

        // Melakukan validasi untuk setiap elemen dalam array
        foreach ($idKriteria as $index => $value) {
            if (!$this->validate([
                'idKriteria' => 'required',
                'nilai' => 'required'
            ])) {
                $validation = \Config\Services::validation();
                return redirect()->to('/penilaian/tambah/' . $id)->withInput()->with('validation', $validation);
            }

            // Menyimpan setiap entry
            $this->penilaian->save([
                'id_bulan' => $bulan,
                'id_tahun' => $tahun,
                'id_alternatif' => $id,
                'id_kriteria' => $value,
                'nilai' => $nilai[$index]
            ]);
        }

        // pesan data berhasil ditambah
        $isipesan = '<script> alert("Berhasil ditambahkan!") </script>';
        session()->setFlashdata('pesan', $isipesan);

        return redirect()->to('/penilaian/periode/' . $bulan . '/' . $tahun);
    }

    public function edit($id)
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        // $ambil data id alternatif
        $idAlternatif = $this->alternatif->find($id);

        // Dapatkan semua data kriteria
        $kriteriaList = $this->kriteria->findAll();
        // Inisialisasi array untuk menyimpan data subkriteria
        $penilaianData = [];

        // Looping data kriteria
        foreach ($kriteriaList as $kriteria) {
            $idKriteria = $kriteria['id_kriteria'];

            // Dapatkan data penilaian berdasarkan ID alternatif dan ID kriteria
            $penilaian = $this->penilaian->where([
                'id_alternatif' => $id,
                'id_kriteria' => $idKriteria
            ])->orderBy('nilai', 'ASC')->findAll();

            // dapatkan data subkriteria berdasarkan id kriteria
            $kriteriaSub = $this->subKriteria->where('id_kriteria', $idKriteria)->findAll();

            // Tambahkan data penilaian ke dalam array
            $penilaianData[] = [
                'kriteria' => $kriteria,
                'subkriteria' => $kriteriaSub,
                'penilaian' => $penilaian,
            ];
        }

        $data = [
            'title' => 'Edit Penilaian',
            'idAlternatif' => $idAlternatif,
            'kriteria' => $kriteriaList,
            'penilaianData' => $penilaianData,
            'bulan' => $this->request->getVar('bulan'),
            'tahun' => $this->request->getVar('tahun'),
            'validation' => \Config\Services::validation()
        ];
        return view('Penilaian/edit', $data);
    }

    public function update($id)
    {
        // Dapatkan array dari input
        $id_bulan = $this->request->getVar('bulan');
        $id_tahun = $this->request->getVar('tahun');
        $idKriteria = $this->request->getVar('idKriteria[]');
        $nilai = $this->request->getVar('nilai[]');

        // dd($idAlternatif);
        $this->penilaian->where('id_alternatif', $id)->delete();

        // Melakukan validasi untuk setiap elemen dalam array
        foreach ($idKriteria as $index => $value) {
            if (!$this->validate([
                'idKriteria' => 'required',
                'nilai' => 'required'
            ])) {
                $validation = \Config\Services::validation();
                return redirect()->to('/penilaian/edit/' . $id)->withInput()->with('validation', $validation);
            }
            // Menyimpan setiap entry
            $this->penilaian->save([
                'id_bulan' => $id_bulan,
                'id_tahun' => $id_tahun,
                'id_alternatif' => $id,
                'id_kriteria' => $value,
                'nilai' => $nilai[$index]
            ]);
        }

        // pesan data berhasil ditambah
        $isipesan = '<script> alert("Penilaian alternatif berhasil diupdate!") </script>';
        session()->setFlashdata('pesan', $isipesan);

        return redirect()->to('/penilaian');
    }

    // kalkulasi penentuan C
    public function penentuan_skala_rating($id)
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }
        $previousURL = service('request')->getServer('HTTP_REFERER');

        // Mendapatkan URL default jika tidak ada halaman sebelumnya
        if (!$previousURL) {
            $previousURL = site_url('/');
        }
        $idAlternatif = $this->alternatif->find($id);
        $dataAlternatif = $this->alternatif->getDataById($id);
        // dd($dataAlternatif);
        if ($this->request->getMethod() == 'post') {
            $data = [
                'karakternilai' => $this->request->getPost('karakternilai'),
                'nilaiCapacitytoPay' => $this->request->getPost('nilaiCapacitytoPay'),
                'coolateralnilai' => $this->request->getPost('coolateralnilai'),
                'capitalnilai' => $this->request->getPost('capitalnilai'),
                'creditconditionnilai' => $this->request->getPost('creditconditionnilai'),
            ];
            // dd($data);
            // disini insert 
            // $ModelSkalaPenilaian = new SkalaPenilaianModel();
            $insertSkala =   $this->SkalaPenilaianM->insertDataSkala($idAlternatif['id_alternatif'], $data);

            if ($insertSkala) {
                $total = [];
                // Iterasi melalui setiap array
                foreach ($data as $key => $values) {
                    // Inisialisasi total untuk array saat ini
                    $arrayTotal = 0;

                    // Iterasi melalui nilai-nilai dalam array
                    foreach ($values as $value) {
                        // Ubah nilai menjadi integer atau float tergantung pada jenis datanya
                        $numericValue = is_numeric($value) ? $value : (float)$value;

                        // Tambahkan nilai ke total array saat ini
                        $arrayTotal += $numericValue;
                    }
                    $total[$key] = $arrayTotal;
                }

                // Cetak total nilai untuk setiap array
                // dd($total);
                function klasifikasi_dinamis($nilai, $maksimum, $kategori)
                {
                    $range = ceil($maksimum / count($kategori));
                    foreach ($kategori as $key => $tingkat) {
                        $mulai = $key * $range + 1;
                        $akhir = ($key + 1) * $range;
                        if ($nilai >= $mulai && $nilai <= $akhir) {
                            return $tingkat;
                        }
                    }
                    return 1;
                }
                $maksimumkarakter = 15;
                $maksimumCTP = 70;
                $maksimumcoolateral = 5;
                $maksimumcapitalnilai = 5;
                $maksimumcreditcondition = 5;
                $kategori = [1, 2, 3, 4, 5];
                // $nilai_skala_rating = [
                //     'Character' => klasifikasi_dinamis($total['karakternilai'], $maksimumkarakter, $kategori),
                //     'Capacity to Pay' => klasifikasi_dinamis($total['nilaiCapacitytoPay'], $maksimumCTP, $kategori),
                //     'Collateral' => klasifikasi_dinamis($total['coolateralnilai'], $maksimumcoolateral, $kategori),
                //     'Capital Status' => klasifikasi_dinamis($total['capitalnilai'], $maksimumcapitalnilai, $kategori),
                //     'Credit Condition' => klasifikasi_dinamis($total['creditconditionnilai'], $maksimumcreditcondition, $kategori),
                // ];
                $nilai_skala_rating = [
                    'Character' => $total['karakternilai'],
                    'Capacity to Pay' => $total['nilaiCapacitytoPay'],
                    'Collateral' => $total['coolateralnilai'],
                    'Capital Status' => $total['capitalnilai'],
                    'Credit Condition' => $total['creditconditionnilai'],
                ];
                // dd($nilai_skala_rating);

                $ModelPenilaian = new PenilaianModel();

                // Looping untuk menyisipkan data nilai
                $allInsertedSuccessfully = true;

                // Looping untuk menyisipkan data nilai
                foreach ($nilai_skala_rating as $namaKriteria => $nilai) {
                    // Mendapatkan ID Kriteria berdasarkan nama kriteria
                    $idKriteria = $ModelPenilaian->getIdKriteriaByNama($namaKriteria);

                    if ($idKriteria !== null) {
                        // Menambahkan penilaian ke dalam tabel penilaian menggunakan model
                        $insertSkalaPenilaian = $ModelPenilaian->addNewPenilaian($dataAlternatif, $idKriteria, $nilai);
                        if (!$insertSkalaPenilaian) {
                            // Jika penyisipan gagal, ubah status menjadi false
                            $allInsertedSuccessfully = false;
                            // Tidak perlu melakukan redirect di sini
                        }
                    } else {
                        echo "ID Kriteria untuk $namaKriteria tidak ditemukan!";
                        // Ubah status menjadi false jika ID Kriteria tidak ditemukan
                        $allInsertedSuccessfully = false;
                        // Tidak perlu melakukan redirect di sini
                    }
                }

                // Lakukan redirect setelah selesai looping
                if ($allInsertedSuccessfully) {
                    // Jika semua penyisipan berhasil, lakukan redirect dengan pesan sukses
                    return redirect()->to('/penilaian')->with(
                        'message',
                        'Berhasil menambahkan penilaian'
                    );
                } else {
                    // Jika ada penyisipan yang gagal, lakukan redirect dengan pesan gagal
                    return redirect()->to(new URI($previousURL))->with(
                        'message',
                        'Gagal membuat penilaian'
                    );
                }
            }
        } else {

            $data = [
                'title' => 'Tambah skala penilaian',
                'idAlternatif' => $idAlternatif,
                'validation' => \Config\Services::validation()
            ];
            return view('Penilaian/perhitungan_skala_rating', $data);
        }

        // $ambil data id alternatif

    }
    public function edit_skala($id)
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        if ($this->request->getMethod() == 'get') {
            $idAlternatif = $this->alternatif->find($id);
            $data = $this->SkalaPenilaianM->getDataByIdUser($id);
            // dd($data);die;
            $data = [
                'title' => 'Edit skala penilaian',
                'idAlternatif' => $idAlternatif,
                'dataSkala' => $data,
                'validation' => \Config\Services::validation()
            ];
            return view('Penilaian/edit_skala', $data);
        }
    }
    public function updateSkalaPenilaian($id)
    {
        // Mengambil data dari form (contoh saja)
        $postData = $this->request->getPost();
        unset($postData['csrf_test_name']);
        unset($postData['submit']);
        // dd($postData);

        // Memanggil metode updateDataSkala untuk memperbarui data skala penilaian
        if ($this->SkalaPenilaianM->updateDataSkala($postData)) {
            // Jika berhasil diperbarui, lakukan sesuatu, seperti redirect atau tampilkan pesan sukses
            $previousURL = service('request')->getServer('HTTP_REFERER');

            // Mendapatkan URL default jika tidak ada halaman sebelumnya
            if (!$previousURL) {
                $previousURL = site_url('/');
            }
            $dataAlternatif = $this->alternatif->getDataById($id);

            // input ke penilaian
            $data = [
                'karakternilai' => $this->request->getPost('karakternilai'),
                'nilaiCapacitytoPay' => $this->request->getPost('nilaiCapacitytoPay'),
                'coolateralnilai' => $this->request->getPost('coolateralnilai'),
                'capitalnilai' => $this->request->getPost('capitalnilai'),
                'creditconditionnilai' => $this->request->getPost('creditconditionnilai'),
            ];
            // disini insert 
            // $ModelSkalaPenilaian = new SkalaPenilaianModel();

            $total = [];
            // Iterasi melalui setiap array
            foreach ($data as $key => $values) {
                // Inisialisasi total untuk array saat ini
                $arrayTotal = 0;

                // Iterasi melalui nilai-nilai dalam array
                foreach ($values as $value) {
                    // Ubah nilai menjadi integer atau float tergantung pada jenis datanya
                    $numericValue = is_numeric($value) ? $value : (float)$value;

                    // Tambahkan nilai ke total array saat ini
                    $arrayTotal += $numericValue;
                }
                $total[$key] = $arrayTotal;
            }

            // Cetak total nilai untuk setiap array
            // dd($total);
            function klasifikasi_dinamis($nilai, $maksimum, $kategori)
            {
                // Menghitung rentang setiap kategori
                $range = ceil($maksimum / count($kategori));
                // Menemukan kategori yang sesuai untuk nilai
                foreach ($kategori as $key => $tingkat) {
                    $mulai = $key * $range + 1;
                    $akhir = ($key + 1) * $range;
                    if ($nilai >= $mulai && $nilai <= $akhir) {
                        return $tingkat;
                    }
                }
                return 1;
            }
            $maksimumkarakter = 15;
            $maksimumCTP = 70;
            $maksimumcoolateral = 5;
            $maksimumcapitalnilai = 5;
            $maksimumcreditcondition = 5;
            $kategori = [1, 2, 3, 4, 5];
            // $nilai_skala_rating = [
            //     'Character' => klasifikasi_dinamis($total['karakternilai'], $maksimumkarakter, $kategori),
            //     'Capacity to Pay' => klasifikasi_dinamis($total['nilaiCapacitytoPay'], $maksimumCTP, $kategori),
            //     'Collateral' => klasifikasi_dinamis($total['coolateralnilai'], $maksimumcoolateral, $kategori),
            //     'Capital Status' => klasifikasi_dinamis($total['capitalnilai'], $maksimumcapitalnilai, $kategori),
            //     'Credit Condition' => klasifikasi_dinamis($total['creditconditionnilai'], $maksimumcreditcondition, $kategori),
            // ];
            $nilai_skala_rating = [
                'Character' => $total['karakternilai'],
                'Capacity to Pay' => $total['nilaiCapacitytoPay'],
                'Collateral' => $total['coolateralnilai'],
                'Capital Status' => $total['capitalnilai'],
                'Credit Condition' => $total['creditconditionnilai'],
            ];

            // Looping untuk menyisipkan data nilai
            $allInsertedSuccessfully = true;
            $getPenilaian = $this->penilaian->where('id_alternatif', $dataAlternatif['id_alternatif'])->findAll();
            // Looping untuk menyisipkan data nilai
            foreach ($nilai_skala_rating as $namaKriteria => $nilai) {
                // Mendapatkan ID Kriteria berdasarkan nama kriteria
                $idKriteria = $this->penilaian->getIdKriteriaByNama($namaKriteria);

                if ($idKriteria !== null) {
                    // Memperbarui penilaian menggunakan model
                    foreach ($getPenilaian as $penilaian) {
                        if ($penilaian['id_kriteria'] == $idKriteria) {
                            // Lakukan pembaruan nilai
                            $updateSkalaPenilaian = $this->penilaian->updatePenilaian($penilaian['id_penilaian'], $nilai);
                            if (!$updateSkalaPenilaian) {
                                // Jika pembaruan gagal, ubah status menjadi false
                                $allUpdatedSuccessfully = false;
                            }
                            break; // Keluar dari loop setelah pembaruan berhasil dilakukan
                        }
                    }
                } else {
                    echo "ID Kriteria untuk $namaKriteria tidak ditemukan!";
                    // Ubah status menjadi false jika ID Kriteria tidak ditemukan
                    $allUpdatedSuccessfully = false;
                }
            }


            // Lakukan redirect setelah selesai looping
            if ($allUpdatedSuccessfully) {
                // Redirect ke halaman penilaian
                return redirect()->to('/penilaian')->with('success', 'Pembaruan penilaian berhasil.');
            } else {
                // Jika ada yang gagal diperbarui, redirect dengan pesan error
                return redirect()->to('/penilaian')->with('error', 'Gagal memperbarui penilaian.');
            }
        } else {
            // Jika gagal, tampilkan pesan error atau lakukan tindakan yang sesuai
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data skala penilaian.');
        }
    }
}
