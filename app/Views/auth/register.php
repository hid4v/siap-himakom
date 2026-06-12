<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Member - SIAP-HIMAKOM</title>
    
    <!-- Favicon -->
    <link href="<?= base_url('favicon.ico') ?>" rel="icon">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0c2540;
            --accent-color: #f1b24a;
            --dark-color: #051329;
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.12);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--dark-color) 0%, var(--primary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient glowing circles in background */
        body::before, body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            z-index: 1;
            filter: blur(100px);
            opacity: 0.25;
        }
        body::before {
            background-color: var(--accent-color);
            top: 10%;
            left: 10%;
        }
        body::after {
            background-color: #0d6efd;
            bottom: 10%;
            right: 10%;
        }

        .register-container {
            z-index: 2;
            width: 100%;
            max-width: 500px;
        }

        .glass-card {
            background: rgba(12, 37, 64, 0.65);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: #ffffff;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.4);
        }

        .brand-logo {
            width: 80px;
            height: auto;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: #ffffff;
            padding: 10px 18px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent-color);
            box-shadow: 0 0 10px rgba(241, 178, 74, 0.25);
            color: #ffffff;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #e0e0e0;
            margin-bottom: 6px;
        }

        .input-group-text {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px 0 0 12px;
            color: #e0e0e0;
        }

        .input-group .form-control {
            border-radius: 0 12px 12px 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent-color) 0%, #dca035 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            color: var(--dark-color);
            box-shadow: 0 4px 15px rgba(241, 178, 74, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(241, 178, 74, 0.5);
            background: linear-gradient(135deg, #dca035 0%, var(--accent-color) 100%);
            color: var(--dark-color);
        }

        .back-link {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.9rem;
        }

        .back-link:hover {
            color: var(--accent-color);
        }

        .alert-custom {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #ff8e97;
            border-radius: 12px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <div class="glass-card text-center">
            
            <a href="<?= base_url() ?>">
                <img src="<?= base_url('HIMAKOM Logo.png') ?>" alt="Logo HIMAKOM" class="brand-logo">
            </a>
            
            <h4 class="fw-bold mb-1">Daftar Akun Member</h4>
            <p class="text-white-50 mb-4 small">Registrasi Akun Baru SIAP-HIMAKOM</p>

            <!-- Alerts / Validation Errors -->
            <?php if (session()->getFlashdata('validation')): ?>
                <div class="alert alert-custom text-start mb-4" role="alert">
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
                <div class="alert alert-custom text-start d-flex align-items-center mb-4" role="alert">
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

            <div class="mt-4 pt-3 border-top border-secondary text-center small text-white-50">
                Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-warning text-decoration-none fw-semibold">Login di sini</a>
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
