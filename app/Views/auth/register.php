<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Member - SIAP-HIMAKOM</title>
    
    <!-- Favicon -->
    <link href="<?= base_url('favicon.ico') ?>" rel="icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d3c78;
            --accent-color: #567c9c;
            --bg-color: #f0f2f5;
            --text-dark: #2d3748;
            --text-muted: #595959;
        }

        body, h1, h2, h3, h4, h5, h6, p, span, a, label, input, button, .form-control {
            font-family: 'Montserrat', sans-serif !important;
        }

        body {
            background-color: var(--bg-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 500px;
        }

        .auth-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            color: var(--text-dark);
        }

        .brand-logo {
            width: 80px;
            height: auto;
            margin-bottom: 15px;
        }

        .form-control {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            color: var(--text-dark);
            padding: 10px 16px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            background: #ffffff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(13, 60, 120, 0.15);
            color: var(--text-dark);
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .input-group-text {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 8px 0 0 8px;
            color: var(--text-muted);
        }

        .input-group .form-control {
            border-radius: 0 8px 8px 0;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
            color: #ffffff;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #0b3162;
            color: #ffffff;
        }

        .btn-primary:active {
            transform: translateY(1px);
        }

        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s ease;
            font-size: 0.9rem;
        }

        .back-link:hover {
            color: var(--primary-color);
        }

        .alert-custom {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            color: #c53030;
            border-radius: 8px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <div class="auth-card text-center">
            
            <a href="<?= base_url() ?>">
                <img src="<?= base_url('HIMAKOM Logo.png') ?>" alt="Logo HIMAKOM" class="brand-logo">
            </a>
            
            <h4 class="fw-bold mb-1" style="color: var(--primary-color);">Daftar Akun Member</h4>
            <p class="text-muted mb-4 small">Registrasi Akun Baru SIAP-HIMAKOM</p>

            <!-- Alerts / Validation Errors -->
            <?php if (session()->getFlashdata('validation')): ?>
                <div class="alert alert-custom text-start mb-4 p-3" role="alert">
                    <div class="d-flex align-items-center mb-1 fw-bold">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Perbaiki Kesalahan:
                    </div>
                    <ul class="mb-0 ps-3">
                        <?php foreach (session()->getFlashdata('validation') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-custom text-start d-flex align-items-center mb-4 p-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="POST" class="text-start">
                <?= csrf_field() ?>
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap" required value="<?= old('name') ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Organisasi / Aktif</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="contoh@himakom.org" required value="<?= old('email') ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Ulangi password" required>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4 mb-3">
                    <button type="submit" class="btn btn-primary">REGISTRASI SEKARANG</button>
                </div>
            </form>

            <div class="mt-4 pt-3 border-top border-light-subtle text-center small text-muted">
                Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-decoration-none fw-semibold" style="color: var(--primary-color);">Login di sini</a>
            </div>

            <div class="mt-3 text-center">
                <a href="<?= base_url() ?>" class="back-link"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
