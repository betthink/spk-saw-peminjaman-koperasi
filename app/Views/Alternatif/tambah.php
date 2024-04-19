<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="card mt-3 shadow-sm">
    <div class="card-header d-sm-flex align-items-center justify-content-between">
        <h6 class="text-muted">Tambah Data Nasabah</h6>

    </div>

    <form action="<?= site_url('/nasabah/simpan') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="card-body px-5 py-4 mb-4">
            <div class="row">
                <?php if ($bulan == null) : ?>
                    <div class="form-group col-md-6 mt-2">
                        <label class="form-label">Periode Bulan</label>
                        <select class="form-control" name="bulan">
                            <option value="#" disabled selected>-- Pilih Bulan --</option>
                            <?php foreach ($dataBulan as $key => $bulan) : ?>
                                <option value="<?= $key + 1 ?>"><?= $bulan ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label class="form-label">Periode Tahun</label>
                        <select class="form-control" name="tahun">
                            <option value="#" disabled selected>-- Pilih Tahun --</option>
                            <?php foreach ($dataTahun as $key => $tahun) : ?>
                                <option value="<?= 2 . $key + 2 ?>"><?= $tahun ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                <?php else : ?>
                    <div class="form-group col-md-6 mt-2">
                        <label class="form-label">Periode Bulan</label>
                        <select class="form-control" name="bulan">
                            <?php foreach ($dataBulan as $key => $bln) : ?>
                                <option value="<?= $key + 1 ?>" <?= ($key + 1) == $bulan ? "selected" : ""  ?> ><?= $bln ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group col-md-6 mt-2">
                        <label class="form-label">Periode Tahun</label>
                        <select class="form-control" name="tahun">
                            <option value="<?= $tahun ?>" selected><?= "20" . $tahun ?></option>
                        </select>
                    </div>
                <?php endif ?>
            </div>
            <div class="row mt-4">
                <div class="form-group col-md-6 mt-2">
                    <label class="form-label">Nama Nasabah</label>
                    <input autocomplete="off" type="text" name="alternatif" class="form-control <?= ($validation->hasError('alternatif')) ? 'is-invalid' : ''; ?>" placeholder="Masukan Nama Nasabah" />
                    <div class="invalid-feedback">
                        <?= $validation->getError('alternatif'); ?>
                    </div>
                </div>
                <div class="form-group col-md-6 mt-2">
                    <label class="form-label">Tgl Lahir</label>
                    <input autocomplete="off" type="date" name="tglLahir" class="form-control <?= ($validation->hasError('tglLahir')) ? 'is-invalid' : ''; ?>" placeholder="Masukan Tgl Lahir" />
                    <div class="invalid-feedback">
                        <?= $validation->getError('tglLahir'); ?>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="form-group col-md-6 mt-2">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-control" name="jnsKelamin">
                        <option value="#" disabled selected>-- Pilih Jenis Kelamin --</option>
                        <option value="l">Laki-laki</option>
                        <option value="p">Perempuan</option>
                    </select>
                </div>
                <div class="form-group col-md-6 mt-2">
                    <label class="form-label">No Telp</label>
                    <input autocomplete="off" type="text" name="noTelp" class="form-control <?= ($validation->hasError('noTelp')) ? 'is-invalid' : ''; ?>" placeholder="Masukan No Telp" />
                    <div class="invalid-feedback">
                        <?= $validation->getError('noTelp'); ?>
                    </div>
                </div>
            </div>
                <div class="form-group col-md-6">
                    <label class="form-label">Alamat Nasabah</label>
                    <textarea name="alamat" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?> id="" cols=" 30" rows="3" placeholder="Masukan Alamat Nasabah"></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('alamat'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button name="submit" value="submit" type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
            <a href="<?= base_url('/nasabah/periode/') . $bulan . '/' . $tahun ?>" class="btn btn-info btn-sm"></span>
                <span class="text">Kembali</span>
            </a>
            <!-- <button type="reset" class="btn btn-info btn-sm"><i class="fa fa-sync-alt"></i> Reset</button> -->
        </div>
    </form>
</div>
<?= $this->endSection('content') ?>