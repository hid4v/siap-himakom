<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SIAP-HIMAKOM - Sistem Informasi Aset dan Peminjaman HIMAKOM</title>
  <meta name="description" content="Sistem Informasi Aset dan Peminjaman HIMAKOM - Ilmu Komputer Universitas Lambung Mangkurat">
  <meta name="keywords" content="siap, himakom, ulm, ilmu komputer, peminjaman aset, inventaris">

  <!-- Favicon -->
  <link href="<?= base_url('HIMAKOM Logo.png') ?>" rel="icon" type="image/png">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url('assets/FlexStart/assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/FlexStart/assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/FlexStart/assets/vendor/aos/aos.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/FlexStart/assets/vendor/glightbox/css/glightbox.min.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/FlexStart/assets/vendor/swiper/swiper-bundle.min.css') ?>" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="<?= base_url('assets/FlexStart/assets/css/main.css') ?>" rel="stylesheet">

  <!-- Custom Landing CSS -->
  <link href="<?= base_url('css/landing.css') ?>" rel="stylesheet">
</head>

<body class="index-page">

  <!-- Header -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="<?= base_url() ?>" class="logo d-flex align-items-center me-auto">
        <img src="<?= base_url('HIMAKOM Logo.png') ?>" alt="Logo HIMAKOM">
        <h1 class="sitename">SIAP-HIMAKOM</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Beranda</a></li>
          <li><a href="#about">Tentang</a></li>
          <li><a href="#catalog">Katalog Aset</a></li>
          <li><a href="#faq">FAQ</a></li>
          <li><a href="#contact">Kontak</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <?php if (session()->get('isLoggedIn')): ?>
        <a class="btn-getstarted flex-md-shrink-0" href="<?= base_url('dashboard') ?>"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a>
      <?php else: ?>
        <a class="btn-getstarted flex-md-shrink-0" href="<?= base_url('login') ?>"><i class="bi bi-box-arrow-in-right me-1"></i> Login</a>
      <?php endif; ?>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="fade-up">
            <h1>Sistem Informasi Aset & Peminjaman HIMAKOM</h1>
            <p>Platform digital terpusat untuk memantau ketersediaan, mendokumentasikan, dan mengajukan peminjaman aset operasional HIMAKOM FMIPA ULM secara cepat dan akurat.</p>

          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img text-center" data-aos="zoom-out" data-aos-delay="100">
            <img src="<?= base_url('HIMAKOM Logo.png') ?>" class="img-fluid animated" alt="HIMAKOM Logo" style="max-height: 350px;">
          </div>
        </div>
      </div>
    </section>

    <!-- Tentang Section -->
    <section id="about" class="about section">
      <div class="container" data-aos="fade-up">
        
        <div class="section-title">
          <h2>Tentang Kami</h2>
          <p>Profil Organisasi & Program Studi</p>
        </div>

        <div class="row gy-4 align-items-stretch">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="card h-100 p-4 border border-light-subtle shadow-sm" style="background-color: #ffffff; border-radius: 12px;">
              <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-people-fill me-2"></i>HIMAKOM FMIPA ULM</h4>
              <p class="lead" style="font-size: 1.05rem; line-height: 1.7; color: var(--secondary-color);">Himpunan Mahasiswa Ilmu Komputer (HIMAKOM) FMIPA ULM merupakan wadah organisasi bagi mahasiswa Program Studi Ilmu Komputer Universitas Lambung Mangkurat.</p>
              <p style="font-size: 0.95rem; line-height: 1.7; color: var(--secondary-color);">HIMAKOM bertugas mengayomi mahasiswa, menyalurkan minat bakat, dan memfasilitasi kebutuhan sarana prasarana mahasiswa Ilmu Komputer dalam menunjang kegiatan akademis dan non-akademis.</p>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="card h-100 p-4 border border-light-subtle shadow-sm" style="background-color: #ffffff; border-radius: 12px;">
              <h4 class="fw-bold mb-3 text-dark"><i class="bi bi-mortarboard-fill me-2"></i>Program Studi Ilmu Komputer ULM</h4>
              
              <div class="mb-3">
                <span class="badge bg-secondary mb-2">VISI</span>
                <p class="small text-muted mb-0">"Terwujudnya program studi bidang komputasi yang mampu bersaing secara nasional dalam otomasi data untuk mengoptimalkan potensi daerah serta mendukung e-government dengan teknologi kekinian."</p>
              </div>

              <div>
                <span class="badge bg-secondary mb-2">MISI</span>
                <ol class="small text-muted ps-3 mb-0" style="line-height: 1.6;">
                  <li>Menyelenggarakan pendidikan dan pengajaran sesuai dengan kualifikasi nasional dibidang komputer dalam otomasi data dalam rangka mencerdaskan masyarakat dan bersaing secara nasional.</li>
                  <li>Menghasilkan dan mengembangkan penelitian keilmuan bidang komputasi dengan teknologi kekinian sebagai penelitian yang dapat mengoptimalkan potensi daerah serta mendukung e-government.</li>
                  <li>Berpartisipasi dalam pengabdian masyarakat untuk meningkatkan potensi daerah dan menyelesaikan masalah daerah dengan teknologi berbasis komputer.</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-4" data-aos="fade-up" data-aos-delay="300">
          <div class="col-12 text-center">
            <span class="text-muted small">Web Resmi Program Studi: </span>
            <a href="https://ilkom.ulm.ac.id" target="_blank" class="fw-bold text-dark text-decoration-none small ms-1"><i class="bi bi-globe2 me-1"></i>ilkom.ulm.ac.id</a>
          </div>
        </div>

      </div>
    </section>



    <!-- Katalog Aset Section -->
    <section id="catalog" class="services section">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Katalog Aset</h2>
          <p>Daftar Aset Yang Tersedia</p>
        </div>

        <div class="row gy-4">
          <?php if (empty($assets)): ?>
            <div class="col-12 text-center text-muted py-5">
              <i class="bi bi-box-fill fs-1 d-block mb-3"></i>
              Belum ada data aset yang tersedia saat ini.
            </div>
          <?php else: ?>
            <?php foreach ($assets as $asset): ?>
              <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="asset-card">
                  <div class="asset-img-container">
                    <span class="category-badge"><?= esc($asset['category_name']) ?></span>
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
                    <span class="condition-badge <?= $badgeBg ?>"><?= esc($asset['condition']) ?></span>
                    
                    <?php if ($asset['image']): ?>
                      <img src="<?= base_url('uploads/assets/' . $asset['image']) ?>" alt="<?= esc($asset['name']) ?>">
                    <?php else: ?>
                      <img src="<?= base_url('HIMAKOM Logo.png') ?>" alt="HIMAKOM Logo" style="opacity: 0.5;">
                    <?php endif; ?>
                  </div>
                  
                  <div class="asset-body">
                    <h5 class="asset-title"><?= esc($asset['name']) ?></h5>
                    <p class="asset-desc"><?= esc($asset['description'] ?: 'Tidak ada deskripsi.') ?></p>
                    
                    <div class="asset-meta">
                      <div class="stock-info">
                        Ready: <span class="stock-number"><?= $asset['available_stock'] ?></span> / <?= $asset['stock'] ?> unit
                      </div>
                      <button class="btn-detail view-asset-detail" data-id="<?= $asset['id'] ?>">
                        <i class="bi bi-info-circle me-1"></i> Detail
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

      </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="faq section">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>F.A.Q</h2>
          <p>Pertanyaan yang Sering Diajukan</p>
        </div>

        <div class="row">
          <div class="col-lg-12">
            <div class="faq-container">

              <div class="faq-item faq-active">
                <h3>Bagaimana cara meminjam aset HIMAKOM?</h3>
                <div class="faq-content">
                  <p>Untuk mengajukan peminjaman, Anda harus mendaftar akun terlebih dahulu sebagai Member melalui tombol Registrasi. Setelah login, Anda dapat mengakses menu Katalog & Pinjam Aset, memilih item yang ingin dipinjam, mengisi formulir peminjaman (tujuan, tanggal pinjam, dan tanggal kembali), lalu menyerahkan pengajuan untuk diproses oleh Admin.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div>

              <div class="faq-item">
                <h3>Berapa lama waktu persetujuan peminjaman?</h3>
                <div class="faq-content">
                  <p>Persetujuan peminjaman dilakukan secara berkala oleh pengurus HIMAKOM (Admin). Biasanya pengajuan Anda akan ditinjau dan statusnya diperbarui (Disetujui/Ditolak) dalam waktu maksimal 1x24 jam sejak pengajuan dikirim.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div>

              <div class="faq-item">
                <h3>Apa yang harus dilakukan setelah pengajuan disetujui (Approved)?</h3>
                <div class="faq-content">
                  <p>Jika pengajuan Anda berstatus "Approved", silakan menemui divisi inventaris/sarpras HIMAKOM di sekretariat untuk serah terima barang fisik. Admin akan merubah status di sistem menjadi "Borrowed" saat barang diserahterimakan.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div>

              <div class="faq-item">
                <h3>Bagaimana jika aset yang saya pinjam mengalami kerusakan?</h3>
                <div class="faq-content">
                  <p>Peminjam wajib menjaga kondisi barang dengan baik. Jika terjadi kerusakan atau kehilangan selama masa peminjaman, peminjam berkewajiban mengganti rugi sesuai dengan kesepakatan dan ketentuan inventaris HIMAKOM FMIPA ULM.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- Kontak Section -->
    <section id="contact" class="contact section">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Kontak Kami</h2>
          <p>Hubungi HIMAKOM</p>
        </div>

        <div class="row gy-4 justify-content-center">
          <div class="col-lg-4 col-md-6">
            <div class="info-item d-flex flex-column align-items-center justify-content-center text-center p-4 shadow-sm h-100" style="border-radius: 12px;">
              <i class="bi bi-geo-alt fs-2 text-warning mb-3"></i>
              <h4>Sekretariat</h4>
              <p class="small text-muted">Gedung Ormawa FMIPA ULM, Jl. A. Yani Km. 36 Banjarbaru, Kalimantan Selatan</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="info-item d-flex flex-column align-items-center justify-content-center text-center p-4 shadow-sm h-100" style="border-radius: 12px;">
              <i class="bi bi-envelope fs-2 text-warning mb-3"></i>
              <h4>Email Resmi</h4>
              <p class="small text-muted">himakom@fmipa.ulm.ac.id</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="info-item d-flex flex-column align-items-center justify-content-center text-center p-4 shadow-sm h-100" style="border-radius: 12px;">
              <i class="bi bi-instagram fs-2 text-warning mb-3"></i>
              <h4>Instagram</h4>
              <p class="small text-muted">@himakom_ulm</p>
            </div>
          </div>
        </div>

      </div>
    </section>

  </main>

  <!-- Footer -->
  <footer id="footer" class="footer">
    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">SIAP-HIMAKOM</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Developed for HIMAKOM FMIPA Universitas Lambung Mangkurat | <a href="https://ilkom.ulm.ac.id" target="_blank">ilkom.ulm.ac.id</a>
      </div>
    </div>
  </footer>

  <!-- Detail Modal -->
  <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-content-custom">
        <div class="modal-header modal-header-custom">
          <h5 class="modal-title" id="detailModalLabel"><i class="bi bi-info-circle me-2"></i>Detail Aset</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body modal-body-custom" id="modal-body-content">
          <!-- Ajax Loader -->
          <div class="text-center py-5" id="modal-loader">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Memuat data aset...</p>
          </div>
          <!-- Real Content (hidden first) -->
          <div id="modal-real-content" class="d-none">
            <img src="" id="modal-image" class="modal-asset-img shadow-sm" alt="Foto Aset">
            <h4 class="fw-bold text-center mb-3" id="modal-asset-name"></h4>
            <div class="table-responsive">
              <table class="table table-striped table-hover small">
                <tr>
                  <th width="35%">Kategori</th>
                  <td>: <span id="modal-category"></span></td>
                </tr>
                <tr>
                  <th>Kondisi</th>
                  <td>: <span id="modal-condition"></span></td>
                </tr>
                <tr>
                  <th>Stok Total</th>
                  <td>: <span id="modal-stock"></span> unit</td>
                </tr>
                <tr>
                  <th>Stok Tersedia</th>
                  <td>: <span class="badge bg-success" id="modal-available"></span> unit</td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td>: <span id="modal-status"></span></td>
                </tr>
                <tr>
                  <th colspan="2">Deskripsi:</th>
                </tr>
                <tr>
                  <td colspan="2" id="modal-description" class="text-muted" style="line-height: 1.6;"></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 p-3 bg-light d-flex justify-content-between">
          <button type="button" class="btn btn-secondary btn-sm rounded" data-bs-dismiss="modal">Tutup</button>
          <?php if (session()->get('isLoggedIn') && session()->get('role') === 'member'): ?>
            <a href="<?= base_url('member/catalog') ?>" class="btn btn-primary btn-sm rounded"><i class="bi bi-cart-plus me-1"></i> Ajukan Peminjaman</a>
          <?php elseif (!session()->get('isLoggedIn')): ?>
            <a href="<?= base_url('login') ?>" class="btn btn-primary btn-sm rounded"><i class="bi bi-box-arrow-in-right me-1"></i> Login untuk Meminjam</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- Vendor JS Files -->
  <script src="<?= base_url('assets/FlexStart/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= base_url('assets/FlexStart/assets/vendor/aos/aos.js') ?>"></script>
  <script src="<?= base_url('assets/FlexStart/assets/vendor/glightbox/js/glightbox.min.js') ?>"></script>
  <script src="<?= base_url('assets/FlexStart/assets/vendor/purecounter/purecounter_vanilla.js') ?>"></script>
  <script src="<?= base_url('assets/FlexStart/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') ?>"></script>
  <script src="<?= base_url('assets/FlexStart/assets/vendor/isotope-layout/isotope.pkgd.min.js') ?>"></script>
  <script src="<?= base_url('assets/FlexStart/assets/vendor/swiper/swiper-bundle.min.js') ?>"></script>

  <!-- Main JS File -->
  <script src="<?= base_url('assets/FlexStart/assets/js/main.js') ?>"></script>

  <script>
    $(document).ready(function() {
      // Handle view asset detail click
      $('.view-asset-detail').on('click', function() {
        const id = $(this).data('id');
        const modal = new bootstrap.Modal(document.getElementById('detailModal'));
        
        // Reset modal
        $('#modal-loader').removeClass('d-none');
        $('#modal-real-content').addClass('d-none');
        
        modal.show();

        // Get details via AJAX
        $.ajax({
          url: '<?= base_url('asset') ?>/' + id,
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.status === 'success') {
              const data = response.data;
              $('#modal-image').attr('src', data.image);
              $('#modal-asset-name').text(data.name);
              $('#modal-category').text(data.category_name);
              const cond = data.condition.toLowerCase().trim();
              let badgeClass = 'badge bg-secondary text-white';
              if (cond === 'sangat baik') {
                  badgeClass = 'badge bg-success text-white';
              } else if (cond === 'baik') {
                  badgeClass = 'badge bg-warning text-dark';
              } else if (cond.indexOf('buruk') !== -1 || cond.indexOf('rusak') !== -1) {
                  badgeClass = 'badge bg-danger text-white';
              }
              $('#modal-condition').attr('class', badgeClass).text(data.condition);
              $('#modal-stock').text(data.stock);
              $('#modal-available').text(data.available_stock);
              $('#modal-status').text(data.status);
              $('#modal-description').html(data.description);
              
              // Toggle classes
              $('#modal-loader').addClass('d-none');
              $('#modal-real-content').removeClass('d-none');
            } else {
              $('#modal-body-content').html(`<div class="alert alert-danger">${response.message}</div>`);
            }
          },
          error: function() {
            $('#modal-body-content').html('<div class="alert alert-danger">Terjadi kesalahan koneksi server.</div>');
          }
        });
      });
    });
  </script>

</body>

</html>
