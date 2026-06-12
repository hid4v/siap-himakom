<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>Dashboard Admin<?= $this->endSection() ?>

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

<!-- Stats Cards Row -->
<div class="row g-3 mb-4">
    <!-- Card Total Pengguna -->
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-left: 4px solid #0d6efd !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-bold mb-1">Total Pengguna</p>
                        <h3 class="mb-0 fw-bold text-dark"><?= $metrics['total_users'] ?></h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Card Total Kategori -->
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-left: 4px solid #198754 !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-bold mb-1">Kategori Aset</p>
                        <h3 class="mb-0 fw-bold text-dark"><?= $metrics['total_categories'] ?></h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                        <i class="bi bi-tags fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Total Aset -->
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-left: 4px solid #ffc107 !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-bold mb-1">Total Jenis Aset</p>
                        <h3 class="mb-0 fw-bold text-dark"><?= $metrics['total_assets'] ?></h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning-emphasis rounded-3 p-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Aset Tersedia -->
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-left: 4px solid #20c997 !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-bold mb-1">Aset Tersedia</p>
                        <h3 class="mb-0 fw-bold text-dark"><?= $metrics['available_assets'] ?> <span class="small text-muted fw-normal">Ready</span></h3>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded-3 p-3">
                        <i class="bi bi-check2-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <!-- Card Total Peminjaman -->
    <div class="col-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="background-color: var(--primary-dark) !important; color: #fff;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="text-white-50 small fw-bold text-uppercase mb-2">Total Transaksi</h5>
                    <h2 class="mb-0 fw-bold text-gold"><?= $metrics['total_loans'] ?></h2>
                    <span class="small text-white-50">Pengajuan Peminjaman</span>
                </div>
                <div class="bg-white bg-opacity-10 text-gold rounded-3 p-3">
                    <i class="bi bi-arrow-left-right fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Peminjaman Aktif -->
    <div class="col-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-left: 4px solid #dc3545 !important;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="text-muted small fw-bold text-uppercase mb-2">Peminjaman Aktif</h5>
                    <h2 class="mb-0 fw-bold text-dark"><?= $metrics['active_loans'] ?></h2>
                    <span class="small text-muted">Sedang Berjalan (Approved/Borrowed)</span>
                </div>
                <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-3">
                    <i class="bi bi-arrow-up-right-circle fs-3"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Fisik Stok -->
    <div class="col-12 col-lg-4">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-left: 4px solid #6c757d !important;">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h5 class="text-muted small fw-bold text-uppercase mb-2">Stok Unit Fisik</h5>
                    <h2 class="mb-0 fw-bold text-dark"><?= $metrics['available_stock'] ?> <span class="fs-5 text-muted fw-normal">/ <?= $metrics['total_stock'] ?> unit</span></h2>
                    <span class="small text-muted">Unit Fisik yang Ready Peminjaman</span>
                </div>
                <div class="bg-secondary bg-opacity-10 text-secondary rounded-3 p-3">
                    <i class="bi bi-hdd-stack fs-3"></i>
                </div>
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
                <span class="badge bg-secondary">Tahun <?= date('Y') ?></span>
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
                    borderColor: '#0c2540',
                    borderWidth: 3,
                    backgroundColor: gradientBlue,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#f1b24a',
                    pointBorderColor: '#0c2540',
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
                            '#0c2540', // Deep Blue
                            '#f1b24a', // Gold
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
