<?php

namespace App\Models;

use CodeIgniter\Model;

class SkalaPenilaianModel extends Model
{
    protected $table      = 'skala_penilaian';
    protected $primaryKey = 'id_skala';
    // Tentukan kolom-kolom yang diizinkan untuk diisi secara massal
    protected $allowedFields = ['id_kriteria', 'name_value', 'value', 'id_user'];
    protected $useAutoIncrement = true;



    public function insertDataSkala($id_user, $data)
    {
        // Kolom yang akan digunakan
        $columns = ["karakternilai", "nilaiCapacitytoPay", "coolateralnilai", "capitalnilai", "creditconditionnilai"];
        // Pemetaan antara nama kolom dan id kriteria
        $kriteriaMapping = [
            "karakternilai" => 7,
            "nilaiCapacitytoPay" => 8,
            "coolateralnilai" => 9,
            "capitalnilai" => 10,
            "creditconditionnilai" => 11
        ];
        // Iterasi melalui data
        foreach ($data as $key => $values) {
            // Cek apakah key ada dalam kolom yang akan digunakan
            if (in_array($key, $columns)) {
                // Dapatkan id kriteria berdasarkan nama kolom
                $id_kriteria = $kriteriaMapping[$key];

                // Iterasi melalui nilai pada array
                foreach ($values as $index => $value) {
                    // Bangun data untuk dimasukkan, termasuk id_user dan id_kriteria
                    $rowData = [
                        'id_user' => $id_user,
                        'id_kriteria' => $id_kriteria,
                        'name_value' => $key,
                        'value' => $value
                    ];

                    // Masukkan data ke dalam database
                    $this->insert($rowData);
                }
            }
        }
        // Mengembalikan true setelah selesai melakukan semua operasi penyisipan
        return true;
    }
    public function getDataByIdUser($id_user)
    {
        return $this->where('id_user', $id_user)->findAll();
    }
    public function updateDataSkala($postData)
    {
        // Memulai transaksi database
        $this->db->transStart();

        try {
            // Iterasi melalui array postData untuk mengupdate setiap nilai skala penilaian
            foreach ($postData as $columnName => $data) {
                // Jika kolom tidak valid, lanjutkan ke iterasi berikutnya
                // if (!in_array($columnName, $this->allowedFields)) {
                //     continue;
                // }

                // Iterasi melalui array data di dalam kolom
                foreach ($data as $idSkala => $value) {
                    // dd($idSkala);
                    // Lakukan update data skala penilaian
                    $this->update($idSkala, ['value' => $value]);
                }
            }

            // Commit transaksi database
            $this->db->transCommit();

            // Mengembalikan true jika pembaruan berhasil
            return true;
        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            $this->db->transRollback();

            // Mengembalikan false jika terjadi kesalahan
            return false;
        }
    }
}
