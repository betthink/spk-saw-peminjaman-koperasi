<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
// $routes->get('/dashboard', 'Dashboard::index');
$routes->get('/dashboard/pieChart', 'Dashboard::pieChart');
$routes->get('/dashboard/barChart/(:any)', 'Dashboard::barChart/$1');
$routes->get('/dashboard/chart/periode/(:any)', 'Dashboard::index/$1');

// login
$routes->get('/login', 'Auth::index');
$routes->post('/login/auth', 'Auth::auth');
// logout
$routes->get('/logout', 'Auth::logout');

// routes data users
$routes->get('/users', 'Users::index');
$routes->get('/profile-user', 'Users::profile');
$routes->get('/users/tambah', 'Users::tambah');
$routes->get('/users/simpan', 'Users::simpan');
$routes->post('/users/simpan', 'Users::simpan');
$routes->get('/users/edit/(:num)', 'Users::edit/$1');
$routes->post('/users/update/(:num)', 'Users::update/$1');
$routes->delete('/users/hapus/(:num)', 'Users::delete/$1');

// routes data kriteria
$routes->get('/kriteria', 'Kriteria::index');
$routes->get('/kriteria/kode', 'Kriteria::autoKode');
$routes->get('/kriteria/tambah', 'Kriteria::tambah');
$routes->post('/kriteria/simpan', 'Kriteria::simpan');
$routes->get('/kriteria/edit/(:num)', 'Kriteria::edit/$1');
$routes->post('/kriteria/update/(:num)', 'Kriteria::update/$1');
$routes->delete('/kriteria/hapus/(:num)', 'Kriteria::delete/$1');

// routes data sub kriteria
$routes->get('/sub-kriteria', 'Kriteria::indexSubKriteria');
$routes->get('/sub-kriteria/tambah/(:num)', 'Kriteria::tambahSubKriteria/$1');
$routes->post('/sub-kriteria/simpan/(:num)', 'Kriteria::simpanSubKriteria/$1');
$routes->get('/sub-kriteria/edit/(:num)', 'Kriteria::editSubKriteria/$1');
$routes->post('/sub-kriteria/update/(:num)', 'Kriteria::updateSubKriteria/$1');
$routes->delete('/sub-kriteria/hapus/(:num)', 'Kriteria::deleteSubKriteria/$1');

// routes data alternatif
$routes->get('/nasabah', 'Alternatif::index');
$routes->get('/nasabah/periode/(:any)/(:any)', 'Alternatif::index/$1/$2');
$routes->get('/nasabah/tambah', 'Alternatif::tambah');
$routes->get('/nasabah/tambah/periode/(:any)/(:any)', 'Alternatif::tambah/$1/$2');
$routes->get('/nasabah/kode', 'Alternatif::autoKode');
$routes->post('/nasabah/simpan', 'Alternatif::simpan');
$routes->get('/nasabah/edit/(:num)', 'Alternatif::edit/$1');
$routes->post('/nasabah/update/(:num)', 'Alternatif::update/$1');
$routes->delete('/nasabah/hapus/(:num)', 'Alternatif::delete/$1');

// route data penilaian
$routes->get('/penilaian', 'Penilaian::index');
$routes->get('/penilaian/periode/(:any)/(:any)', 'Penilaian::index/$1/$2');
$routes->get('/penilaian/tambah/(:num)', 'Penilaian::tambah/$1');
$routes->post('/penilaian/simpan/(:num)', 'Penilaian::simpan/$1');
$routes->get('/penilaian/edit/(:num)', 'Penilaian::edit/$1');
$routes->post('/penilaian/update/(:num)', 'Penilaian::update/$1');
$routes->delete('/alternatif/hapus/(:num)', 'Alternatif::delete/$1');
// skala rating
$routes->get('/penilaian/skala-rating/(:any)', 'Penilaian::penentuan_skala_rating/$1');
$routes->post('/penilaian/skala-rating/(:any)', 'Penilaian::penentuan_skala_rating/$1');
$routes->get('/skala-rating/edit/(:any)', 'Penilaian::edit_skala/$1');
$routes->post('/skala-rating/edit/(:any)', 'Penilaian::updateSkalaPenilaian/$1');

// perhitungan
$routes->get('/perhitungan', 'HitungMetode::index');
$routes->get('/perhitungan/periode/(:any)/(:any)', 'HitungMetode::index/$1/$2');
$routes->post('/perhitungan/simpan', 'HitungMetode::simpanData');

// route hasil
$routes->get('/hasil', 'Hasil::index');
$routes->get('/hasil/periode/(:any)/(:any)', 'Hasil::index/$1/$2');
$routes->get('/hasil/cetak/periode/(:any)/(:any)', 'Hasil::cetak/$1/$2');
$routes->get('/hasil/hapus/periode/(:any)/(:any)', 'Hasil::hapus/$1/$2');
$routes->get('/hasil/unduh/periode/(:any)/(:any)', 'Hasil::generateExcel/$1/$2');
