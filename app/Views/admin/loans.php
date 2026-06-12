<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>Manajemen Peminjaman<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Content Header -->
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Manajemen Peminjaman</h1>
    <p class="text-muted mb-0 small">Verifikasi pengajuan, pantau serah terima, dan kelola pengembalian aset</p>
</div>

<!-- Table Card -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle w-100" id="loansTable">
                <thead class="table-light">
                    <tr>
                        <th width="8%">ID Pinjam</th>
                        <th width="15%">Peminjam (Member)</th>
                        <th>Tujuan</th>
                        <th width="12%">Tgl Pinjam</th>
                        <th width="12%">Tgl Kembali</th>
                        <th width="10%">Status</th>
                        <th width="22%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loaded via AJAX -->
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
                <!-- Ajax Loader -->
                <div class="text-center py-5" id="modal-loader">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Memuat detail transaksi...</p>
                </div>
                
                <!-- Real Content -->
                <div id="modal-real-content" class="d-none">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Informasi Peminjaman</h6>
                    <table class="table table-striped table-sm small mb-4">
                        <tr>
                            <th width="35%">ID Peminjaman</th>
                            <td>: <span id="lbl-loan-id" class="fw-bold"></span></td>
                        </tr>
                        <tr>
                            <th>Nama Peminjam</th>
                            <td>: <span id="lbl-user-name" class="fw-semibold text-primary"></span></td>
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

