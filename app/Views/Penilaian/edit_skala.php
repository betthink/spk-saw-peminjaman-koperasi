<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card mt-3 shadow-sm">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
        <h6 class="text-muted">Edit Skala rating <?= $idAlternatif['alternatif'] ?></h6>

        <span class="text">Kembali</span>
        </a>
    </div>
    <form action="" method="post">

        <?= csrf_field() ?>
        <div class="card-body px-5 py-4 mb-2">
            <!-- karakter -->
            <div class="card">
                <div class="card-header">
                    Karakter
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label class="form-label">Kebiasaan yang baik dalam membayar pinjaman di CU?</label>
                                    <select name="karakternilai[<?= $dataSkala[0]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="4" <?= $dataSkala[0]['value'] == 4 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[0]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Kebiasaan yang baik dalam membayar pinjaman di tempat lain?</label>
                                    <select name="karakternilai[<?= $dataSkala[1]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="4" <?= $dataSkala[1]['value'] == 4 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[1]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Reputasi yang baik dikalangan dunia bisnis dan organisasi lainnya?</label>
                                    <select name="karakternilai[<?= $dataSkala[2]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[2]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[2]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Yang bersangkutan adalah orang berpengaruh dimasyarakat?</label>
                                    <select name="karakternilai[<?= $dataSkala[3]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[3]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[3]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Memiliki tempat tinggal permanen (rumah pribadi) ?</label>
                                    <select name="karakternilai[<?= $dataSkala[4]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="0" <?= $dataSkala[4]['value'] == 0 ? 'selected' : '' ?>>Lama < 2 tahun</option>
                                        <option value="1" <?= $dataSkala[4]['value'] == 1 ? 'selected' : '' ?>>Lama 3-5 tahun</option>
                                        <option value="2" <?= $dataSkala[4]['value'] == 2 ? 'selected' : '' ?>>Lama > 5 tahun</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Hubungan baik dengan Dengan keluarga?</label>
                                    <select name="karakternilai[<?= $dataSkala[5]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[5]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[5]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label class="form-label">Hubungan baik dengan Di tempat kerja?</label>
                                    <select name="karakternilai[<?= $dataSkala[6]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[6]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[6]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Hubungan baik dengan Di masyarakat?</label>
                                    <select name="karakternilai[<?= $dataSkala[7]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[7]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[7]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- kemampuan dalam membayar pinjaman  -->
            <div class="card">
                <div class="card-header">
                    Capacity to Pay (kemampuan dalam membayar pinjaman)
                </div>
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah yang bersangkutan memiliki bisnis/gaji yang stabil?</label>
                                    <select name="nilaiCapacitytoPay[<?= $dataSkala[8]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="0" <?= $dataSkala[8]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                        <option value="3" <?= $dataSkala[8]['value'] == 3 ? 'selected' : '' ?>>Lama < 5 tahun</option>
                                        <option value="5" <?= $dataSkala[8]['value'] == 5 ? 'selected' : '' ?>>Lama > 5 tahun</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah tujuan pinjaman yang bersangkutan mampu mendapatkan keuntungan yang bersih?</label>
                                    <select name="nilaiCapacitytoPay[<?= $dataSkala[9]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="10" <?= $dataSkala[9]['value'] == 10 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[9]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah bisnis/gaji yang bersangkutan berkembang selama beberapa tahun terakhir?</label>
                                    <select name="nilaiCapacitytoPay[<?= $dataSkala[10]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="5" <?= $dataSkala[10]['value'] == 5 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[10]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah pemasukan dari usaha cukup untuk membayar angsuran dan bunga pinjaman?</label>
                                    <select name="nilaiCapacitytoPay[<?= $dataSkala[11]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="20" <?= $dataSkala[11]['value'] == 20 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[11]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah ROI (Return of Investment=laba atas investasi) bisnis/gaji yang bersangkutan mencukupi untuk membayar pinjaman?</label>
                                    <select name="nilaiCapacitytoPay[<?= $dataSkala[12]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="5" <?= $dataSkala[12]['value'] == 5 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[12]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah jangka waktu pengembalian pinjaman sesuai dengan jangka waktu hidup bisnis/gaji yang bersangkutan?</label>
                                    <select name="nilaiCapacitytoPay[<?= $dataSkala[13]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="5" <?= $dataSkala[13]['value'] == 5 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[13]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label">Apakah yang bersangkutan masih punya sisa pinjaman di tempat lain?</label>
                                    <select name="nilaiCapacitytoPay[<?= $dataSkala[14]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="5" <?= $dataSkala[14]['value'] == 5 ? 'selected' : '' ?>>Ya</option>
                                        <option value="20" <?= $dataSkala[14]['value'] == 20 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- barang jaminan  -->
            <div class="card">
                <div class="card-header">
                    Coolateral (Barang jaminan)
                </div>
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-12 mb-3">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah barang jaminan yang ditawarkan dapat diubah menjadi uang tunai dengan mudah setiap saat?</label>
                                    <select name="coolateralnilai[<?= $dataSkala[15]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[15]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[15]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah nilai barang jaminan lebih tinggi daripada jumlah pinjaman yang diajukan dan sesuai kebijakan penilaian barang jaminan?</label>
                                    <select name="coolateralnilai[<?= $dataSkala[16]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[16]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[16]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah barang jaminannya mudah disita?</label>
                                    <select name="coolateralnilai[<?= $dataSkala[17]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[17]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[17]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah para penjamin bersedia menjaminkan simpanannya atau bersedia dipotong gajinya apabila yang dijaminnya menunggak?</label>
                                    <select name="coolateralnilai[<?= $dataSkala[18]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[18]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[18]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah suami/istri yang bersangkutan mengetahui dan menyetujui permohonan pinjaman ini?</label>
                                    <select name="coolateralnilai[<?= $dataSkala[19]['id_skala'] ?>]" class="form-control" required>
                                        <option disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[19]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[19]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <!-- Capital /  Modal  -->
            <div class="card">
                <div class="card-header">
                    Capital (Modal)
                </div>
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah yang bersangkutan menabung secara teratur di CU?</label>
                                    <select name="capitalnilai[<?= $dataSkala[20]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1.5" <?= $dataSkala[20]['value'] == 1.5 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[20]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah ada harta pribadi, tabungan dan asset-asset usaha yang dapat dijadikan jaminan pinjaman?</label>
                                    <select name="capitalnilai[<?= $dataSkala[21]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1.5" <?= $dataSkala[21]['value'] == 1.5 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[21]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah asset-asset yang bersangkutan bertambah terus?</label>
                                    <select name="capitalnilai[<?= $dataSkala[22]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[22]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[22]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah kekayaan bersih yang bersangkutan bertambah setiap tahun?</label>
                                    <select name="capitalnilai[<?= $dataSkala[23]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[23]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[23]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- kondisi pinjaman  -->
            <div class="card">
                <div class="card-header">
                    Credit Condition (kondisi pinjaman)
                </div>
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-12 mb-3">
                            <div class="row">

                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah proyek/bisnis yang bersangkutan ramah lingkungan dan legal?</label>
                                    <select name="creditconditionnilai[<?= $dataSkala[24]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[24]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[24]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah kondisi cuaca sangat berpengaruh atas proyek/bisnis yang akan didanai dari pinjaman ini?</label>
                                    <select name="creditconditionnilai[<?= $dataSkala[25]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[25]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[25]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah pasar dapat menerima proyek ini?</label>
                                    <select name="creditconditionnilai[<?= $dataSkala[26]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="2" <?= $dataSkala[26]['value'] == 2 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[26]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah secara ekonomi masyarakat aktif menjamin kesuksesan proyek/bisnis ini?</label>
                                    <select name="creditconditionnilai[<?= $dataSkala[27]['id_skala'] ?>]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1" <?= $dataSkala[27]['value'] == 1 ? 'selected' : '' ?>>Ya</option>
                                        <option value="0" <?= $dataSkala[27]['value'] == 0 ? 'selected' : '' ?>>Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer text-right">
            <button name="submit" value="submit" type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-info btn-sm"><i class="fa fa-sync-alt"></i> Reset</button>
        </div>
    </form>
</div>

<?= $this->endSection('content') ?>