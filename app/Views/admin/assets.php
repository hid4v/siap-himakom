<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>Manajemen Aset<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Content Header -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Manajemen Aset</h1>
        <p class="text-muted mb-0 small">Kelola data inventaris barang, kondisi, dan stok unit</p>
    </div>
    <button class="btn btn-gold shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#addAssetModal">
        <i class="bi bi-plus-circle me-1"></i> Tambah Aset
    </button>
</div>

<!-- Table Card -->
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle w-100" id="assetsTable">
                <thead class="table-light">
                    <tr>
                        <th width="5%">ID</th>
                        <th width="8%">Foto</th>
                        <th>Nama Aset</th>
                        <th>Kategori</th>
                        <th width="12%">Stok Total</th>
                        <th width="12%">Stok Ready</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Asset Modal -->
<div class="modal fade" id="addAssetModal" tabindex="-1" aria-labelledby="addAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header text-white" style="background-color: var(--primary-dark);">
                <h5 class="modal-title fw-bold" id="addAssetModalLabel"><i class="bi bi-box-seam me-2"></i>Tambah Aset Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/assets/store') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-semibold">Kategori</label>
                        <select class="form-select rounded-3" id="category_id" name="category_id" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nama Aset</label>
                        <input type="text" class="form-control rounded-3" id="name" name="name" placeholder="Contoh: Kamera DSLR Canon EOS" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-semibold">Stok Total</label>
                            <input type="number" class="form-control rounded-3" id="stock" name="stock" min="0" placeholder="Jumlah unit" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="condition" class="form-label fw-semibold">Kondisi</label>
                            <select class="form-select rounded-3" id="condition" name="condition" required>
                                <option value="Sangat Baik">Sangat Baik</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label fw-semibold">Status Operasional</label>
                        <select class="form-select rounded-3" id="status" name="status" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="perbaikan">Perbaikan</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control rounded-3" id="description" name="description" rows="3" placeholder="Spesifikasi, perlengkapan bawaan, dll."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold">Foto Aset</label>
                        <input type="file" class="form-control rounded-3" id="image" name="image" accept="image/*">
                        <span class="form-text text-muted small">Format: JPG, JPEG, PNG, WEBP. Maks: 2MB.</span>
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

<!-- Edit Asset Modal -->
<div class="modal fade" id="editAssetModal" tabindex="-1" aria-labelledby="editAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header text-white" style="background-color: var(--primary-dark);">
                <h5 class="modal-title fw-bold" id="editAssetModalLabel"><i class="bi bi-pencil-square me-2"></i>Edit Data Aset</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editAssetForm" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="edit_category_id" class="form-label fw-semibold">Kategori</label>
                        <select class="form-select rounded-3" id="edit_category_id" name="category_id" required>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_name" class="form-label fw-semibold">Nama Aset</label>
                        <input type="text" class="form-control rounded-3" id="edit_name" name="name" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_stock" class="form-label fw-semibold">Stok Total</label>
                            <input type="number" class="form-control rounded-3" id="edit_stock" name="stock" min="0" required>
                            <span class="form-text text-muted small" id="stock-help-text"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_condition" class="form-label fw-semibold">Kondisi</label>
                            <select class="form-select rounded-3" id="edit_condition" name="condition" required>
                                <option value="Sangat Baik">Sangat Baik</option>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label fw-semibold">Status Operasional</label>
                        <select class="form-select rounded-3" id="edit_status" name="status" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="perbaikan">Perbaikan</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label fw-semibold">Deskripsi</label>
                        <textarea class="form-control rounded-3" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label fw-semibold">Foto Aset (Biarkan kosong jika tidak diubah)</label>
                        <input type="file" class="form-control rounded-3" id="edit_image" name="image" accept="image/*">
                        <div class="mt-2 text-center" id="edit-img-preview-container">
                            <!-- Image preview loaded dynamically -->
                        </div>
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

