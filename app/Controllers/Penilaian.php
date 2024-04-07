<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\AlternatifModel;
use App\Models\KriteriaModel;
use App\Models\SubKriteriaModel;

class Penilaian extends BaseController
{
    protected $penilaian;
    protected $alternatif;
    protected $kriteria;
    protected $subKriteria;
    protected $dataBulan;
    protected $dataTahun;

    public function __construct()
    {
        $this->penilaian = new PenilaianModel();
        $this->alternatif = new AlternatifModel();
        $this->kriteria = new KriteriaModel();
        $this->subKriteria = new SubKriteriaModel();

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

        // $ambil data id alternatif
        $idAlternatif = $this->alternatif->find($id);
        // dd($idAlternatif);
        // Dapatkan semua data kriteria
        // $kriteriaList = $this->kriteria->findAll();

        // // Inisialisasi array untuk menyimpan data subkriteria
        // $subkriteriaData = [];

        // // Looping data kriteria
        // foreach ($kriteriaList as $kriteria) {

        //     // Dapatkan data subkriteria berdasarkan ID kriteria
        //     $subkriteria = $this->subKriteria->where('id_kriteria', $kriteria['id_kriteria'])->findAll();

        //     // Tambahkan data subkriteria ke dalam array
        //     $subkriteriaData[] = [
        //         'kriteria' => $kriteria,
        //         'subkriteria' => $subkriteria,
        //     ];
        // }

        $data = [
            'title' => 'Tambah skala penilaian',
            'idAlternatif' => $idAlternatif,
            // 'kriteria' => $kriteriaList,
            // 'subkriteriaData' => $subkriteriaData,
            // 'bulan' => $this->request->getVar('bulan'),
            // 'tahun' => $this->request->getVar('tahun'),
            'validation' => \Config\Services::validation()
        ];
        return view('Penilaian/perhitungan_skala_rating', $data);
    }
}
