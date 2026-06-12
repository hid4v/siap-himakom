<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>Pengaturan Profil<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Content Header -->
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Pengaturan Profil</h1>
    <p class="text-muted mb-0 small">Ubah informasi akun Anda di sini.</p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                
                <!-- Validation Errors Alert -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
                        <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> Perbaiki Kesalahan:</div>
                        <ul class="mb-0 ps-3">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('member/profile/update') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold text-dark">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-person text-secondary"></i></span>
                            <input type="text" class="form-control" id="name" name="name" value="<?= esc(old('name', $user['name'])) ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold text-dark">Email Organisasi</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-envelope text-secondary"></i></span>
                            <input type="email" class="form-control" id="email" name="email" value="<?= esc(old('email', $user['email'])) ?>" required>
                        </div>
                    </div>

                    <div class="card border-dashed border-secondary border-opacity-25 rounded-3 bg-light bg-opacity-50 p-3 mb-4">
                        <div class="fw-bold text-dark small mb-2"><i class="bi bi-shield-lock me-1"></i> Ubah Password (Kosongkan jika tidak ingin diubah)</div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label for="password" class="form-label small">Password Baru</label>
                                <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Minimal 6 karakter">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="password_confirm" class="form-label small">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control form-control-sm" id="password_confirm" name="password_confirm" placeholder="Ulangi password baru">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-sm btn-outline-secondary px-3 py-2 rounded-3">Batal</a>
                        <button type="submit" class="btn btn-sm btn-gold px-4 py-2 rounded-3"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Right Column info card -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 text-center p-4">
            <i class="bi bi-shield-check fs-1 text-success mb-2"></i>
            <h5 class="fw-bold text-dark">Keamanan Akun</h5>
            <p class="small text-muted mb-0" style="line-height: 1.6;">
                Pastikan Anda menggunakan password yang kuat dengan kombinasi huruf, angka, dan karakter spesial. Jangan membagikan informasi login Anda kepada siapa pun demi keamanan database inventaris organisasi.
            </p>
            <hr class="my-3 opacity-25">
            <div class="text-start small">
                <span class="text-secondary d-block">Role Akun: <strong><?= strtoupper(esc($user['role'])) ?></strong></span>
                <span class="text-secondary d-block">Terdaftar Sejak: <strong><?= date('d M Y', strtotime($user['created_at'])) ?></strong></span>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
