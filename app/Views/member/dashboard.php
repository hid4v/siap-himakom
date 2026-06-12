<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>Dashboard Member<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Content Header -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Dashboard Peminjam</h1>
        <p class="text-muted mb-0 small">Halo, <?= esc(session()->get('name')) ?>. Pantau status peminjaman aset Anda di sini.</p>
    </div>
    <a href="<?= base_url('member/catalog') ?>" class="btn btn-gold shadow-sm rounded-3">
        <i class="bi bi-cart-plus me-1"></i> Ajukan Peminjaman Aset
    </a>
</div>

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <!-- Total Loans -->
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-left: 4px solid #0c2540 !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-bold mb-1">Total Pengajuan</p>
                        <h3 class="mb-0 fw-bold text-dark"><?= $metrics['total_loans'] ?></h3>
                    </div>
                    <div class="bg-dark bg-opacity-10 text-dark rounded-3 p-3">
                        <i class="bi bi-journal-text fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Loans -->
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-left: 4px solid #ffc107 !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-bold mb-1">Pending</p>
                        <h3 class="mb-0 fw-bold text-dark"><?= $metrics['pending_loans'] ?></h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning-emphasis rounded-3 p-3">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Loans (Approved/Borrowed) -->
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-left: 4px solid #0d6efd !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-bold mb-1">Sedang Pinjam</p>
                        <h3 class="mb-0 fw-bold text-dark"><?= $metrics['active_loans'] ?></h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3">
                        <i class="bi bi-box-arrow-up-right fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Returned Loans -->
    <div class="col-6 col-md-3">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-left: 4px solid #198754 !important;">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-uppercase text-muted small fw-bold mb-1">Sudah Kembali</p>
                        <h3 class="mb-0 fw-bold text-dark"><?= $metrics['returned_loans'] ?></h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-3">
                        <i class="bi bi-check2-square fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Col: Latest Peminjaman -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                <h5 class="card-title fw-bold mb-0 text-dark">5 Peminjaman Terakhir Anda</h5>
                <a href="<?= base_url('member/loans') ?>" class="small text-decoration-none fw-semibold">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="card-body px-4 pb-4">
                <?php if (empty($latestLoans)): ?>
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inboxes fs-2 d-block mb-2"></i>
                        Anda belum pernah melakukan pengajuan peminjaman aset.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Pinjam</th>
                                    <th>Tujuan</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Tgl Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($latestLoans as $loan): ?>
                                    <tr>
                                        <td><strong>#LP-<?= $loan['id'] ?></strong></td>
                                        <td><span class="text-truncate d-inline-block" style="max-width: 180px;"><?= esc($loan['purpose']) ?></span></td>
                                        <td><?= date('d-m-Y', strtotime($loan['loan_date'])) ?></td>
                                        <td><?= date('d-m-Y', strtotime($loan['return_date'])) ?></td>
                                        <td>
                                            <?php if ($loan['status'] === 'pending'): ?>
                                                <span class="badge bg-warning text-dark"><i class="bi bi-hourglass me-1"></i> Pending</span>
                                            <?php elseif ($loan['status'] === 'approved'): ?>
                                                <span class="badge bg-info text-dark"><i class="bi bi-check2 me-1"></i> Approved</span>
                                            <?php elseif ($loan['status'] === 'rejected'): ?>
                                                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i> Rejected</span>
                                            <?php elseif ($loan['status'] === 'borrowed'): ?>
                                                <span class="badge bg-primary"><i class="bi bi-box-arrow-up-right me-1"></i> Borrowed</span>
                                            <?php elseif ($loan['status'] === 'returned'): ?>
                                                <span class="badge bg-success"><i class="bi bi-check2-all me-1"></i> Returned</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary btn-view-detail rounded" data-id="<?= $loan['id'] ?>">
                                                <i class="bi bi-eye"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Right Col: Panduan / Shortcuts -->
    <div class="col-lg-4">
        <!-- Shortcut Cards -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3">Panduan Peminjaman</h5>
                <ol class="small text-muted ps-3 mb-0" style="line-height: 1.8;">
                    <li>Pilih aset yang ingin dipinjam di halaman <a href="<?= base_url('member/catalog') ?>" class="text-decoration-none">Katalog Aset</a>.</li>
                    <li>Tentukan jumlah unit dan isi form tujuan peminjaman serta tanggal operasional dengan benar.</li>
                    <li>Kirim pengajuan dan tunggu persetujuan Admin dalam 1x24 jam.</li>
                    <li>Jika <strong>Approved</strong>, ambil barang di sekretariat HIMAKOM dan status akan dirubah menjadi <strong>Borrowed</strong>.</li>
                    <li>Kembalikan barang tepat waktu. Admin akan menandai sebagai <strong>Returned</strong> dan stok aset akan kembali terisi.</li>
                </ol>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, var(--primary-dark) 0%, #051329 100%); color: #fff;">
            <div class="card-body p-4 text-center">
                <i class="bi bi-shield-lock fs-1 text-gold mb-2"></i>
                <h5 class="fw-bold mb-2 text-white">Butuh Update Sandi?</h5>
                <p class="small text-white-50 mb-3">Jaga keamanan akun dengan memperbarui email atau password profil Anda secara berkala.</p>
                <a href="<?= base_url('member/profile') ?>" class="btn btn-gold btn-sm w-100 rounded-3">
                    <i class="bi bi-person-gear"></i> Kelola Profil Akun
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
            <div class="modal-header text-white" style="background-color: var(--primary-dark);">
                <h5 class="modal-title" id="detailModalLabel"><i class="bi bi-info-circle me-2"></i>Detail Transaksi Peminjaman</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body-content">
                <div class="text-center py-4" id="modal-loader">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Memuat detail transaksi...</p>
                </div>
                
                <div id="modal-real-content" class="d-none">
                    <h6 class="fw-bold text-dark border-bottom pb-2">Informasi Peminjaman</h6>
                    <table class="table table-striped table-sm small mb-3">
                        <tr>
                            <th width="35%">ID Peminjaman</th>
                            <td>: <span id="lbl-loan-id" class="fw-bold"></span></td>
                        </tr>
                        <tr>
                            <th>Tujuan Peminjaman</th>
                            <td>: <span id="lbl-purpose"></span></td>
                        </tr>
                        <tr>
                            <th>Tanggal Pinjam</th>
                            <td>: <span id="lbl-loan-date"></span></td>
                        </tr>
                        <tr>
                            <th>Tanggal Kembali</th>
                            <td>: <span id="lbl-return-date"></span></td>
                        </tr>
                        <tr>
                            <th>Status Pengajuan</th>
                            <td>: <span id="lbl-status"></span></td>
                        </tr>
                        <tr>
                            <th>Diverifikasi Oleh</th>
                            <td>: <span id="lbl-approved-by"></span></td>
                        </tr>
                    </table>

                    <h6 class="fw-bold text-dark border-bottom pb-2">Daftar Barang Dipinjam</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm small align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Aset</th>
                                    <th>Kondisi</th>
                                    <th class="text-center">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="loan-items-body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary btn-sm rounded" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('.btn-view-detail').on('click', function() {
            const id = $(this).data('id');
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            
            $('#modal-loader').removeClass('d-none');
            $('#modal-real-content').addClass('d-none');
            modal.show();

            $.ajax({
                url: '<?= base_url('member/loans/detail') ?>/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const loan = response.loan;
                        const items = response.items;

                        // Fill labels
                        $('#lbl-loan-id').text('#LP-' + loan.id);
                        $('#lbl-purpose').text(loan.purpose);
                        $('#lbl-loan-date').text(loan.loan_date);
                        $('#lbl-return-date').text(loan.return_date);
                        
                        // Status badges mapping
                        let statusBadge = '';
                        if (loan.status === 'pending') {
                            statusBadge = '<span class="badge bg-warning text-dark">Pending</span>';
                        } else if (loan.status === 'approved') {
                            statusBadge = '<span class="badge bg-info text-dark">Approved</span>';
                        } else if (loan.status === 'rejected') {
                            statusBadge = '<span class="badge bg-danger">Rejected</span>';
                        } else if (loan.status === 'borrowed') {
                            statusBadge = '<span class="badge bg-primary">Borrowed</span>';
                        } else if (loan.status === 'returned') {
                            statusBadge = '<span class="badge bg-success">Returned</span>';
                        }
                        $('#lbl-status').html(statusBadge);
                        $('#lbl-approved-by').text(loan.approved_by_name ? loan.approved_by_name : '-');

                        // Fill items
                        let itemsHTML = '';
                        items.forEach(function(item) {
                            itemsHTML += `
                                <tr>
                                    <td>${item.asset_name}</td>
                                    <td><span class="badge bg-secondary">${item.asset_condition}</span></td>
                                    <td class="text-center fw-bold">${item.quantity} unit</td>
                                </tr>
                            `;
                        });
                        $('#loan-items-body').html(itemsHTML);

                        $('#modal-loader').addClass('d-none');
                        $('#modal-real-content').removeClass('d-none');
                    } else {
                        $('#modal-body-content').html(`<div class="alert alert-danger">${response.message}</div>`);
                    }
                },
                error: function() {
                    $('#modal-body-content').html('<div class="alert alert-danger">Gagal menghubungi server.</div>');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
