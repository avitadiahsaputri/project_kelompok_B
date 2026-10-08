# E-Voting (Suara IPM)

Aplikasi pemilihan online berbasis web untuk memilih pasangan calon (paslon). Dibuat dengan **PHP native** dan **MySQL**.

## Fitur
- Login admin dan pemilih memakai NIM + kode akses
- Kelola data paslon (nomor urut, foto, visi, misi)
- Kelola DPT (daftar pemilih tetap): tambah, ubah, hapus, **impor dari Excel** (.xlsx)
- Pengaturan waktu mulai dan selesai pemilihan
- Voting (satu pemilih hanya bisa memilih sekali)
- Rekap dan grafik hasil suara, **unduh hasil ke Excel** (.xlsx)
- Lupa kode akses lewat email
- Hak akses: halaman admin hanya bisa dibuka admin, halaman voting hanya pemilih

## Struktur folder
| Folder / file | Isi |
|---|---|
| `index.php` | Halaman depan (landing page) |
| `login/admin/` | Halaman login admin (dicek ke tabel `admin`) |
| `login/pemilih/` | Halaman login pemilih (dicek ke tabel `tbl_siswa`) |
| `.htaccess` | Aturan Apache: matikan daftar isi folder, tutup akses web ke `model/`, `database/`, dan file konfigurasi |
| `sistem1/index.php` | Dashboard setelah login (admin dan pemilih) |
| `sistem1/pages/` | Halaman yang tampil: data pemilih, kandidat, data suara, hasil suara, voting, visi misi, cetak |
| `sistem1/actions/` | Skrip yang hanya memproses data lalu mengalihkan halaman: tambah/ubah/hapus pemilih, impor dan ekspor Excel, reset |
| `sistem1/view/` | Potongan halaman yang dipakai bersama: menu samping, footer, halaman kelas dan pengaturan |
| `sistem1/templates/` | Template Excel untuk impor DPT |
| `model/query.php` | **Semua query SQL** ada di satu file ini, memakai prepared statement |
| `model/auth.php` | Pengecekan login dan hak akses (`wajibAdmin()`, `wajibPemilih()`) |
| `model/url.php` | Membuat alamat yang benar dari folder mana pun (`urlProyek()`, `urlSistem()`) |
| `koneksi.php` | Membuat koneksi database (membaca `config.local.php`, atau `config.example.php` bila belum ada) |
| `config.example.php` | Contoh pengaturan database. Salin jadi `config.local.php` bila MySQL kamu berbeda dari bawaan XAMPP |
| `database/` | Tempat file SQL database, dibuat oleh kelompok (daftar tabel dan kolom ada di `docs/KAMUS_DATA.md`) |
| `assets/` | File statis menurut jenisnya: `css/` (base, components, pages), `js/`, `img/`, `fonts/`, `lib/` (library pihak ketiga) |
| `sistem1/assets/`, `sistem1/foto/` | Aset panel admin dan foto paslon yang diunggah |
| `vendor/` | Library Composer: PhpSpreadsheet (Excel) dan PHPMailer (email) |

## Cara kerja singkat
1. Halaman memanggil `wajibAdmin()` / `wajibPemilih()` dari `model/auth.php` di baris paling atas.
2. Halaman memuat `koneksi.php`, lalu `model/query.php`.
3. Halaman tidak menulis SQL sendiri, hanya memanggil fungsi seperti `cariPemilih()`, `ambilSemuaPaslon()`, `simpanSuara()`.

## Cara menjalankan (XAMPP)
Kebutuhan: PHP 8.x, ekstensi `mysqli`, `gd`, `zip` (untuk Excel), MySQL/MariaDB.

1. Pasang XAMPP, nyalakan **Apache** dan **MySQL**.
2. Di `xampp/php/php.ini` pastikan baris `extension=gd` dan `extension=zip` aktif (tanpa tanda `;`), lalu restart Apache.
3. Salin folder project ke `xampp/htdocs/`.
4. Buka `http://localhost/phpmyadmin`, buat database `suaraipm`, lalu **Import** file SQL dari folder `database/` setelah kelompok selesai membuatnya.
5. Pengaturan database: kalau MySQL kamu bawaan XAMPP (user `root`, tanpa password), tidak perlu mengubah apa pun. Kalau berbeda, salin `config.example.php` menjadi `config.local.php` lalu isi sesuai MySQL kamu (file ini tidak ikut Git).
6. Buka `http://localhost/project_kelompok_B/`.

Folder `vendor/` sudah disertakan, jadi tidak perlu `composer install`.

## Akun contoh
- Admin: login di `/login/admin/`, NIM `admin`, kode akses `admin123`
- Pemilih: login di `/login/pemilih/`, NIM `1001`, kode akses `pass1001`

## Catatan
Project ini dibuat saat kuliah D3 dan dirapikan seperlunya. Kode akses saat ini disimpan sebagai teks biasa, dan token CSRF belum ada pada tombol hapus/reset.
