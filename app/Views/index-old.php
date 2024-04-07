<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="border-0 mx-5 h-75">
    <div class="container d-flex justify-content-between mt-3">
        <h6></h6>
        <div class="btn-group">
            <button class="btn btn-outline-info rounded-pill btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user"></i> <?= ucfirst($_SESSION['username']) ?>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Profil</a></li>
                <li><a class="dropdown-item" href="<?= site_url('/logout') ?>">Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="container bg-primary rounded shadow-lg mt-3">
        <div class="row">
            <div class="col-md-6 text-center">
                <img src="<?= base_url('icon/criteria.png') ?>" class="align-self-center p-3" width="250" alt="">
            </div>
            <div class="col-md-6 text-white align-self-center">
                <h1>Aplikasi SPK</h1>
                <h5 class="mt-2 mb-3">Metode SAW (<i>Simple Additive Weighting</i>)</h5>
                <a href="/dashboard" class="btn rounded-pill btn-outline-light">Dashboard</a>
            </div>
        </div>
    </div>

    <!-- menu -->
    <div class="row mt-3">
        <?php if ($_SESSION['role'] == 1) : ?>
            <div class="col-xl-3 col-md-4">
                <a href="<?= base_url('/kriteria') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-lg mb-3" id="menu">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="card-title align-self-center fw-bold">Kriteria</h6>
                                <span><i class="fas fa-clipboard"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-md-4 <?= $adaPilihan == '0' ? 'd-none' : '' ?>">
                <a href="<?= base_url('/sub-kriteria') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-lg mb-3" id="menu">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="card-title align-self-center fw-bold">Sub Kriteria</h6>
                                <span><i class="fas fa-clipboard-list"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif ?>
        <div class="col-xl-3 col-md-4">
            <a href="<?= base_url('/nasabah') ?>" class="text-decoration-none">
                <div class="card border-0 shadow-lg mb-3" id="menu">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h6 class="card-title align-self-center fw-bold">Nasabah</h6>
                            <span><i class="fa fa-users" aria-hidden="true"></i></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php if ($_SESSION['role'] == 1) : ?>
            <div class="col-xl-3 col-md-4">
                <a href="<?= base_url('/penilaian') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-lg mb-3" id="menu">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="card-title align-self-center fw-bold">Penilaian</h6>
                                <span><i class="fas fa-keyboard"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif ?>
        <div class="col-xl-3 col-md-4">
            <a href="<?= base_url('/perhitungan') ?>" class="text-decoration-none">
                <div class="card border-0 shadow-lg mb-3" id="menu">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h6 class="card-title align-self-center fw-bold">Perhitungan</h6>
                            <span><i class="fas fa-calculator"></i></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-3 col-md-4">
            <a href="<?= base_url('/hasil') ?>" class="text-decoration-none">
                <div class="card border-0 shadow-lg mb-3" id="menu">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h6 class="card-title align-self-center fw-bold">Hasil</h6>
                            <span><i class="fas fa-poll"></i></span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php if ($_SESSION['role'] == 1) : ?>
            <div class="col-xl-3 col-md-4">
                <a href="<?= base_url('/users') ?>" class="text-decoration-none">
                    <div class="card border-0 shadow-lg mb-3" id="menu">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="card-title align-self-center fw-bold">Users</h6>
                                <span><i class="fas fa-user"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif ?>
    </div>
</div>

<?= $this->endSection('content') ?>