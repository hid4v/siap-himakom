<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>Riwayat Peminjaman<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Content Header -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Riwayat Peminjaman</h1>
        <p class="text-muted mb-0 small">Daftar transaksi pengajuan peminjaman aset Anda</p>
    </div>
    <a href="<?= base_url('member/catalog') ?>" class="btn btn-gold shadow-sm rounded-3">
        <i class="bi bi-cart-plus me-1"></i> Ajukan Peminjaman
    </a>
</div>

<!-- Table Card -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle w-100" id="loansHistoryTable">
                <thead class="table-light">
                    <tr>
                        <th width="10%">ID Pinjam</th>
                        <th>Tujuan Peminjaman</th>
                        <th width="15%">Tgl Pinjam</th>
                        <th width="15%">Tgl Kembali</th>
                        <th width="15%">Status</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($loans)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-journal-x fs-2 d-block mb-2"></i>
                                Anda belum memiliki riwayat pengajuan peminjaman aset.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($loans as $loan): ?>
                            <tr>
                                <td><strong>#LP-<?= $loan['id'] ?></strong></td>
                                <td><span class="text-truncate d-inline-block" style="max-width: 250px;"><?= esc($loan['purpose']) ?></span></td>
                                <td><?= date('d M Y', strtotime($loan['loan_date'])) ?></td>
                                <td><?= date('d M Y', strtotime($loan['return_date'])) ?></td>
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
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header text-white" style="background-color: var(--primary-dark);">
                <h5 class="modal-title fw-bold" id="detailModalLabel"><i class="bi bg-transparent bi-info-circle me-2"></i>Detail Transaksi Peminjaman</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="modal-body-content">
                <div class="text-center py-4" id="modal-loader">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Memuat detail transaksi...</p>
                </div>
                
                <div id="modal-real-content" class="d-none">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Informasi Peminjaman</h6>
                    <table class="table table-striped table-sm small mb-4">
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

                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Daftar Barang Dipinjam</h6>
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
                        
                        // Parse and format dates
                        const loanD = new Date(loan.loan_date);
                        const returnD = new Date(loan.return_date);
                        $('#lbl-loan-date').text(loanD.toLocaleDateString('id-ID'));
                        $('#lbl-return-date').text(returnD.toLocaleDateString('id-ID'));
                        
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
