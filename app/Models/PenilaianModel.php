<?php

namespace App\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $table      = 'penilaian';
    protected $primaryKey = 'id_penilaian';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['id_bulan', 'id_tahun', 'id_alternatif', 'id_kriteria', 'nilai'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function findAllPenilaian()
    {
        $builder = $this->builder();
        $builder->select('*');
        $builder->join('alternatif', 'alternatif.id_alternatif = penilaian.id_alternatif');
        $query = $builder->get();
        return $query->getResultArray(); // Mengembalikan semua baris hasil sebagai array
    }

    public function findPenilaian()
    {
        $builder = $this->builder();
        $builder->select('*');
        $builder->join('alternatif', 'penilaian.id_alternatif = alternatif.id_alternatif');

        // menambahkan kondisi jika $id disediakan
        if ($id == null) {
            // Menambahkan filter berdasarkan ID
            $builder->where('penilaian.id_penilaian', $id);
            $query = $builder->get();
            return $query->getRowArray(); // Mengembalikan satu baris hasil sebagai array
        }

        $query = $builder->get();
        return $query->getResultArray(); // Mengembalikan semua baris hasil sebagai array
    }

    // Dalam model AlternatifModel atau model yang relevan
    public function getPenilaianByAlternatifAndKriteria($idAlternatif, $idKriteria)
    {
        $builder = $this->db->table('penilaian');
        $builder->select('penilaian.nilai, sub_kriteria.nilai as nilai_sub_kriteria');
        $builder->join('sub_kriteria', 'penilaian.nilai = sub_kriteria.id_sub_kriteria', 'left'); // Sesuaikan dengan kondisi join Anda
        $builder->where('penilaian.id_alternatif', $idAlternatif);
        $builder->where('penilaian.id_kriteria', $idKriteria);
        $query = $builder->get();

        return $query->getRowArray(); // Untuk single result atau getResultArray() untuk multiple results
    }
    public function addNewPenilaian($dataAlternatif, $idKriteria, $nilai )
    {
        $builder = $this->db->table('penilaian');

        // Mendapatkan tanggal saat ini
        $tanggalSekarang = date('Y-m-d');

        // Data yang akan dimasukkan ke dalam tabel penilaian
        $data = [
            'id_bulan' => $dataAlternatif['id_bulan'] , // Mengambil bulan dari tanggal saat ini
            'id_tahun' => $dataAlternatif['id_tahun'], // Mengambil tahun dari tanggal saat ini
            'id_alternatif' => $dataAlternatif['id_alternatif'],
            'id_kriteria' => $idKriteria,
            'nilai' => $nilai
        ];

        // Menambahkan data ke tabel penilaian
        return $builder->insert($data);
    }
    // Di dalam model PenilaianModel

    public function getIdKriteriaByNama($namaKriteria)
    {
        // Query untuk mendapatkan ID kriteria berdasarkan nama kriteria
        $query = $this->db->table('kriteria')
            ->select('id_kriteria')
            ->where('kriteria', $namaKriteria)
            ->get();

        // Memeriksa apakah query mengembalikan hasil
        if ($query->getNumRows() > 0) {
            // Mengambil hasil query
            $result = $query->getRow();
            // Mengembalikan ID kriteria
            return $result->id_kriteria;
        } else {
            // Kriteria tidak ditemukan, dapat ditangani sesuai kebutuhan
            return null;
        }
    }
}
