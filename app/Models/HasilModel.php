<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilModel extends Model
{
    protected $table      = 'hasil';
    protected $primaryKey = 'id_hasil';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['kode_hasil', 'alternatif', 'id_bulan', 'id_tahun', 'nilai', 'status'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getDataByTahun($tahun = null)
    {
        if (!is_null($tahun)) {
            $this->where('tahun', $tahun);
        }
        return $this->findAll();
    }

    public function simpanHasil($data)
    {
        return $this->insert($data);
    }

    public function getPeriode($bulan, $tahun)
    {
        $builder = $this->db->table('hasil');
        $builder->select('*');
        $builder->where('id_bulan', $bulan);
        $builder->where('id_tahun', $tahun);
        $query = $builder->get();

        return $query->getResultArray();
    }
    public function getHasil()
    {
        $builder = $this->db->table('hasil');
        $builder->select('nilai');
        $query = $builder->get();

        return $query->getResultArray();
    }
    public function getCountHasilUnik()
    {
        $builder = $this->db->table('hasil');
        // Gunakan COUNT(DISTINCT column_name) untuk menghitung jumlah nilai unik
        $builder->select('COUNT(DISTINCT kode_hasil) as jumlah_unik');
        $query = $builder->get();

        return $query->getRow()->jumlah_unik; // Mengembalikan jumlah unik sebagai integer
    }

    // untuk pie chart
    public function getPieChart()
    {
        // Mengakses database dan mempersiapkan query
        $builder = $this->db->table('hasil');

        // Menulis conditional count sebagai parameter dari select()
        $builder->select("
        SUM(CASE WHEN (nilai * 100) > 0 AND (nilai * 100) <= 70 THEN 1 ELSE 0 END) AS jumlah_ditolak,
        SUM(CASE WHEN (nilai * 100) > 70 AND (nilai * 100) <= 80 THEN 1 ELSE 0 END) AS jumlah_disetujui_jaminan_memadai,
        SUM(CASE WHEN (nilai * 100) > 80 AND (nilai * 100) <= 90 THEN 1 ELSE 0 END) AS jumlah_disetujui_jaminan_pengamatan,
        SUM(CASE WHEN (nilai * 100) > 90 AND (nilai * 100) <= 100 THEN 1 ELSE 0 END) AS jumlah_disetujui_tanpa_jaminan,
        COUNT(*) AS total
    ", false); // false untuk mencegah CI4 dari mengecek nama field atau tabel

        // Menjalankan query dan mendapatkan hasilnya
        $query = $builder->get();

        // Mengambil hasil query
        $result = $query->getRowArray(); // Untuk single row, atau getResultArray() untuk multiple rows

        // Menghitung persentase
        $jumlah_ditolak_persen = ($result['jumlah_ditolak'] / $result['total']) * 100;
        $jumlah_disetujui_jaminan_memadai_persen = ($result['jumlah_disetujui_jaminan_memadai'] / $result['total']) * 100;
        $jumlah_disetujui_jaminan_pengamatan_persen = ($result['jumlah_disetujui_jaminan_pengamatan'] / $result['total']) * 100;
        $jumlah_disetujui_tanpa_jaminan_persen = ($result['jumlah_disetujui_tanpa_jaminan'] / $result['total']) * 100;

        // Membuat output dengan persentase dan jumlah
        return [
            'jumlah_ditolak' => [
                'persen' => number_format($jumlah_ditolak_persen, 2),
                'jumlah' => $result['jumlah_ditolak']
            ],
            'jumlah_disetujui_jaminan_memadai' => [
                'persen' => number_format($jumlah_disetujui_jaminan_memadai_persen, 2),
                'jumlah' => $result['jumlah_disetujui_jaminan_memadai']
            ],
            'jumlah_disetujui_jaminan_pengamatan' => [
                'persen' => number_format($jumlah_disetujui_jaminan_pengamatan_persen, 2),
                'jumlah' => $result['jumlah_disetujui_jaminan_pengamatan']
            ],
            'jumlah_disetujui_tanpa_jaminan' => [
                'persen' => number_format($jumlah_disetujui_tanpa_jaminan_persen, 2),
                'jumlah' => $result['jumlah_disetujui_tanpa_jaminan']
            ]
        ];
    }


    // untuk bar chart
    public function getBarChart($tahun)
    {
        $query = $this->db->query("
        SELECT 
            id_bulan,
            id_tahun,
            SUM(CASE 
                    WHEN (nilai * 100) > 0 AND (nilai * 100) <= 70 THEN 1 ELSE 0 
                END) AS jumlah_ditolak,
            SUM(CASE 
                    WHEN (nilai * 100) > 70 AND (nilai * 100) <= 80 THEN 1 ELSE 0 
                END) AS jumlah_disetujui_jaminan_memadai,
            SUM(CASE 
                    WHEN (nilai * 100) > 80 AND (nilai * 100) <= 90 THEN 1 ELSE 0 
                END) AS jumlah_disetujui_jaminan_pengamatan,
            SUM(CASE 
                    WHEN (nilai * 100) > 90 AND (nilai * 100) <= 100 THEN 1 ELSE 0 
                END) AS jumlah_disetujui_tanpa_jaminan
        FROM 
            hasil
        WHERE 
            id_tahun = ?
        GROUP BY 
            id_bulan, id_tahun
        ORDER BY 
            id_bulan ASC
    ", [$tahun]);

        return $query->getResultArray();
    }




    public function hitungStatusPerBulanPerTahun($tahun)
    {
        $builder = $this->db->table('hasil');

        $builder->select('id_bulan, 
                          SUM(CASE WHEN status = "layak" THEN 1 ELSE 0 END) as jumlah_layak,
                          SUM(CASE WHEN status = "tidak layak" THEN 1 ELSE 0 END) as jumlah_tidak_layak');
        $builder->where('id_tahun', $tahun);
        $builder->groupBy('id_bulan');
        $query = $builder->get();

        return $query->getResultArray();
    }
}
