# Spesifikasi Database E-Voting (`suaraipm`)

Dokumen ini untuk tim database. Isinya: data apa saja yang dibutuhkan aplikasi, kolom tiap tabel, relasi, aturan bisnis, dan yang harus dikerjakan.

> Aplikasi (PHP) **sudah jalan** dan memakai nama tabel/kolom di bawah. `database/suaraipm.sql` adalah skema awal hasil rekonstruksi dari kode, jadi **perlu diverifikasi dan diperbaiki**, bukan dianggap final.

## 1. Gambaran data

Sistem memilih pasangan calon (paslon). Data yang dikelola:

| Kebutuhan | Tabel |
|---|---|
| Akun admin | `admin` |
| Daftar pemilih tetap (DPT) dan akunnya | `tbl_siswa` |
| Kelas dan tingkat (untuk pilihan di form DPT) | `kelas` |
| Pasangan calon, termasuk foto, visi, misi | `tbl_kandidat` |
| Suara yang masuk | `tbl_pemilihan` |
| Pengaturan pemilihan (nama lembaga, jadwal) | `pengaturan` |

## 2. Detail tabel

Tipe kolom di sini adalah usulan awal. Ubah kalau ada alasan yang lebih baik, tapi **jangan ganti nama kolom tanpa memberi tahu tim aplikasi** (lihat bagian 6).

### `admin`: akun admin
| Kolom | Tipe | Aturan | Keterangan |
|---|---|---|---|
| id | INT | PK, auto increment | |
| nim | VARCHAR(30) | wajib, unik | dipakai untuk login |
| nama | VARCHAR(100) | wajib | |
| email | VARCHAR(100) | wajib | tujuan fitur lupa kode akses |
| kode_akses | VARCHAR(50) | wajib | login = nim + kode_akses |
| level | VARCHAR(20) | default `admin` | |

Dipakai: `login/admin/index.php`, `lupa_password.php`. Aplikasi **tidak punya fitur menambah admin**, jadi isi lewat SQL.

### `tbl_siswa`: pemilih tetap (sekaligus akun pemilih)
| Kolom | Tipe | Aturan | Keterangan |
|---|---|---|---|
| id | INT | PK, auto increment | |
| nim | VARCHAR(30) | wajib, **unik** | login pemilih |
| kode_akses | VARCHAR(50) | wajib | |
| nama | VARCHAR(100) | wajib | |
| tgl_lahir | VARCHAR(30) | boleh kosong | usul: pertimbangkan tipe DATE |
| jenis_kelamin | VARCHAR(20) | boleh kosong | |
| kelas | VARCHAR(30) | boleh kosong | harus ada di tabel `kelas` |
| tingkat | VARCHAR(30) | boleh kosong | |
| level | VARCHAR(20) | default `user` | nilai: `user` (pemilih) |

Dipakai: `login/pemilih/index.php` (login pemilih), `sistem1/pages/dpt.php`, `pages/upload_dpt.php`, `actions/import-pemilih.php` (impor Excel), `actions/add-pemilih.php`, `actions/proses_edit_pemilih.php`, `actions/hapus_pemilih.php`. Dashboard menghitung jumlah pemilih dengan `WHERE level = 'user'`.

### `kelas`
| Kolom | Tipe | Aturan |
|---|---|---|
| id | INT | PK, auto increment |
| kelas | VARCHAR(30) | wajib |
| tingkat | VARCHAR(30) | wajib |

Pasangan (`kelas`, `tingkat`) sebaiknya **unik**. Dipakai: `sistem1/view/kelas.php`, `sistem1/actions/get_class.php`.

### `tbl_kandidat`
| Kolom | Tipe | Aturan | Keterangan |
|---|---|---|---|
| id | INT | PK, auto increment | |
| no_urut | INT | wajib, **unik** | dipakai sebagai nilai suara |
| nm_paslon | VARCHAR(150) | wajib | |
| gambar1 | VARCHAR(255) | boleh kosong | **hanya nama file**, file ada di `sistem1/foto/` |
| visi | TEXT | | |
| misi | TEXT | | |

Dipakai: `sistem1/pages/input_data_paslon.php`, `pages/edit.php`, `pages/vote.php`, `pages/visi_misi.php`, halaman depan.

### `tbl_pemilihan`: suara masuk
| Kolom | Tipe | Aturan | Keterangan |
|---|---|---|---|
| id | INT | PK, auto increment | |
| nim | VARCHAR(30) | wajib | pemilih; FK ke `tbl_siswa.nim` |
| nama | VARCHAR(100) | wajib | salinan nama pemilih |
| kelas | VARCHAR(30) | | salinan |
| tingkat | VARCHAR(30) | | salinan |
| vote | INT | wajib | **nilai = `tbl_kandidat.no_urut`**, bukan `id` |
| waktu | VARCHAR(20) | | kode menyimpan format `H:i:sa`, contoh `09:50:38am` |

