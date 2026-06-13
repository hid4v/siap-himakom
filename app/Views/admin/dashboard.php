<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>Dashboard Admin<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/admin_dashboard.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Content Header -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Dashboard Statistik</h1>
        <p class="text-muted mb-0 small">Overview data operasional sistem SIAP-HIMAKOM</p>
    </div>
    <div class="text-secondary small">
        <i class="bi bi-calendar3 me-1"></i> Tahun Ajaran: <strong><?= date('Y') ?></strong>
    </div>
</div>

<!-- Stats Cards Row (Solid small boxes) -->
<div class="row g-3 mb-2">
    <!-- Blue Card: Total Transaksi -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="small-box bg-box-blue">
            <div class="inner">
                <h3><?= $metrics['total_loans'] ?></h3>
                <p>Total Peminjaman</p>
            </div>
            <div class="icon">
                <i class="bi bi-cart"></i>
            </div>
            <a href="<?= base_url('admin/loans') ?>" class="small-box-footer">
                Selengkapnya <i class="bi bi-link-45deg ms-1"></i>
            </a>
        </div>
    </div>
    
    <!-- Green Card: Katalog Aset Ready -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="small-box bg-box-green">
            <div class="inner">
                <h3><?= $metrics['available_assets'] ?></h3>
                <p>Aset Tersedia</p>
            </div>
            <div class="icon">
                <i class="bi bi-bar-chart"></i>
            </div>
            <a href="<?= base_url('admin/assets') ?>" class="small-box-footer">
                Selengkapnya <i class="bi bi-link-45deg ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Yellow Card: Registrasi Member -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="small-box bg-box-yellow">
            <div class="inner">
                <h3><?= $metrics['total_users'] ?></h3>
                <p>Registrasi Member</p>
            </div>
            <div class="icon">
                <i class="bi bi-person-plus"></i>
            </div>
            <a href="<?= base_url('admin/users') ?>" class="small-box-footer">
                Selengkapnya <i class="bi bi-link-45deg ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Red Card: Peminjaman Aktif -->
    <div class="col-12 col-sm-6 col-lg-3">
        <div class="small-box bg-box-red">
            <div class="inner">
                <h3><?= $metrics['active_loans'] ?></h3>
                <p>Peminjaman Aktif</p>
            </div>
            <div class="icon">
                <i class="bi bi-pie-chart"></i>
            </div>
            <a href="<?= base_url('admin/loans') ?>" class="small-box-footer">
                Selengkapnya <i class="bi bi-link-45deg ms-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Secondary Stats Row (Clean flat layout) -->
<div class="row g-3 mb-4">
    <!-- Card Total Kategori -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 bg-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold d-block mb-1">Manajemen Kategori</span>
                    <h5 class="fw-bold mb-0 text-dark"><?= $metrics['total_categories'] ?> Kategori Aset</h5>
                </div>
                <a href="<?= base_url('admin/categories') ?>" class="btn btn-sm btn-light border"><i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <!-- Card Total Jenis Aset -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 bg-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold d-block mb-1">Total Jenis Aset</span>
                    <h5 class="fw-bold mb-0 text-dark"><?= $metrics['total_assets'] ?> Item Terdaftar</h5>
                </div>
                <a href="<?= base_url('admin/assets') ?>" class="btn btn-sm btn-light border"><i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
    <!-- Card Stok Unit Fisik -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3 bg-white h-100">
            <div class="card-body p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted small fw-semibold d-block mb-1">Stok Unit Fisik</span>
                    <h5 class="fw-bold mb-0 text-dark"><?= $metrics['available_stock'] ?> / <?= $metrics['total_stock'] ?> Unit Ready</h5>
                </div>
                <a href="<?= base_url('admin/assets') ?>" class="btn btn-sm btn-light border"><i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <!-- Chart Peminjaman per Bulan -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                <h5 class="card-title fw-bold mb-0 text-dark">Grafik Tren Peminjaman per Bulan</h5>
                <span class="badge bg-secondary rounded-pill px-3 py-2 fw-semibold" style="font-size: 0.85rem; letter-spacing: 0.3px;">Tahun <?= date('Y') ?></span>
            </div>
            <div class="card-body px-4 pb-4">
                <div style="position: relative; height: 320px; width: 100%;">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Kategori Aset -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-transparent border-0 pt-4 px-4">
                <h5 class="card-title fw-bold mb-0 text-dark">Proporsi Aset per Kategori</h5>
            </div>
            <div class="card-body p-4 d-flex flex-column align-items-center justify-content-center">
                <div style="position: relative; height: 250px; width: 100%; max-width: 250px;">
                    <canvas id="categoryChart"></canvas>
                </div>
                <div class="text-center mt-3 text-muted small" id="chart-legend-placeholder">
                    <!-- Dynamic legend or info -->
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Parse Monthly Loan data from controller
        const monthlyData = <?= $chartMonthly ?>;
        const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];

        // Line Chart (Tren Peminjaman Bulanan)
        const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
        
        // Gradient background for line chart
        const gradientBlue = ctxMonthly.createLinearGradient(0, 0, 0, 300);
        gradientBlue.addColorStop(0, 'rgba(12, 37, 64, 0.4)');
        gradientBlue.addColorStop(1, 'rgba(12, 37, 64, 0.0)');

        new Chart(ctxMonthly, {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Jumlah Transaksi Peminjaman',
                    data: monthlyData,
                    borderColor: '#0d3c78',
                    borderWidth: 3,
                    backgroundColor: gradientBlue,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#567c9c',
                    pointBorderColor: '#0d3c78',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        padding: 12,
                        cornerRadius: 8,
                        backgroundColor: '#051329',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: '#888'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#888'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Parse Category share data from controller
        const categoryLabels = <?= $chartCategoryLabels ?>;
        const categoryData = <?= $chartCategoryData ?>;

        // Doughnut Chart (Aset per Kategori)
        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        
        if (categoryData.length === 0) {
            // Display empty notice
            $('#chart-legend-placeholder').html('<p class="text-muted mb-0">Belum ada data kategori aset.</p>');
        } else {
            new Chart(ctxCategory, {
                type: 'doughnut',
                data: {
                    labels: categoryLabels,
                    datasets: [{
                        data: categoryData,
                        backgroundColor: [
                            '#0d3c78', // Deep Navy Blue
                            '#567c9c', // Muted Steel Blue
                            '#0d6efd', // Blue
                            '#198754', // Green
                            '#dc3545', // Red
                            '#6c757d'  // Grey
                        ],
                        borderWidth: 2,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15,
                                font: {
                                    size: 11
                                }
                            }
                        },
                        tooltip: {
                            padding: 10,
                            cornerRadius: 8
                        }
                    },
                    cutout: '65%'
                }
            });
        }
    });
</script>
<?= $this->endSection() ?>
