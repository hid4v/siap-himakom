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

        // 2. Handle Action Requests (Approve, Reject, Borrow, Return)
        function processAction(url, successMsg) {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        // Reload Table
                        table.ajax.reload(null, false);
                        
                        // Show success alert dynamically
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Gagal memproses aksi. Hubungi developer.');
                }
            });
        }

        $('#loansTable').on('click', '.btn-approve', function() {
            const id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menyetujui peminjaman ini? Tindakan ini akan memesan (mengurangi) stok tersedia.')) {
                processAction('<?= base_url('admin/loans/approve') ?>/' + id);
            }
        });

        $('#loansTable').on('click', '.btn-reject', function() {
            const id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menolak peminjaman ini?')) {
                processAction('<?= base_url('admin/loans/reject') ?>/' + id);
            }
        });

        $('#loansTable').on('click', '.btn-borrow', function() {
            const id = $(this).data('id');
            if (confirm('Tandai aset telah diambil oleh peminjam? Status akan berubah menjadi Borrowed.')) {
                processAction('<?= base_url('admin/loans/borrow') ?>/' + id);
            }
        });

        $('#loansTable').on('click', '.btn-return', function() {
            const id = $(this).data('id');
            if (confirm('Tandai aset telah dikembalikan dengan lengkap? Tindakan ini akan mengembalikan stok tersedia.')) {
                processAction('<?= base_url('admin/loans/return') ?>/' + id);
            }
        });
    });
</script>
<?= $this->endSection() ?>
