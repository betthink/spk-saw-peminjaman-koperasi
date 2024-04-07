<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
            <div class="row">

                <!-- Sales Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">

                        <div class="card-body">
                            <h5 class="card-title">Kriteria</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-journal-text"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?= $countKriteria ?></h6>
                                    <!-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Sales Card -->

                <!-- Revenue Card -->
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Nasabah</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-person-bounding-box"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?= $countAlternatif ?></h6>
                                    <!-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> -->

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->

                <!-- Customers Card -->
                <div class="col-xxl-4 col-md-6">

                    <div class="card info-card customers-card">

                        <div class="card-body">
                            <h5 class="card-title">Hasil </h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-box-arrow-up"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?= $countAlternatif ?></h6>
                                    <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->

                                </div>
                            </div>

                        </div>
                    </div>

                </div><!-- End Customers Card -->

                <!-- Customers Card -->
                <div class="col-xxl-4 col-md-6">

                    <div class="card info-card customers-card">

                        <div class="card-body">
                            <h5 class="card-title">User</h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?= $countUser ?></h6>
                                    <!-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> -->

                                </div>
                            </div>

                        </div>
                    </div>

                </div><!-- End Customers Card -->

            </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
            <!-- Website Traffic -->
            <div class="card">

                <div class="card-body pb-0">
                    <h5 class="card-title">Pie Chart <span>| Keseluruhan Data</span></h5>

                    <div id="trafficChart" style="min-height: 285px;" class="echart"></div>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const pieApiUrl = '<?= site_url('dashboard/pieChart') ?>';

                            fetch(pieApiUrl)
                                .then(response => response.json())
                                .then(data => {
                                    // Misalkan response dari API adalah objek dengan properti 'layak' dan 'tidakLayak'
                                    const layak = data.jumlah_layak;
                                    const tidakLayak = data.jumlah_tidak_layak;

                                    // Jumlahkan total untuk mendapatkan persentase
                                    const total = layak + tidakLayak;
                                    const layakPersen = (layak / total * 100).toFixed(2); // Menggunakan toFixed(2) untuk membatasi dua angka di belakang koma
                                    const tidakLayakPersen = (tidakLayak / total * 100).toFixed(2);
                                    // console.log(tidakLayakPersen);
                                    echarts.init(document.querySelector("#trafficChart")).setOption({
                                        tooltip: {
                                            trigger: 'item'
                                        },
                                        legend: {
                                            top: '5%',
                                            left: 'center'
                                        },
                                        series: [{
                                            name: 'Data Kelayakan',
                                            type: 'pie',
                                            radius: ['40%', '70%'],
                                            avoidLabelOverlap: false,
                                            label: {
                                                show: false,
                                                position: 'center'
                                            },
                                            emphasis: {
                                                label: {
                                                    show: true,
                                                    fontSize: '18',
                                                    fontWeight: 'bold'
                                                }
                                            },
                                            labelLine: {
                                                show: false
                                            },
                                            data: [{
                                                    value: layakPersen,
                                                    name: 'Layak (' + layakPersen + '%)',
                                                },
                                                {
                                                    value: tidakLayakPersen,
                                                    name: 'Tidak Layak (' + tidakLayakPersen + '%)',
                                                }
                                            ]
                                        }]
                                    });
                                })
                                .catch(error => console.error('Error fetching data:', error));
                        });
                    </script>

                </div>
            </div><!-- End Website Traffic -->
        </div><!-- End Right side columns -->
    </div><!-- End Right row 1 -->
    <div class="row">
        <!-- Reports -->
        <div class="col-12">
            <div class="card">

                <div class="filter">
                    <form id="periodeForm" class="mx-4">
                        <select class="form-select" name="grafikTahun" id="grafikTahun">
                            <option value="22" selected>-- Pilih Tahun --</option>
                            <?php foreach ($dataTahun as $key => $year) : ?>
                                <option value="<?= 2 . $key + 2 ?>" <?= (2 . $key + 2) == $tahun ? 'selected' : '' ?>><?= $year ?></option>
                            <?php endforeach ?>
                        </select>
                    </form>
                </div>

                <div class="card-body">
                    <h5 class="card-title">Reports <span>/Data pertahun</span></h5>

                    <!-- column Chart -->
                    <div id="columnChart"></div>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            document.getElementById('grafikTahun').addEventListener('change', function() {
                                // const tahun = 23;
                                const tahun = this.value;
                                const barApiUrl = `<?= site_url('dashboard/barChart/') ?>${tahun}`;
                                // console.log(barApiUrl);

                                fetch(barApiUrl)
                                    .then(response => response.json())
                                    .then(data => {
                                        const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                        const dataLayak = labels.map(label => {
                                            const monthIndex = labels.indexOf(label) + 1;
                                            const monthData = data.find(d => parseInt(d.id_bulan) === monthIndex);
                                            return monthData ? monthData.jumlah_layak : 0;
                                        });

                                        console.log(dataLayak);
                                        const dataTidakLayak = labels.map(label => {
                                            const monthIndex = labels.indexOf(label) + 1;
                                            const monthData = data.find(d => parseInt(d.id_bulan) === monthIndex);
                                            return monthData ? monthData.jumlah_tidak_layak : 0;
                                        });

                                        new ApexCharts(document.querySelector("#columnChart"), {
                                            series: [{
                                                name: 'Layak',
                                                data: dataLayak
                                            }, {
                                                name: 'Tidak Layak',
                                                data: dataTidakLayak
                                            }],
                                            chart: {
                                                type: 'bar',
                                                height: 350
                                            },
                                            plotOptions: {
                                                bar: {
                                                    horizontal: false,
                                                    columnWidth: '55%',
                                                    endingShape: 'rounded'
                                                },
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            stroke: {
                                                show: true,
                                                width: 2,
                                                colors: ['transparent']
                                            },
                                            xaxis: {
                                                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                            },
                                            yaxis: {
                                                title: {
                                                    text: '(data kelayakan)'
                                                }
                                            },
                                            fill: {
                                                opacity: 1
                                            },
                                            tooltip: {
                                                y: {
                                                    formatter: function(val) {
                                                        return val
                                                    }
                                                }
                                            }
                                        }).render();
                                    })
                                    .catch(error => console.error('Error fetching data:', error));
                            });
                        });
                    </script>
                    <!-- End Line Chart -->

                </div>

            </div>
        </div><!-- End Reports -->
    </div>
</section>

<?= $this->endSection('content') ?>