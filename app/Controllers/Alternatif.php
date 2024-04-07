<?php

namespace App\Controllers;

use App\Models\AlternatifModel;

class Alternatif extends BaseController
{
    protected $alternatif;
    protected $dataBulan;
    protected $dataTahun;

    public function __construct()
    {
        $this->alternatif = new AlternatifModel();

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
            $dataAlternatif = $this->alternatif->getPeriode($bulan, $tahun);
        } else {
            // Ambil semua data
            $dataAlternatif = $this->alternatif->findAll();
        }

        $data = [
            'title' => 'Data Nasabah',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'dataBulan' => $this->dataBulan,
            'dataTahun' => $this->dataTahun,
            'alternatif' => $dataAlternatif // Gunakan data alternatif berdasarkan periode
        ];
        return view('alternatif/index', $data);
    }

    // public function autoKode()
    // {
    //     return json_encode($this->alternatif->generateCode());
    // }

    public function tambah($bulan = null, $tahun = null)
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Tambah Data Nasabah',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'dataBulan' => $this->dataBulan,
            'dataTahun' => $this->dataTahun,
            'validation' => \Config\Services::validation()
        ];
        return view('alternatif/tambah', $data);
    }

    public function simpan()
    {
        // validasi input
        if (!$this->validate([
            'alternatif' => [
                // 'rules' => 'required|is_unique[alternatif.alternatif]',
                'errors' => [
                    'required' => 'nama {field} harus diisi!',
                    // 'is_unique' => 'alternatif {field} sudah ada!'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/nasabah/simpan')->withInput()->with('validation', $validation);
        }

        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');

        // proses upload gambar
        // $dataFile = $this->request->getFile('berkas');
      
        // if ($dataFile->getName() == "") {
        //     $fileName = "";
        // } else {
        //     $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'xlsx', 'xls', 'docs']; // Daftar ekstensi yang diperbolehkan
        //     $fileName = $dataFile->getRandomName();
        //     $fileSize = $dataFile->getSize();
        //     $fileExtension = $dataFile->getExtension();
        //     // filter jika file nya lebih dari 2mb
        //     // ukuran file dalam bytes karena 1KB = 1024 bytes, sehingga 2MB = 2048 * 1024 
        //     // filter jika file nya lebih dari 2MB atau ekstensi tidak diperbolehkan
        //     if ($fileSize > 2048 * 1024) { // Periksa ukuran file dalam bytes (2MB)
        //         // $isipesan = '<script> alert("File terlalu besar!") </script>';
        //     } elseif (!in_array($fileExtension, $allowedExtensions)) { // Periksa ekstensi file
        //         // $isipesan = '<script> alert("Format file tidak diperbolehkan. Hanya file dengan ekstensi jpg, jpeg, png, pdf, xlsx, dan xls yang diperbolehkan.!") </script>';
        //     } else {
        //         // Jika file lolos pengecekan ukuran dan ekstensi, lanjutkan proses upload
        //         $dataFile->move('berkas-nasabah', $fileName);
        //         // $isipesan = '<script> alert("File berhasil di-upload!") </script>';
        //     }
        // }

        // session()->setFlashdata('pesan', $isipesan);

    $data =    $this->alternatif->save([
            'id_bulan' => $bulan,
            'id_tahun' => $tahun,
            'alternatif' => $this->request->getVar('alternatif'),
            'tgl_lahir' => $this->request->getVar('tglLahir'),
            'alamat' => $this->request->getVar('alamat'),
            'jns_kelamin' => $this->request->getVar('jnsKelamin'),
            'no_telp' => $this->request->getVar('noTelp'),
            // 'file' => $fileName,
        ]);
        // pesan data berhasil ditambah
        $isipesan = '<script> alert("Nasabah berhasil ditambahkan!") </script>';
        session()->setFlashdata('pesan', $isipesan);

        return redirect()->to('/nasabah/periode/' . $bulan . '/' . $tahun);
    }

    public function edit($id)
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Edit Nasabah',
            'dataBulan' => $this->dataBulan,
            'dataTahun' => $this->dataTahun,
            'bulan' => $this->request->getVar('bulan'),
            'tahun' => $this->request->getVar('tahun'),
            'alternatif' => $this->alternatif->find($id),
            'validation' => \Config\Services::validation()
        ];
        return view('/alternatif/edit', $data);
    }

    public function update($id)
    {
        // validasi input
        if (!$this->validate([
            'alternatif' => [
                // 'rules' => 'required|is_unique[alternatif.alternatif]',
                'errors' => [
                    'required' => 'nama {field} harus diisi!',
                    // 'is_unique' => 'alternatif {field} sudah ada!'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/nasabah/edit/' . $id)->withInput()->with('validation', $validation);
        }

        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');

        // untuk proses edit gambar data yg dikirm di cek terlebih dahulu apakah ada data gambar baru jika ya lakukan update jika tidak ada maka tidaka ada update gambar
        $dataFile = $this->request->getFile('berkas');
        if ($dataFile->getName() == "") {
            $this->alternatif->save([
                'id_alternatif' => $id,
                'id_bulan' =>  $bulan,
                'id_tahun' =>  $tahun,
                'alternatif' => $this->request->getVar('alternatif'),
                'tgl_lahir' => $this->request->getVar('tglLahir'),
                'alamat' => $this->request->getVar('alamat'),
                'jns_kelamin' => $this->request->getVar('jnsKelamin'),
                'no_telp' => $this->request->getVar('noTelp'),
            ]);
        } else {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'xlsx', 'xls']; // Daftar ekstensi yang diperbolehkan
            $fileName = $dataFile->getRandomName();
            $fileSize = $dataFile->getSize();
            $fileExtension = $dataFile->getExtension();
            // filter jika file nya lebih dari 2mb
            // ukuran file dalam bytes karena 1KB = 1024 bytes, sehingga 2MB = 2048 * 1024 
            // filter jika file nya lebih dari 2MB atau ekstensi tidak diperbolehkan
            if ($fileSize > 2048 * 1024) { // Periksa ukuran file dalam bytes (2MB)
                $isipesan = '<script> alert("File terlalu besar!") </script>';
            } elseif (!in_array($fileExtension, $allowedExtensions)) { // Periksa ekstensi file
                $isipesan = '<script> alert("Format file tidak diperbolehkan. Hanya file dengan ekstensi jpg, jpeg, png, pdf, xlsx, dan xls yang diperbolehkan.!") </script>';
            } else {
                // Jika file lolos pengecekan ukuran dan ekstensi, lanjutkan proses upload
                $dataFile->move('berkas-nasabah', $fileName);
                $isipesan = '<script> alert("File berhasil di-upload!") </script>';
            }
            $this->alternatif->save([
                'id_alternatif' => $id,
                'id_bulan' =>  $bulan,
                'id_tahun' =>  $tahun,
                'alternatif' => $this->request->getVar('alternatif'),
                'tgl_lahir' => $this->request->getVar('tglLahir'),
                'alamat' => $this->request->getVar('alamat'),
                'jns_kelamin' => $this->request->getVar('jnsKelamin'),
                'no_telp' => $this->request->getVar('noTelp'),
                'file' => $fileName,
            ]);
        }

        // pesan data berhasil ditambah
        $isipesan = '<script> alert("Nasabah berhasil diupdate!") </script>';
        session()->setFlashdata('pesan', $isipesan);

        return redirect()->to('/nasabah/periode/' . $bulan . '/' . $tahun);
    }

    public function delete($id)
    {
        // Pengecekan session login
        if (session()->get('login') != "login") {
            // Jika tidak ada session 'login', redirect ke halaman login dengan pesan error
            session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
            return redirect()->to('/login');
        }

        $this->alternatif->delete($id);

        // pesan berhasil didelete
        $isipesan = '<script> alert("Data berhasil dihapus!") </script>';
        session()->setFlashdata('pesan', $isipesan);

        return redirect()->to('/nasabah');
    }
}
