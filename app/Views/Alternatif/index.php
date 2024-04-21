<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card mt-3 shadow-sm">
    <!-- /.card-header -->
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-cogs" aria-hidden="true"></i> Pilih Periode</h6>
        <a href="<?= base_url('/nasabah/tambah/') ?>" class="btn btn-sm btn-primary <?= $bulan != null ? 'd-none' : '' ?> <?= $_SESSION['role'] == 1 ? '' : 'd-none' ?>">
            <i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah
        </a>
    </div>
    <form id="periodeForm">
        <div class="row mt-3">
            <div class="col-md-3">
                <div class="card-body">
                    <select class="form-select" name="bulan" id="bulan">
                        <option value="#" disabled selected>-- Pilih Bulan --</option>
                        <?php foreach ($dataBulan as $key => $month) : ?>
                            <option value="<?= $key + 1 ?>" <?= ($key + 1) == $bulan ? 'selected' : '' ?>><?= $month ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-body">
                    <select class="form-select" name="tahun" id="tahun">
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

<!-- notifikasi pesan -->
<?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan') ?>
<?php endif ?>
<!-- cek apakah ada data alternatif -->
<?php if (!empty($alternatif)) : ?>
    <div class="card mt-4 shadow-sm">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Data Nasabah</h6>
            <a href="<?= base_url('/nasabah/tambah/periode/') . $bulan . "/" . $tahun ?>" class="btn btn-sm btn-primary <?= $bulan == null ? 'd-none' : '' ?> <?= $_SESSION['role'] == 1 ? '' : 'd-none' ?>">
                <i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah
            </a>
        </div>
        <div class="card-body m-2">
            <div class="table-responsive">
                <table id="myTable" class="table table-striped">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tgl Lahir</th>
                        <th>Alamat</th>
                        <th>Gender</th>
                        <th>No. Telp</th>
                        <th class="<?= $_SESSION['role'] == 1 ? '' : 'd-none' ?>">Aksi</th>
                    </thead>
                    <tbody>
                        <?php $no = 1 ?>
                        <?php foreach ($alternatif as $row) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['alternatif'] ?></td>
                                <td><?= $row['tgl_lahir'] ?></td>
                                <td><?= $row['alamat'] ?></td>
                                <td><?= $row['jns_kelamin'] == "l" ? "Laki-laki" : "Perempuan" ?></td>
                                <td><?= $row['no_telp'] ?></td>
                                <td class="<?= $_SESSION['role'] == 1 ? '' : 'd-none' ?>">
                                    <form action="<?= base_url('/nasabah/edit') ?>/<?= $row['id_alternatif'] ?>" method="get" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="bulan" value="<?= $bulan ?>">
                                        <input type="hidden" name="tahun" value="<?= $tahun ?>">
                                        <input type="hidden" name="_method" value="GET">
                                        <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                    </form>
                                    <!-- <form action="/nasabah/hapus/<?= $row['id_alternatif'] ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah yakin?')">Hapus</button>
                                    </form> -->
                                </td>
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