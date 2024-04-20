<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card mt-3 shadow-sm">
        <!-- /.card-header -->
        <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-cogs" aria-hidden="true"></i> Pilih Periode</h6>
        </div>
        <form id="periodeForm">
                <div class="row mt-3">
                        <div class="col-md-3">
                                <div class="card-body">
                                        <select class="form-select" name="bulanH" id="bulanH">
                                                <option value="#" disabled selected>-- Pilih Bulan --</option>
                                                <?php foreach ($dataBulan as $key => $month) : ?>
                                                        <option value="<?= $key + 1 ?>" <?= ($key + 1) == $bulan ? 'selected' : '' ?>><?= $month ?></option>
                                                <?php endforeach ?>
                                        </select>
                                </div>
                        </div>
                        <div class="col-md-3">
                                <div class="card-body">
                                        <select class="form-select" name="tahunH" id="tahunH">
                                                <option value="#" disabled selected>-- Pilih Tahun --</option>
                                                <?php foreach ($dataTahun as $key => $year) : ?>
                                                        <option value="<?= 2 . $key + 2 ?>" <?= (2 . $key + 2) == $tahun ? 'selected' : '' ?>><?= $year ?></option>
                                                <?php endforeach ?>
                                        </select>
                                </div>
                        </div>
                </div>
        </form>
</div>

<!-- cek apakah ada data alternatif -->
<?php if (!empty($hasil)) : ?>
        <div class="card mt-4 shadow-sm">
                <div class="card-header py-3 d-flex justify-content-between">
                        <h6 class="m-0 font-weight-bold text-dark align-self-center"><i class="fa fa-table"></i> Data Hasil</h6>
                        <div class="<?= $bulan == null ? 'd-none' : '' ?>">
                                <a class="btn btn-sm btn-primary align-self-center" href="<?= base_url('/hasil/cetak/periode') ?>/<?= $bulan . '/' . $tahun ?>"><i class="fa fa-print" aria-hidden="true"></i> Cetak</a>
                                <a class="btn btn-sm btn-danger align-self-center <?= $_SESSION['role'] == 1 ? '' : 'd-none' ?>" href="<?= base_url('/hasil/hapus/periode') ?>/<?= $bulan . '/' . $tahun ?>" onclick="return confirm('Apakah yakin?')"><i class="fa fa-trash" aria-hidden="true"></i> Hapus</a>
                        </div>
                </div>
                <div class="card-body m-2">
                        <div class="table-responsive">
                                <table id="#" class="table table-striped">
                                        <thead>
                                                <th>No</th>
                                                <th>Nama Nasabah</th>
                                                <th>Nilai Preferensi</th>
                                                <th>Status</th>
                                        </thead>
                                        <tbody>
                                                <?php $no = 1 ?>
                                                <?php foreach ($hasil as $row) : ?>
                                                        <tr>
                                                                <td><?= $no++ ?></td>
                                                                <td><?= $row['alternatif'] ?></td>
                                                                <td><?= $row['nilai'] ?></td>
                                                                <td class="fw-bold text-danger"><?= $row['status'] ?></td>
                                                        </tr>
                                                <?php endforeach ?>
                                        </tbody>
                                </table>
                        </div>
                </div>
        </div>
        <!-- jika tidak ada data tampilkan pesan -->
<?php else : ?>
        <div class="alert alert-info mt-5" role="alert">
                Data tidak ada atau Silakan pilih bulan dan tahun terlebih dahulu untuk menampilkan data!
        </div>
<?php endif ?>

<?= $this->endSection('content') ?>