<!-- Delete Asset Modal -->
<div class="modal fade" id="deleteAssetModal" tabindex="-1" aria-labelledby="deleteAssetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-danger text-white border-0">
                <h5 class="modal-title fw-bold" id="deleteAssetModalLabel"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteAssetForm" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <p class="mb-0">Apakah Anda yakin ingin menghapus aset <strong id="delete-asset-name"></strong>? Data history peminjaman yang melibatkan barang ini mungkin ikut terdampak.</p>
                </div>
                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary btn-sm rounded" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus Aset</button>
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
        const table = $('#assetsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '<?= base_url('admin/assets/ajax') ?>',
                type: 'POST',
                data: function(d) {
                    d.<?= csrf_token() ?> = '<?= csrf_hash() ?>';
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { 
                    data: 'image', 
                    name: 'image',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        if (data) {
                            return '<img src="<?= base_url('uploads/assets') ?>/' + data + '" class="img-thumbnail" style="max-height: 50px; max-width: 50px; object-fit: contain;">';
                        }
                        return '<img src="<?= base_url('HIMAKOM Logo.png') ?>" class="img-thumbnail" style="max-height: 50px; max-width: 50px; object-fit: contain; opacity: 0.4;">';
                    }
                },
                { data: 'name', name: 'name' },
                { data: 'category_name', name: 'category_name' },
                { 
                    data: 'stock', 
                    name: 'stock', 
                    render: function(data) {
                        return '<span class="fw-semibold text-dark">' + data + ' unit</span>';
                    }
                },
                { 
                    data: 'available_stock', 
                    name: 'available_stock',
                    render: function(data) {
                        if (data > 0) {
                            return '<span class="badge bg-success">' + data + ' unit ready</span>';
                        }
                        return '<span class="badge bg-danger">Habis</span>';
                    }
                },
                { data: 'condition', name: 'condition' },
                { 
                    data: 'status', 
                    name: 'status',
                    render: function(data) {
                        if (data === 'tersedia') {
                            return '<span class="badge bg-primary">Tersedia</span>';
                        } else if (data === 'perbaikan') {
                            return '<span class="badge bg-warning text-dark">Perbaikan</span>';
                        }
                        return '<span class="badge bg-secondary">Nonaktif</span>';
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
        $('#assetsTable').on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const categoryId = $(this).data('category_id');
            const stock = $(this).data('stock');
            const available = $(this).data('available_stock');
            const condition = $(this).data('condition');
            const status = $(this).data('status');
            const description = $(this).data('description');
            const image = $(this).data('image');

            $('#edit_name').val(name);
            $('#edit_category_id').val(categoryId);
            $('#edit_stock').val(stock);
            $('#stock-help-text').html('Ready saat ini: <strong>' + available + ' unit</strong>.');
            $('#edit_condition').val(condition);
            $('#edit_status').val(status);
            $('#edit_description').val(description);
            
            // Image preview
            if (image) {
                $('#edit-img-preview-container').html(`
                    <p class="small text-muted mb-1">Foto lama:</p>
                    <img src="<?= base_url('uploads/assets') ?>/${image}" class="img-thumbnail" style="max-height: 100px;">
                `);
            } else {
                $('#edit-img-preview-container').html('');
            }
            
            // Set dynamic action URL
            $('#editAssetForm').attr('action', '<?= base_url('admin/assets/update') ?>/' + id);
            
            // Show modal
            const editModal = new bootstrap.Modal(document.getElementById('editAssetModal'));
            editModal.show();
        });

        // Handle Delete Button Click
        $('#assetsTable').on('click', '.delete-btn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#delete-asset-name').text(name);
            
            // Set dynamic action URL
            $('#deleteAssetForm').attr('action', '<?= base_url('admin/assets/delete') ?>/' + id);

            // Show modal
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteAssetModal'));
            deleteModal.show();
        });
    });
</script>
<?= $this->endSection() ?>
