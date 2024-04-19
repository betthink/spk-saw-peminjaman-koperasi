<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="row mt-5 mb-3">
    <div class="col-md-9">
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <a href="<?= base_url('/kriteria') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-lg mb-3" id="menu">
                        <div class="card-body">
                            <p class="fs-6 align-self-center fw-bold">Data Kriteria</p>
                            <div class="d-flex mt-3 justify-content-between">
                                <h3 class="align-self-center"><?= $countKriteria ?></h3>
                                <span class="align-self-center"><i class="fas fa-clipboard"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6">
                <a href="<?= base_url('/alternatif') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-lg mb-3" id="menu">
                        <div class="card-body">
                            <p class="fs-6 align-self-center fw-bold">Data Nasabah</p>
                            <div class="d-flex mt-3 justify-content-between">
                                <h3 class="align-self-center"><?= $countAlternatif ?></h3>
                                <span class="align-self-center"><i class="fa fa-users" aria-hidden="true"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6">
                <a href="<?= base_url('/hasil') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-lg mb-3" id="menu">
                        <div class="card-body">
                            <p class="fs-6 align-self-center fw-bold">Data Hasil</p>
                            <div class="d-flex mt-3 justify-content-between">
                                <h3 class="align-self-center"><?= $countHasil ?></h3>
                                <span class="align-self-center"><i class="fas fa-poll"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6">
                <a href="<?= base_url('/users') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-lg mb-3" id="menu">
                        <div class="card-body">
                            <p class="fs-6 align-self-center fw-bold">Data Users</p>
                            <div class="d-flex mt-3 justify-content-between">
                                <h3 class="align-self-center"><?= $countUser ?></h3>
                                <span class="align-self-center"><i class="fas fa-user"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="col-xs-12 text-center">
            <small>Pie Chart Keseluruhan Data</small>
        </div>
        <canvas class="mt-2" id="pieChart"></canvas>
    </div>
</div>
<div class="card border-0 shadow-lg">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form id="periodeForm">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card-body">
                                <select class="form-control" name="grafikTahun" id="grafikTahun">
                                    <option value="#" disabled selected>-- Pilih Tahun --</option>
                                    <?php foreach ($dataTahun as $key => $year) : ?>
                                        <option value="<?= 2 . $key + 2 ?>" <?= (2 . $key + 2) == $tahun ? 'selected' : '' ?>><?= $year ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                </form>
                <div class="col-md-6">
                    <div class="col-xs-12 text-center">
                        <p>Grafik Layak/Tidak Layak Pertahun</p>
                    </div>
                </div>
                <div class="col-md-3">
                </div>
            </div>
            <canvas class="mt-5" id="barChart"></canvas>
        </div>
    </div>
</div>
</div>

<?= $this->endSection('content') ?>