Aturan: **satu NIM hanya boleh punya suara sekali** (dicek di `sistem1/pages/vote.php` lewat fungsi `sudahMemilih()` di `model/query.php`). Usul: tambahkan UNIQUE pada `nim` supaya dijamin oleh database. Nama tabelnya membingungkan (isinya suara, bukan paslon), tapi **jangan diganti** karena dipakai di banyak file.

### `pengaturan`: selalu **1 baris** (`id = 1`)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | INT | PK, nilainya 1 |
| lembaga | VARCHAR(150) | nama lembaga, tampil sebagai judul halaman |
| email | VARCHAR(100) | |
| mulai | DATETIME | awal pemilihan, boleh NULL |
| selesai | DATETIME | akhir pemilihan, boleh NULL |

Tombol VOTE hanya muncul kalau waktu sekarang berada di antara `mulai` dan `selesai`.

## 3. Relasi

```
kelas (kelas, tingkat) 1 ──< tbl_siswa (kelas, tingkat)
tbl_siswa (nim)          1 ──< tbl_pemilihan (nim)        satu pemilih, maksimal satu suara
tbl_kandidat (no_urut)  1 ──< tbl_pemilihan (vote)       satu paslon, banyak suara
pengaturan             1 baris, berdiri sendiri
admin                  berdiri sendiri
```

Saat ini **belum ada foreign key sama sekali** di skema.

## 4. Aturan bisnis yang harus didukung database
1. NIM pemilih unik.
2. Satu pemilih hanya satu suara.
3. Nomor urut paslon unik.
4. Suara harus merujuk paslon yang ada.
5. Hasil = jumlah baris `tbl_pemilihan` per `vote`.
6. Reset memakai `TRUNCATE` pada `tbl_siswa`, `kelas`, `tbl_kandidat`, dan `tbl_pemilihan`. **Hati-hati kalau nanti dipasang FOREIGN KEY**, karena `TRUNCATE` ditolak pada tabel yang dirujuk FK. Atur urutan reset atau ganti dengan `DELETE`, lalu bicarakan dengan tim aplikasi.

## 5. Yang harus dikerjakan tim database
- [ ] Verifikasi skema `suaraipm.sql` terhadap daftar di atas.
- [ ] Tambahkan PRIMARY KEY, UNIQUE, dan FOREIGN KEY yang disebut di atas, lalu tes bahwa aplikasi masih jalan.
- [ ] Buat **ERD** (gambar) dan **kamus data** untuk laporan.
- [ ] Siapkan **data contoh** yang realistis: minimal 2 kelas atau lebih, 20+ pemilih, 2-3 paslon, 1 admin, dan 1 baris `pengaturan` dengan jadwal yang sedang aktif.
- [ ] Buat query laporan (rekap suara per paslon, per kelas, persentase partisipasi).
- [ ] Siapkan skrip backup dan restore.

## 6. Aturan kerja sama dengan tim aplikasi
- **Jangan mengganti nama tabel atau kolom** tanpa kabar. Aplikasi memakai nama ini langsung di sekitar 280 tempat dalam kode PHP.
- Menambah kolom baru yang boleh kosong aman. Menghapus atau mengganti nama kolom tidak.
- Tiap perubahan skema dicatat di `suaraipm.sql` (satu file acuan), dan beri tahu tim aplikasi.
- Cara tes: import `suaraipm.sql` lewat phpMyAdmin, lalu jalankan aplikasi dan coba login, voting, dan lihat hasil.

## 7. Akun contoh (dari data contoh saat ini)
- Admin: NIM `admin`, kode akses `admin123`
- Pemilih: NIM `1001`/`1002`/`1003`, kode akses `pass1001`/`pass1002`/`pass1003`

Catatan: kode akses saat ini disimpan **teks biasa** dan dibandingkan langsung oleh kode. Kalau nanti diubah menjadi hash, kode login di aplikasi juga harus diubah.

## 8. Catatan perubahan
- Tabel `tbl_akses` dihapus dari skema: satu-satunya halaman yang memakainya (`buat_akses.php`) sudah dibuang karena tidak ditautkan dari menu mana pun, dan kode akses pemilih dibuat otomatis dari tanggal lahir.
- `database/skema-lama-suaraipm.png` adalah gambar skema versi lama (nama tabel berbeda: `tbl_siswa`, `tbl_pemilihan`, `tbl_kandidat`). Hanya sebagai referensi.
