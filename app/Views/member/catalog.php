<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>Katalog & Pinjam Aset<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="<?= base_url('css/catalog.css') ?>" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Content Header -->
<div class="mb-4">
    <h1 class="h3 mb-0 text-gray-800 fw-bold">Katalog & Pinjam Aset</h1>
    <p class="text-muted mb-0 small">Pilih aset dari katalog, tentukan kuantitas, dan ajukan peminjaman melalui keranjang.</p>
</div>

<!-- Toast Notification for Catalog -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="catalogToast" class="toast align-items-center bg-danger text-white border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3500">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2 fw-medium">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <span id="catalog-toast-msg"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Catalog list -->
    <div class="col-lg-8">
        <div class="row g-3">
            <?php if (empty($assets)): ?>
                <div class="col-12 text-center text-muted py-5 card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <i class="bi bi-box-fill fs-1 d-block mb-3"></i>
                        Semua aset sedang dipinjam atau tidak ada aset tersedia saat ini.
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($assets as $asset): ?>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden border">
                            <!-- Thumbnail -->
                            <div class="asset-thumbnail-container">
                                <span class="badge bg-dark position-absolute top-0 start-0 m-3"><?= esc($asset['category_name']) ?></span>
                                <?php
                                  $cond = strtolower(trim($asset['condition']));
                                  $badgeBg = 'bg-secondary text-white';
                                  if ($cond === 'sangat baik') {
                                      $badgeBg = 'bg-success text-white';
                                  } elseif ($cond === 'baik') {
                                      $badgeBg = 'bg-warning text-dark';
                                  } elseif (strpos($cond, 'buruk') !== false || strpos($cond, 'rusak') !== false) {
                                      $badgeBg = 'bg-danger text-white';
                                  }
                                ?>
                                <span class="badge <?= $badgeBg ?> position-absolute top-0 end-0 m-3"><?= esc($asset['condition']) ?></span>
                                
                                <?php if ($asset['image']): ?>
                                    <img src="<?= base_url('uploads/assets/' . $asset['image']) ?>" alt="<?= esc($asset['name']) ?>">
                                <?php else: ?>
                                    <img src="<?= base_url('HIMAKOM Logo.png') ?>" alt="Logo HIMAKOM" style="opacity: 0.4;">
                                <?php endif; ?>
                            </div>
                            
                            <!-- Body -->
                            <div class="card-body p-3 d-flex flex-column">
                                <h6 class="fw-bold text-dark mb-1"><?= esc($asset['name']) ?></h6>
                                <p class="small text-muted mb-3 text-truncate-2" style="height: 38px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                    <?= esc($asset['description'] ?: 'Tidak ada deskripsi.') ?>
                                </p>
                                
                                <div class="mt-auto pt-2 border-top border-light d-flex align-items-center justify-content-between">
                                    <div class="small text-secondary">
                                        Stok Ready: <strong class="text-primary font-monospace"><?= $asset['available_stock'] ?></strong> unit
                                    </div>
                                    
                                    <?php if ($asset['available_stock'] > 0): ?>
                                        <div class="d-flex align-items-center gap-1">
                                            <input type="number" class="form-control form-control-sm text-center qty-input" 
                                                id="qty-<?= $asset['id'] ?>" 
                                                value="1" 
                                                min="1" 
                                                max="<?= $asset['available_stock'] ?>" 
                                                style="width: 55px;"
                                            >
                                            <button class="btn btn-sm btn-gold btn-add-to-cart rounded-3" 
                                                data-id="<?= $asset['id'] ?>" 
                                                data-name="<?= esc($asset['name']) ?>" 
                                                data-max="<?= $asset['available_stock'] ?>"
                                            >
                                                <i class="bi bi-cart-plus"></i> Tambah
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Habis / Dipinjam</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Column: Booking Cart -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 cart-card">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-cart3 me-1 text-gold"></i> Keranjang Peminjaman</h5>
                
                <!-- Cart Items List -->
                <div id="cart-empty-message" class="text-center text-muted py-4">
                    <i class="bi bi-cart-x fs-3 d-block mb-1"></i>
                    Keranjang masih kosong.
                </div>
                
                <ul class="list-group list-group-flush mb-4 d-none" id="cart-items-list">
                    <!-- Loaded dynamically via jQuery -->
                </ul>

                <!-- Booking Details Form -->
                <form action="<?= base_url('member/loans/store') ?>" method="POST" id="checkout-form" class="d-none">
                    <?= csrf_field() ?>
                    
                    <!-- Hidden fields for items -->
                    <div id="hidden-cart-inputs"></div>

                    <div class="mb-3">
                        <label for="purpose" class="form-label small fw-bold text-dark">Tujuan Peminjaman</label>
                        <textarea class="form-control rounded-3" id="purpose" name="purpose" rows="3" placeholder="Contoh: Kegiatan Rapat HIMAKOM / Dokumentasi Event" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="loan_date" class="form-label small fw-bold text-dark">Tanggal Pinjam</label>
                            <input type="date" class="form-control rounded-3" id="loan_date" name="loan_date" required min="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="return_date" class="form-label small fw-bold text-dark">Tanggal Kembali</label>
                            <input type="date" class="form-control rounded-3" id="return_date" name="return_date" required min="<?= date('Y-m-d') ?>">
                        </div>
                    </div>

                    <div class="d-grid mt-2">
                        <button type="submit" class="btn btn-gold w-100 py-2 rounded-3 fw-bold"><i class="bi bi-check2-all"></i> Kirim Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Show Catalog Toast (replaces native alert)
        function showCatalogAlert(msg) {
            $('#catalog-toast-msg').text(msg);
            const bsToast = new bootstrap.Toast(document.getElementById('catalogToast'));
            bsToast.show();
        }

        // Local Cart State
        let cart = {};

        // 1. Add to Cart Handler
        $('.btn-add-to-cart').on('click', function() {
            const assetId = $(this).data('id');
            const name = $(this).data('name');
            const maxVal = parseInt($(this).data('max'));
            const qty = parseInt($('#qty-' + assetId).val());

            if (isNaN(qty) || qty <= 0) {
                showCatalogAlert('Jumlah unit tidak valid. Harap masukkan angka yang benar.');
                return;
            }
            if (qty > maxVal) {
                showCatalogAlert('Kuantitas tidak boleh melebihi stok ready (' + maxVal + ' unit).');
                return;
            }

            // Update state
            if (cart[assetId]) {
                const updatedQty = cart[assetId].quantity + qty;
                if (updatedQty > maxVal) {
                    cart[assetId].quantity = maxVal;
                } else {
                    cart[assetId].quantity = updatedQty;
                }
            } else {
                cart[assetId] = {
                    id: assetId,
                    name: name,
                    quantity: qty,
                    max: maxVal
                };
            }

            renderCart();
        });

        // 2. Render Cart DOM & Inputs
        function renderCart() {
            const listContainer = $('#cart-items-list');
            const emptyMessage = $('#cart-empty-message');
            const form = $('#checkout-form');
            const hiddenContainer = $('#hidden-cart-inputs');

            // Reset containers
            listContainer.empty();
            hiddenContainer.empty();

            const keys = Object.keys(cart);

            if (keys.length === 0) {
                emptyMessage.removeClass('d-none');
                listContainer.addClass('d-none');
                form.addClass('d-none');
                return;
            }

            emptyMessage.addClass('d-none');
            listContainer.removeClass('d-none');
            form.removeClass('d-none');

            // Render list items & populate inputs
            keys.forEach(function(key) {
                const item = cart[key];
                
                // Append to List
                listContainer.append(`
                    <li class="list-group-item d-flex align-items-center justify-content-between px-0 py-2 bg-transparent border-light border-opacity-50">
                        <div>
                            <span class="small fw-semibold text-dark d-block" style="max-width: 180px;">${item.name}</span>
                            <span class="text-muted small">Qty: <strong class="text-primary">${item.quantity} unit</strong></span>
                        </div>
                        <button class="btn btn-sm btn-outline-danger px-2 py-1 btn-remove-item rounded" data-id="${item.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </li>
                `);

                // Append hidden input for POST request
                hiddenContainer.append(`
                    <input type="hidden" name="items[${item.id}]" value="${item.quantity}">
                `);
            });
        }

        // 3. Remove Item Handler
        $('#cart-items-list').on('click', '.btn-remove-item', function() {
            const id = $(this).data('id');
            delete cart[id];
            renderCart();
        });

        // 4. Date validation logic
        $('#loan_date').on('change', function() {
            const minReturn = $(this).val();
            $('#return_date').attr('min', minReturn);
        });
    });
</script>
<?= $this->endSection() ?>
