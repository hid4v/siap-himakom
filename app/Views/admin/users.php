<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>Manajemen Pengguna<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Content Header -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Manajemen Pengguna</h1>
        <p class="text-muted mb-0 small">Kelola data user, role, dan kredensial login</p>
    </div>
    <button class="btn btn-gold shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="bi bi-person-plus me-1"></i> Tambah Pengguna
    </button>
</div>

<!-- Table Card -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle w-100" id="usersTable">
                <thead class="table-light">
                    <tr>
                        <th width="8%">ID</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th width="15%">Role</th>
                        <th width="18%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header text-white" style="background-color: var(--primary-dark);">
                <h5 class="modal-title fw-bold" id="addUserModalLabel"><i class="bi bi-person-plus me-2"></i>Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/users/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control rounded-3" id="name" name="name" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email Organisasi</label>
                        <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="contoh@himakom.org" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label fw-semibold">Role</label>
                        <select class="form-select rounded-3" id="role" name="role" required>
                            <option value="member">Member</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control rounded-3" id="password" name="password" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gold btn-sm rounded"><i class="bi bi-save me-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header text-white" style="background-color: var(--primary-dark);">
                <h5 class="modal-title fw-bold" id="editUserModalLabel"><i class="bi bi-pencil-square me-2"></i>Edit Data Pengguna</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" class="form-control rounded-3" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label fw-semibold">Email Organisasi</label>
                        <input type="email" class="form-control rounded-3" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_role" class="form-label fw-semibold">Role</label>
                        <select class="form-select rounded-3" id="edit_role" name="role" required>
                            <option value="member">Member</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="card border-dashed border-secondary border-opacity-25 rounded-3 bg-light p-3">
                        <label for="edit_password" class="form-label small fw-bold mb-1">Ganti Password (Kosongkan jika tidak diubah)</label>
                        <input type="password" class="form-control form-control-sm rounded-2" id="edit_password" name="password" placeholder="Password baru">
                    </div>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gold btn-sm rounded"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title fw-bold" id="deleteUserModalLabel"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteUserForm" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <p class="mb-0">Apakah Anda yakin ingin menghapus pengguna <strong id="delete-user-name"></strong>? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize DataTables
        const table = $('#usersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('admin/users/ajax') ?>',
                type: 'POST',
                data: function(d) {
                    d.<?= csrf_token() ?> = '<?= csrf_hash() ?>';
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { 
                    data: 'role', 
                    name: 'role',
                    render: function(data) {
                        if (data === 'admin') {
                            return '<span class="badge bg-danger"><i class="bi bi-shield-fill"></i> Admin</span>';
                        }
                        return '<span class="badge bg-secondary"><i class="bi bi-person-fill"></i> Member</span>';
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

        // Handle Edit Button Click
        $('#usersTable').on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const email = $(this).data('email');
            const role = $(this).data('role');

            $('#edit_name').val(name);
            $('#edit_email').val(email);
            $('#edit_role').val(role);
            $('#edit_password').val('');
            
            // Set dynamic action URL
            $('#editUserForm').attr('action', '<?= base_url('admin/users/update') ?>/' + id);
            
            // Show modal
            const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            editModal.show();
        });

        // Handle Delete Button Click
        $('#usersTable').on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#delete-user-name').text(name);
            
            // Set dynamic action URL
            $('#deleteUserForm').attr('action', '<?= base_url('admin/users/delete') ?>/' + id);

            // Show modal
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
            deleteModal.show();
        });
    });
</script>
<?= $this->endSection() ?>