<!-- Reusable Confirmation Modal -->
<div class="modal fade" id="confirmActionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-body text-center px-4 pt-4 pb-3">
                <!-- Icon circle -->
                <div id="confirm-icon-wrap" class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 64px; height: 64px;">
                    <i id="confirm-icon" class="fs-2"></i>
                </div>
                <h5 id="confirm-title" class="fw-bold mb-2"></h5>
                <p id="confirm-desc" class="text-muted small mb-0" style="line-height: 1.6;"></p>
            </div>
            <div class="modal-footer border-0 bg-light justify-content-center gap-2 px-4 pb-4 pt-2">
                <button type="button" class="btn btn-light border rounded-3 px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Batal
                </button>
                <button type="button" id="confirm-action-btn" class="btn rounded-3 px-4">
                    <i id="confirm-btn-icon" class="me-1"></i><span id="confirm-btn-text"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="actionToast" class="toast align-items-center border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2 fw-medium">
                <i id="toast-icon" class="fs-5"></i>
                <span id="toast-message"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize DataTables
        const table = $('#loansTable').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, "desc"]], // Default order: newest ID
            ajax: {
                url: '<?= base_url('admin/loans/ajax') ?>',
                type: 'POST',
                data: function(d) {
                    d.<?= csrf_token() ?> = '<?= csrf_hash() ?>';
                }
            },
            columns: [
                { 
                    data: 'id', 
                    name: 'loans.id',
                    render: function(data) {
                        return '<strong>#LP-' + data + '</strong>';
                    }
                },
                { data: 'user_name', name: 'user.name' },
                { 
                    data: 'purpose', 
                    name: 'loans.purpose',
                    render: function(data) {
                        return '<span class="text-truncate d-inline-block" style="max-width: 200px;">' + data + '</span>';
                    }
                },
                { 
                    data: 'loan_date', 
                    name: 'loans.loan_date',
                    render: function(data) {
                        const date = new Date(data);
                        return date.toLocaleDateString('id-ID');
                    }
                },
                { 
                    data: 'return_date', 
                    name: 'loans.return_date',
                    render: function(data) {
                        const date = new Date(data);
                        return date.toLocaleDateString('id-ID');
                    }
                },
                { 
                    data: 'status', 
                    name: 'loans.status',
                    render: function(data) {
                        if (data === 'pending') {
                            return '<span class="badge bg-warning text-dark"><i class="bi bi-hourglass"></i> Pending</span>';
                        } else if (data === 'approved') {
                            return '<span class="badge bg-info text-dark"><i class="bi bi-check2"></i> Approved</span>';
                        } else if (data === 'rejected') {
                            return '<span class="badge bg-danger"><i class="bi bi-x-circle"></i> Rejected</span>';
                        } else if (data === 'borrowed') {
                            return '<span class="badge bg-primary"><i class="bi bi-box-arrow-up-right"></i> Borrowed</span>';
                        } else if (data === 'returned') {
                            return '<span class="badge bg-success"><i class="bi bi-check2-all"></i> Returned</span>';
                        }
                        return data;
                    }
                },
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false 
                }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                },
                processing: "Sedang memproses..."
            }
        });

        // 1. Handle Detail Click
        $('#loansTable').on('click', '.btn-view-detail', function() {
            const id = $(this).data('id');
            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            
            $('#modal-loader').removeClass('d-none');
            $('#modal-real-content').addClass('d-none');
            modal.show();

            $.ajax({
                url: '<?= base_url('admin/loans/detail') ?>/' + id,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const loan = response.loan;
                        const items = response.items;

                        // Fill labels
                        $('#lbl-loan-id').text('#LP-' + loan.id);
                        $('#lbl-user-name').text(loan.user_name);
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
                            const cond = item.asset_condition.toLowerCase().trim();
                            let badgeClass = 'badge bg-secondary';
                            if (cond === 'sangat baik') {
                                badgeClass = 'badge bg-success';
                            } else if (cond === 'baik') {
                                badgeClass = 'badge bg-warning text-dark';
                            } else if (cond.indexOf('buruk') !== -1 || cond.indexOf('rusak') !== -1) {
                                badgeClass = 'badge bg-danger';
                            }
                            itemsHTML += `
                                <tr>
                                    <td>${item.asset_name}</td>
                                    <td><span class="${badgeClass}">${item.asset_condition}</span></td>
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

        // 2. Show Toast Notification (replaces native alert)
        function showToast(message, isSuccess) {
            const toast = document.getElementById('actionToast');
            const toastIcon = document.getElementById('toast-icon');
            const toastMsg = document.getElementById('toast-message');

            toast.className = 'toast align-items-center border-0 shadow-lg text-white ' + (isSuccess ? 'bg-success' : 'bg-danger');
            toastIcon.className = 'fs-5 bi ' + (isSuccess ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill');
            toastMsg.textContent = message;

            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
        }

        // 3. Show Confirmation Modal (replaces native confirm)
        const actionConfigs = {
            approve: {
                iconClass: 'bi bi-check-circle-fill',
                iconBg: 'rgba(25, 135, 84, 0.12)',
                iconColor: '#198754',
                title: 'Setujui Peminjaman?',
                desc: 'Stok aset yang terkait akan dikurangi sesuai jumlah yang diajukan. Pastikan data sudah benar sebelum melanjutkan.',
                btnClass: 'btn-success',
                btnIcon: 'bi bi-check-lg',
                btnText: 'Ya, Setujui'
            },
            reject: {
                iconClass: 'bi bi-x-octagon-fill',
                iconBg: 'rgba(220, 53, 69, 0.12)',
                iconColor: '#dc3545',
                title: 'Tolak Peminjaman?',
                desc: 'Pengajuan peminjaman ini akan ditolak dan peminjam akan melihat statusnya berubah menjadi "Rejected".',
                btnClass: 'btn-danger',
                btnIcon: 'bi bi-x-lg',
                btnText: 'Ya, Tolak'
            },
            borrow: {
                iconClass: 'bi bi-box-arrow-up-right',
                iconBg: 'rgba(13, 60, 120, 0.10)',
                iconColor: '#0d3c78',
                title: 'Tandai Sudah Diambil?',
                desc: 'Status akan berubah menjadi "Borrowed". Pastikan aset sudah diserahkan secara fisik kepada peminjam.',
                btnClass: 'btn-primary',
                btnIcon: 'bi bi-box-arrow-up-right',
                btnText: 'Ya, Tandai'
            },
            return_loan: {
                iconClass: 'bi bi-arrow-return-left',
                iconBg: 'rgba(25, 135, 84, 0.12)',
                iconColor: '#198754',
                title: 'Tandai Sudah Dikembalikan?',
                desc: 'Stok aset akan dipulihkan kembali sesuai jumlah yang dipinjam. Pastikan seluruh barang telah diterima dengan lengkap.',
                btnClass: 'btn-success',
                btnIcon: 'bi bi-check2-all',
                btnText: 'Ya, Kembalikan'
            }
        };

        let pendingActionUrl = null;

        function showConfirmModal(actionType, url) {
            const cfg = actionConfigs[actionType];
            if (!cfg) return;

            pendingActionUrl = url;

            // Populate modal
            $('#confirm-icon-wrap').css({ background: cfg.iconBg });
            $('#confirm-icon').attr('class', 'fs-2 ' + cfg.iconClass).css({ color: cfg.iconColor });
            $('#confirm-title').text(cfg.title);
            $('#confirm-desc').text(cfg.desc);
            $('#confirm-action-btn').attr('class', 'btn rounded-3 px-4 ' + cfg.btnClass);
            $('#confirm-btn-icon').attr('class', 'me-1 ' + cfg.btnIcon);
            $('#confirm-btn-text').text(cfg.btnText);

            const modal = new bootstrap.Modal(document.getElementById('confirmActionModal'));
            modal.show();
        }

        // When user clicks confirm
        $('#confirm-action-btn').on('click', function() {
            if (!pendingActionUrl) return;

            const btn = $(this);
            const originalHTML = btn.html();
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Memproses...');

            // Close modal first
            bootstrap.Modal.getInstance(document.getElementById('confirmActionModal')).hide();

            $.ajax({
                url: pendingActionUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        table.ajax.reload(null, false);
                        showToast(response.message, true);
                    } else {
                        showToast(response.message, false);
                    }
                },
                error: function() {
                    showToast('Gagal memproses aksi. Hubungi developer.', false);
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalHTML);
                    pendingActionUrl = null;
                }
            });
        });

        // 4. Bind Action Buttons
        $('#loansTable').on('click', '.btn-approve', function() {
            showConfirmModal('approve', '<?= base_url('admin/loans/approve') ?>/' + $(this).data('id'));
        });

        $('#loansTable').on('click', '.btn-reject', function() {
            showConfirmModal('reject', '<?= base_url('admin/loans/reject') ?>/' + $(this).data('id'));
        });

        $('#loansTable').on('click', '.btn-borrow', function() {
            showConfirmModal('borrow', '<?= base_url('admin/loans/borrow') ?>/' + $(this).data('id'));
        });

        $('#loansTable').on('click', '.btn-return', function() {
            showConfirmModal('return_loan', '<?= base_url('admin/loans/return') ?>/' + $(this).data('id'));
        });
    });
</script>
<?= $this->endSection() ?>
