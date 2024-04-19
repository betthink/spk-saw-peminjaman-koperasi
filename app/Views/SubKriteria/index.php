<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<!-- table data subkriteria -->
<?php if (session()->getFlashdata('pesan')) : ?>
    <?= session()->getFlashdata('pesan') ?>
<?php endif ?>
<?php foreach ($subkriteriaData as $data) : ?>
    <div class="card mt-3 shadow-sm">
        <div class="card-header d-flex justify-content-between">
            <h6 class="text-muted">Data Subkriteria untuk Kriteria "<b><?= ucwords($data['kriteria']['kriteria']) ?></b>"</h6>
            <form action="<?= base_url('/sub-kriteria/tambah') ?>/<?= $data['kriteria']['id_kriteria'] ?>" method="get" class="d-inline">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="GET">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah</button>
            </form>
        </div>

        <div class="card-body m-2">

            <div class="table-responsive">

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <th>No</th>
                                <th>Nama Sub Kriteria</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($data['subkriteria'] as $subkriteriaItem) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $subkriteriaItem['sub_kriteria'] ?></td>
                                        <td><?= $subkriteriaItem['nilai'] ?></td>
                                        <td>
                                            <form action="<?= base_url('/sub-kriteria/edit') ?>/<?= $subkriteriaItem['id_sub_kriteria'] ?>" method="get" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="id_kriteria" value="<?= $subkriteriaItem['id_kriteria'] ?>">
                                                <input type="hidden" name="_method" value="GET">
                                                <button type="submit" class="btn btn-sm btn-warning">Edit</button>
                                            </form>
                                            <form action="<?= base_url('/sub-kriteria/hapus') ?>/<?= $subkriteriaItem['id_sub_kriteria'] ?>" method="post" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah yakin?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach ?>

<?= $this->endSection('content') ?>