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

                    <div id="trafficChart" style="min-height: 385px; " class="echart"></div>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const pieApiUrl = '<?= site_url('dashboard/pieChart') ?>';

                            fetch(pieApiUrl)
                                .then(response => response.json())
                                .then(data => {
                                    const chartData = [{
                                            value: data.jumlah_ditolak.persen,
                                            name: 'Ditolak (' + data.jumlah_ditolak.persen + '% - ' + data.jumlah_ditolak.jumlah + ' nasabah)'
                                        },
                                        {
                                            value: data.jumlah_disetujui_jaminan_memadai.persen,
                                            name: 'Disetujui Jaminan Memadai (' + data.jumlah_disetujui_jaminan_memadai.persen + '% - ' + data.jumlah_disetujui_jaminan_memadai.jumlah + ' nasabah)'
                                        },
                                        {
                                            value: data.jumlah_disetujui_jaminan_pengamatan.persen,
                                            name: 'Disetujui Jaminan Pengamatan (' + data.jumlah_disetujui_jaminan_pengamatan.persen + '% - ' + data.jumlah_disetujui_jaminan_pengamatan.jumlah + ' nasabah)'
                                        },
                                        {
                                            value: data.jumlah_disetujui_tanpa_jaminan.persen,
                                            name: 'Disetujui Tanpa Jaminan (' + data.jumlah_disetujui_tanpa_jaminan.persen + '% - ' + data.jumlah_disetujui_tanpa_jaminan.jumlah + ' nasabah)'
                                        }
                                    ];

                                    echarts.init(document.querySelector("#trafficChart")).setOption({
                                        tooltip: {
                                            trigger: 'item'
                                        },
                                        legend: {
                                            top: '0%',
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
                                            data: chartData
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
                            const updateChart = (data) => {
                                const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

                                const dataDitolak = labels.map((label, index) => {
                                    const monthIndex = index + 1;
                                    const monthData = data.find(d => parseInt(d.id_bulan) === monthIndex);
                                    return monthData ? parseInt(monthData.jumlah_ditolak) : 0;
                                });

                                const dataDisetujuiJaminanMemadai = labels.map((label, index) => {
                                    const monthIndex = index + 1;
                                    const monthData = data.find(d => parseInt(d.id_bulan) === monthIndex);
                                    return monthData ? parseInt(monthData.jumlah_disetujui_jaminan_memadai) : 0;
                                });

                                const dataDisetujuiJaminanPengamatan = labels.map((label, index) => {
                                    const monthIndex = index + 1;
                                    const monthData = data.find(d => parseInt(d.id_bulan) === monthIndex);
                                    return monthData ? parseInt(monthData.jumlah_disetujui_jaminan_pengamatan) : 0;
                                });

                                const dataDisetujuiTanpaJaminan = labels.map((label, index) => {
                                    const monthIndex = index + 1;
                                    const monthData = data.find(d => parseInt(d.id_bulan) === monthIndex);
                                    return monthData ? parseInt(monthData.jumlah_disetujui_tanpa_jaminan) : 0;
                                });

                                const options = {
                                    series: [{
                                            name: 'Ditolak',
                                            data: dataDitolak
                                        },
                                        {
                                            name: 'Disetujui Jaminan Memadai',
                                            data: dataDisetujuiJaminanMemadai
                                        },
                                        {
                                            name: 'Disetujui Jaminan Pengamatan',
                                            data: dataDisetujuiJaminanPengamatan
                                        },
                                        {
                                            name: 'Disetujui Tanpa Jaminan',
                                            data: dataDisetujuiTanpaJaminan
                                        }
                                    ],
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
                                        categories: labels,
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
                                                return val;
                                            }
                                        }
                                    }
                                };

                                const chart = new ApexCharts(document.querySelector("#columnChart"), options);
                                chart.render();
                            };

                            document.getElementById('grafikTahun').addEventListener('change', function() {
                                const tahun = this.value;
                                const barApiUrl = `<?= site_url('dashboard/barChart/') ?>${tahun}`;

                                fetch(barApiUrl)
                                    .then(response => response.json())
                                    .then(data => {
                                        updateChart(data);
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