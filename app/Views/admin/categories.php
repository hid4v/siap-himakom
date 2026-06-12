<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>Manajemen Kategori<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Content Header -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Manajemen Kategori</h1>
        <p class="text-muted mb-0 small">Kelola kategori pengelompokkan aset organisasi</p>
    </div>
    <button class="btn btn-gold shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="bi bi-tag-plus me-1"></i> Tambah Kategori
    </button>
</div>

<!-- Table Card -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle w-100" id="categoriesTable">
                <thead class="table-light">
                    <tr>
                        <th width="10%">ID</th>
                        <th width="30%">Nama Kategori</th>
                        <th>Deskripsi</th>
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

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header text-white" style="background-color: var(--primary-dark);">
                <h5 class="modal-title fw-bold" id="addCategoryModalLabel"><i class="bi bi-tag me-2"></i>Tambah Kategori Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/categories/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Kategori</label>
                        <input type="text" class="form-control rounded-3" id="name" name="name" placeholder="Contoh: Multimedia, Elektronik" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control rounded-3" id="description" name="description" rows="3" placeholder="Masukkan penjelasan singkat tentang kategori ini"></textarea>
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

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header text-white" style="background-color: var(--primary-dark);">
                <h5 class="modal-title fw-bold" id="editCategoryModalLabel"><i class="bi bi-pencil-square me-2"></i>Edit Data Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label fw-semibold">Nama Kategori</label>
                        <input type="text" class="form-control rounded-3" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control rounded-3" id="edit_description" name="description" rows="3"></textarea>
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

<!-- Delete Category Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title fw-bold" id="deleteCategoryModalLabel"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteCategoryForm" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <p class="mb-0">Apakah Anda yakin ingin menghapus kategori <strong id="delete-category-name"></strong>? Seluruh data aset yang terikat dalam kategori ini akan ikut terhapus.</p>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus Kategori</button>
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
        const table = $('#categoriesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('admin/categories/ajax') ?>',
                type: 'POST',
                data: function(d) {
                    d.<?= csrf_token() ?> = '<?= csrf_hash() ?>';
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { 
                    data: 'description', 
                    name: 'description',
                    render: function(data) {
                        return data ? data : '<span class="text-muted small">Tidak ada deskripsi.</span>';
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
        $('#categoriesTable').on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const description = $(this).data('description');

            $('#edit_name').val(name);
            $('#edit_description').val(description);
            
            // Set dynamic action URL
            $('#editCategoryForm').attr('action', '<?= base_url('admin/categories/update') ?>/' + id);
            
            // Show modal
            const editModal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
            editModal.show();
        });

        // Handle Delete Button Click
        $('#categoriesTable').on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#delete-category-name').text(name);
            
            // Set dynamic action URL
            $('#deleteCategoryForm').attr('action', '<?= base_url('admin/categories/delete') ?>/' + id);

            // Show modal
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
            deleteModal.show();
        });
    });
</script>
<?= $this->endSection() ?>
