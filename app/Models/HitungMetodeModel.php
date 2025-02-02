<?php

namespace App\Models;

use CodeIgniter\Model;

class HitungMetodeModel extends Model
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


    // Buat query builder menggunakan Method getNilaiSubKriteria untuk mendapatkan nilai sub_kriteria
    public function getNilaiSubKriteria($idAlternatif, $idKriteria)
    {
        $builder = $this->db->table('penilaian');
        // $builder->select('nilai');
        $builder->select('sub_kriteria.nilai as n');
        $builder->join('sub_kriteria', 'penilaian.id_kriteria = sub_kriteria.id_kriteria');
        $builder->where('penilaian.id_alternatif', $idAlternatif);
        $builder->where('penilaian.id_kriteria', $idKriteria);
        // $builder->where('id_alternatif', $idAlternatif);
        // $builder->where('id_kriteria', $idKriteria);

        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getNilaiById($id_alternatif, $id_kriteria)
    {
        return $this->where('id_alternatif', $id_alternatif)
            ->where('id_kriteria', $id_kriteria)
            ->findAll();
    }

    public function getDistinctKriteria()
    {
        $builder = $this->db->table('penilaian p');
        $builder->select('p.id_kriteria, p.id_alternatif, k.*');
        $builder->join('kriteria k', 'p.id_kriteria = k.id_kriteria');
        $builder->groupBy('p.id_kriteria');
        $builder->orderBy('p.id_kriteria', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getDistinctAlternatif()
    {

        return $this->select('id_alternatif')
            ->groupBy('id_alternatif')
            ->orderBy('id_alternatif', 'ASC')
            ->find();
    }

    public function getAllPenilaian($bulan, $tahun)
    {
        $builder = $this->db->table('penilaian p');
        $builder->select('p.*, a.alternatif');
        $builder->join('alternatif a', 'p.id_alternatif = a.id_alternatif');
        $builder->where('p.id_bulan', $bulan);
        $builder->where('p.id_tahun', $tahun);
        $builder->orderBy('p.id_alternatif', 'ASC');
        $builder->orderBy('p.id_kriteria', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }

    public function getNilaiMaxMin($bulan, $tahun)
    {
        $builder = $this->db->table('penilaian');
        $builder->select('id_bulan, id_tahun, id_kriteria, MAX(nilai) as nilaiMax, Min(nilai) as nilaiMin');
        $builder->where('id_bulan', $bulan);
        $builder->where('id_tahun', $tahun);
        $builder->groupBy('id_kriteria');
        $builder->orderBy('id_kriteria', 'ASC');
        $builder->orderBy('id_alternatif', 'ASC');
        $query = $builder->get();
        return $query->getResultArray();
    }
}
