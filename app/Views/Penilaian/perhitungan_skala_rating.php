<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card mt-3 shadow-sm">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
        <h6 class="text-muted">Input Skala rating <?= $idAlternatif['alternatif'] ?></h6>

        <span class="text">Kembali</span>
        </a>
    </div>
    <form action="/penilaian/simpan/<?= $idAlternatif['id_alternatif'] ?>" method="post">

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
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="4">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Kebiasaan yang baik dalam membayar pinjaman di tempat lain?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="4">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Reputasi yang baik dikalangan dunia bisnis dan organisasi lainnya</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Yang bersangkutan adalah orang berpengaruh dimasyarakat?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Memiliki tempat tinggal permanen (rumah pribadi)</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="0">Lama < 2 tahun</option>
                                        <option value="1">Lama 3-5 tahun</option>
                                        <option value="2">Lama > 5 tahun</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Hubungan baik dengan sesama</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1">Dengan keluarga</option>
                                        <option value="1">Di tempat kerja</option>
                                        <option value="1">Di masyarakat</option>
                                        <option value="1">Tidak ada diatas</option>
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
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="0">Tidak</option>
                                        <option value="3">Lama < 5 tahun</option>
                                        <option value="5">Lama > 5 tahun</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah tujuan pinjaman yang bersangkutan mampu mendapatkan keuntungan yang bersih?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="10">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah bisnis/gaji yang bersangkutan berkembang selama beberapa tahun terakhir?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="5">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah pemasukan dari usaha cukup untuk membayar angsuran dan bunga pinjaman?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="20">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah ROI (Return of Investment=laba atas investasi) bisnis/gaji yang bersangkutan mencukupi untuk membayar pinjaman</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="5">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah jangka waktu pengembalian pinjaman sesuai dengan jangka waktu hidup bisnis/gaji yang bersangkutan?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="5">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="form-label">Apakah yang bersangkutan masih punya sisa pinjaman di tempat lain?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="5">Ya</option>
                                        <option value="20">Tidak</option>
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
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah nilai barang jaminan lebih tinggi daripada jumlah pinjaman yang diajukan dan sesuai kebijakan penilaian barang jaminan?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah barang jaminannya mudah disita?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah para penjamin bersedia menjaminkan simpanannya atau bersedia dipotong gajinya apabila yang dijaminnya menunggak?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah suami/istri yang bersangkutan mengetahui dan menyetujui permohonan pinjaman ini?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option disabled selected>-- pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
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
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1.5">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah ada harta pribadi, tabungan dan asset-asset usaha yang dapat dijadikan jaminan pinjaman?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1.5">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah barang jaminannya mudah disita?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah asset-asset yang bersangkutan bertambah terus?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah kekayaan bersih yang bersangkutan bertambah setiap tahun?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option disabled selected>-- pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
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
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah kondisi cuaca sangat berpengaruh atas proyek/bisnis yang akan didanai dari pinjaman ini?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah pasar dapat menerima proyek ini?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="2">Ya</option>
                                        <option value="0">Tidak</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">Apakah secara ekonomi masyarakat aktif menjamin kesuksesan proyek/bisnis ini?</label>
                                    <select name="nilai[]" class="form-control" required>
                                        <option value="#" disabled selected>-- pilih --</option>
                                        <option value="1">Ya</option>
                                        <option value="0">Tidak</option>
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