<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - SIAP-HIMAKOM</title>
    
    <!-- Favicon -->
    <link href="<?= base_url('favicon.ico') ?>" rel="icon">
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" />
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.min.css" />
    
    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />
    
    <!-- AdminLTE 4 CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/dist/css/adminlte.min.css') ?>" />
    
    <!-- jQuery DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
    
    <style>
        :root {
            --primary-dark: #0c2540;
            --accent-gold: #f1b24a;
            --light-bg: #f8f9fa;
        }

        .brand-link {
            background-color: var(--primary-dark) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .app-sidebar {
            background-color: var(--primary-dark) !important;
        }

        .sidebar-menu .nav-link.active {
            background-color: var(--accent-gold) !important;
            color: #0c2540 !important;
            font-weight: 600;
        }

        .sidebar-menu .nav-link:hover:not(.active) {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .user-panel {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-gold {
            background-color: var(--accent-gold);
            color: #0c2540;
            font-weight: 600;
            border: none;
        }

        .btn-gold:hover {
            background-color: #dca035;
            color: #0c2540;
        }

        .text-gold {
            color: var(--accent-gold) !important;
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Header / Navbar -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <!-- Left Links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <a href="<?= base_url() ?>" class="nav-link"><i class="bi bi-house-door me-1"></i> Beranda Publik</a>
                    </li>
                </ul>

                <!-- Right Links -->
                <ul class="navbar-nav ms-auto">
                    <!-- User Dropdown Menu -->
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5 me-1"></i>
                            <span class="d-none d-md-inline"><?= esc(session()->get('name')) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <!-- User Header -->
                            <li class="user-header text-bg-primary d-flex flex-column align-items-center justify-content-center" style="background-color: var(--primary-dark) !important;">
                                <i class="bi bi-person-badge fs-1 mb-2 text-gold"></i>
                                <p>
                                    <?= esc(session()->get('name')) ?>
                                    <small class="d-block text-white-50 mt-1">Role: <?= strtoupper(esc(session()->get('role'))) ?></small>
                                </p>
                            </li>
                            <!-- Menu Footer -->
                            <li class="user-footer d-flex justify-content-between p-3 bg-light">
                                <a href="<?= session()->get('role') === 'admin' ? base_url('admin') : base_url('member/profile') ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-person"></i> Profil
                                </a>
                                <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-box-arrow-right"></i> Keluar
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Sidebar -->
        <aside class="app-sidebar shadow" data-bs-theme="dark">
            <!-- Sidebar Brand -->
            <div class="sidebar-brand">
                <a href="<?= base_url('dashboard') ?>" class="brand-link d-flex align-items-center justify-content-center text-decoration-none">
                    <img src="<?= base_url('HIMAKOM Logo.png') ?>" alt="HIMAKOM Logo" class="brand-image me-2" style="max-height: 33px;">
                    <span class="brand-text fw-bold text-white small" style="letter-spacing: 0.5px;">SIAP-HIMAKOM</span>
                </a>
            </div>

            <!-- Sidebar Content -->
            <div class="sidebar-wrapper">
                <nav class="mt-3">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" data-accordion="false">
                        
                        <li class="nav-header text-white-50 small">MENU UTAMA</li>
                        
                        <!-- Common Dashboard link -->
                        <li class="nav-item">
                            <a href="<?= base_url('dashboard') ?>" class="nav-link <?= url_is('dashboard') || url_is('admin') || url_is('member') ? 'active' : '' ?>">
                                <i class="nav-icon bi bi-speedometer2"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- ADMIN MENU -->
                        <?php if (session()->get('role') === 'admin'): ?>
                            <li class="nav-header text-white-50 small mt-2">PENGELOLAAN ASET</li>
                            
                            <li class="nav-item">
                                <a href="<?= base_url('admin/categories') ?>" class="nav-link <?= url_is('admin/categories*') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-tags"></i>
                                    <p>Manajemen Kategori</p>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="<?= base_url('admin/assets') ?>" class="nav-link <?= url_is('admin/assets*') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-box-seam"></i>
                                    <p>Manajemen Aset</p>
                                </a>
                            </li>

                            <li class="nav-header text-white-50 small mt-2">TRANSAKSI & USER</li>

                            <li class="nav-item">
                                <a href="<?= base_url('admin/loans') ?>" class="nav-link <?= url_is('admin/loans*') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-arrow-left-right"></i>
                                    <p>Manajemen Peminjaman</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?= base_url('admin/users') ?>" class="nav-link <?= url_is('admin/users*') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-people"></i>
                                    <p>Manajemen Pengguna</p>
                                </a>
                            </li>
                        
                        <!-- MEMBER MENU -->
                        <?php else: ?>
                            <li class="nav-header text-white-50 small mt-2">PINJAM ASET</li>
                            
                            <li class="nav-item">
                                <a href="<?= base_url('member/catalog') ?>" class="nav-link <?= url_is('member/catalog*') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-grid-3x3-gap"></i>
                                    <p>Katalog & Pinjam Aset</p>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a href="<?= base_url('member/loans') ?>" class="nav-link <?= url_is('member/loans*') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-clock-history"></i>
                                    <p>Riwayat Peminjaman</p>
                                </a>
                            </li>

                            <li class="nav-header text-white-50 small mt-2">AKUN SAYA</li>

                            <li class="nav-item">
                                <a href="<?= base_url('member/profile') ?>" class="nav-link <?= url_is('member/profile*') ? 'active' : '' ?>">
                                    <i class="nav-icon bi bi-person-gear"></i>
                                    <p>Ubah Profil</p>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item mt-4 border-top border-secondary pt-2">
                            <a href="<?= base_url('logout') ?>" class="nav-link text-danger">
                                <i class="nav-icon bi bi-box-arrow-right"></i>
                                <p>Keluar</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <main class="app-main py-4">
            <div class="container-fluid px-4">
                
                <!-- Display Alert Flashdata -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Main Content -->
                <?= $this->renderSection('content') ?>
                
            </div>
        </main>

        <!-- Footer -->
        <footer class="app-footer text-center py-3 bg-white border-top small text-secondary">
            <div class="container-fluid">
                <strong>Copyright &copy; 2026 <a href="<?= base_url() ?>" class="text-decoration-none text-dark fw-semibold">SIAP-HIMAKOM</a>.</strong> All rights reserved.
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap 5 bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- OverlayScrollbars -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/AdminLTE/dist/js/adminlte.min.js') ?>"></script>
    
    <!-- jQuery DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Initialize Scrollbars
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        if (document.querySelector(SELECTOR_SIDEBAR_WRAPPER)) {
            const { OverlayScrollbars } = OverlayScrollbarsGlobal;
            OverlayScrollbars(document.querySelector(SELECTOR_SIDEBAR_WRAPPER), {
                scrollbars: {
                    theme: "os-theme-light",
                    autoHide: "leave",
                    clickScroll: true,
                },
            });
        }
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
