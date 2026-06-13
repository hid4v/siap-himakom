# SIAP-HIMAKOM

**Sistem Informasi Aset dan Peminjaman Himpunan Mahasiswa Ilmu Komputer (HIMAKOM) FMIPA Universitas Lambung Mangkurat.**

SIAP-HIMAKOM adalah platform web berbasis digital terpusat yang dirancang untuk memantau ketersediaan, mendokumentasikan, dan memproses pengajuan peminjaman aset operasional milik HIMAKOM FMIPA ULM secara cepat, akurat, dan transparan.

---

## 🚀 Fitur Utama

1. **Beranda Publik & Katalog Aset**: Halaman landing interaktif (menggunakan tema FlexStart) yang menampilkan profil organisasi HIMAKOM, Visi & Misi Program Studi Ilmu Komputer ULM, FAQ, Kontak, serta katalog produk yang menampilkan stok tersedia dan kondisi fisik barang secara *real-time*.
2. **Role-Based Access Control (RBAC)**:
   * **Admin**: Mengelola kategori aset, unit barang, registrasi pengguna, verifikasi peminjaman (menyetujui, menolak, mencatat peminjaman, dan pengembalian), serta memantau statistik dashboard.
   * **Member**: Melihat detail katalog aset, memasukkan barang ke keranjang peminjaman, mengisi form tujuan & tanggal sewa, mengajukan peminjaman, serta melacak riwayat transaksi peminjaman mereka.
3. **Dashboard Analitik (Admin)**: Visualisasi tren peminjaman bulanan (Line Chart) dan proporsi aset per kategori (Doughnut Chart) menggunakan **Chart.js**.
4. **DataTables Server-Side**: Pencarian, pengurutan, dan paginasi data secara instan menggunakan AJAX server-side processing pada halaman manajemen pengguna, kategori, aset, dan peminjaman.
5. **Modern UI UX Elements**:
   * Custom **Bootstrap Modal** interaktif untuk konfirmasi aksi (setujui/tolak/kembalikan peminjaman), menggantikan dialog `confirm()` bawaan browser.
   * **Toast Notification** otomatis dengan warna responsif (sukses/error) di pojok kanan atas untuk memberikan feedback instan kepada pengguna.
   * Konsistensi tipografi menggunakan font **Montserrat** dan ikon vektor **Bootstrap Icons**.

---

## 🛠️ Teknologi yang Digunakan

* **Backend**: PHP 8.2+ dengan framework **CodeIgniter 4.7**
* **Database**: **MySQL**
* **Frontend**:
  * **Bootstrap 5** (Layout UI)
  * **AdminLTE v4** (Layout Dashboard)
  * **FlexStart** (Layout Landing Page)
  * **jQuery** & **jQuery DataTables** (AJAX Tables)
  * **Chart.js** (Visualisasi Statistik)

---

## ⚙️ Petunjuk Instalasi & Setup Lokal

### Prerequisites
Pastikan komputer Anda sudah terpasang:
* Web Server (seperti XAMPP, Laragon, atau Ampps)
* PHP versi **8.2 atau lebih tinggi** (dengan ekstensi `intl` dan `mbstring` diaktifkan di `php.ini`)
* Composer
* Git

### Langkah-langkah Setup

1. **Clone Repository**
   ```bash
   git clone https://github.com/hid4v/siap-himakom.git
   cd siap-himakom
   ```

2. **Install Dependensi**
   Gunakan Composer untuk memasang dependensi project:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment (`.env`)**
   * Salin file default env ke `.env`:
     ```bash
     cp env .env
     ```
   * Buka file `.env` dan sesuaikan pengaturan berikut:
     ```env
     # Atur mode aplikasi ke development untuk menampilkan debugging log
     CI_ENVIRONMENT = development

     # Sesuaikan Base URL local Anda
     app.baseURL = 'http://localhost:8080/'

     # Konfigurasi koneksi Database MySQL Anda
     database.default.hostname = localhost
     database.default.database = siap_himakom
     database.default.username = root
     database.default.password = 
     database.default.DBDriver = MySQLi
     database.default.port = 3306
     ```

4. **Jalankan Migrasi Database**
   Buat seluruh tabel database yang diperlukan dengan command spark:
   ```bash
   php spark migrate
   ```

5. **Jalankan Seeding Data Awal**
   Isi database dengan data kategori, aset, dan akun percobaan bawaan menggunakan command seeder:
   ```bash
   php spark db:seed AppSeeder
   ```

6. **Jalankan Aplikasi**
   Jalankan local server internal CodeIgniter:
   ```bash
   php spark serve
   ```
   Buka browser Anda dan akses halaman di: **`http://localhost:8080`**

---

## 🔑 Akun Demo Percobaan

Setelah menjalankan data seeding, Anda dapat login menggunakan akun berikut:

* **Akun Admin**
  * Email: `admin@himakom.org`
  * Password: `admin123`
* **Akun Member**
  * Email: `member@himakom.org`
  * Password: `member123`

---

## 📂 Struktur Direktori Utama

* `app/Controllers/` - Logika pemrosesan request & routing
* `app/Database/` - File migrasi skema tabel dan data seeder
* `app/Models/` - Interaksi kueri tabel ke database MySQL
* `app/Views/` - Template antarmuka pengguna (Layouts, Public, Admin, Auth, Member)
* `public/css/` - File custom stylesheet eksternal yang dipecah dari internal views
* `public/uploads/assets/` - Folder penyimpanan berkas foto aset barang yang diunggah
