<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIAP-HIMAKOM</title>
    
    <!-- Favicon -->
    <link href="<?= base_url('HIMAKOM Logo.png') ?>" rel="icon" type="image/png">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom Auth CSS -->
    <link href="<?= base_url('css/auth.css') ?>" rel="stylesheet">
</head>
<body>

    <div class="login-container">
        <div class="auth-card text-center">
            
            <a href="<?= base_url() ?>">
                <img src="<?= base_url('HIMAKOM Logo.png') ?>" alt="Logo HIMAKOM" class="brand-logo">
            </a>
            
            <h4 class="fw-bold mb-1" style="color: var(--primary-color);">SIAP-HIMAKOM</h4>
            <p class="text-muted mb-4 small">Sistem Informasi Aset dan Peminjaman HIMAKOM</p>

            <!-- Alerts -->
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-custom text-start d-flex align-items-center mb-4 p-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success-custom text-start d-flex align-items-center mb-4 p-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login') ?>" method="POST" class="text-start">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email Organisasi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="contoh@himakom.org" required value="<?= old('email') ?>">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                        <button class="btn btn-outline-secondary border-start-0 border toggle-password" type="button" data-target="#password" tabindex="-1">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary">MASUK</button>
                </div>
            </form>

            <div class="mt-4 pt-3 border-top border-light-subtle text-center small text-muted">
                Belum punya akun? <a href="<?= base_url('register') ?>" class="text-decoration-none fw-semibold" style="color: var(--primary-color);">Daftar di sini</a>
            </div>

            <div class="mt-3 text-center">
                <a href="<?= base_url() ?>" class="back-link"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const input = document.querySelector(this.getAttribute('data-target'));
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    </script>
</body>
</html>
