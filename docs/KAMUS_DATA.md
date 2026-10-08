# Kamus Data: E-Voting (Suara IPM)

Daftar semua tabel dan kolom di database `suaraipm`, apa adanya dari aplikasi sekarang. Dokumen ini jadi bahan diskusi kelompok: isi kolom **Usulan kelompok** kalau ada yang mau diubah, lalu putuskan bersama sebelum menulis SQL.

Skema asli ada di `database/suaraipm.sql`. Penjelasan lebih panjang ada di `database/SPESIFIKASI_DATABASE.md`.

## 1. Daftar tabel

| No | Tabel | Fungsi | Jumlah kolom |
|---|---|---|---|
| 1 | `admin` | Akun admin (panitia) | 6 |
| 2 | `pengaturan` | Pengaturan pemilihan, selalu 1 baris | 5 |
| 3 | `tbl_siswa` | Daftar pemilih (DPT) sekaligus akun login pemilih | 9 |
| 4 | `kelas` | Daftar kelas dan tingkatnya | 3 |
| 5 | `tbl_kandidat` | Pasangan calon yang dipilih | 6 |
| 6 | `tbl_pemilihan` | Suara yang sudah masuk | 7 |

## 2. Detail kolom per tabel

### 2.1 `admin` (akun admin)

| No | Kolom | Tipe data | Wajib | Kunci | Keterangan | Contoh | Usulan kelompok |
|---|---|---|---|---|---|---|---|
| 1 | `id` | INT, auto increment | Ya | Primary key | Nomor urut baris | 1 | |
| 2 | `nim` | VARCHAR(30) | Ya | belum unik | Nama pengguna untuk login | admin | |
| 3 | `nama` | VARCHAR(100) | Ya | | Nama lengkap admin | Administrator | |
| 4 | `email` | VARCHAR(100) | Ya | | Tujuan email lupa kode akses | admin@example.com | |
| 5 | `kode_akses` | VARCHAR(50) | Ya | | Kata sandi login (teks biasa) | admin123 | |
| 6 | `level` | VARCHAR(20) | Ya, bawaan `admin` | | Peran akun | admin | |

### 2.2 `pengaturan` (selalu 1 baris, `id = 1`)

| No | Kolom | Tipe data | Wajib | Kunci | Keterangan | Contoh | Usulan kelompok |
|---|---|---|---|---|---|---|---|
| 1 | `id` | INT, auto increment | Ya | Primary key | Selalu bernilai 1 | 1 | |
| 2 | `lembaga` | VARCHAR(150) | Ya | | Nama lembaga, tampil sebagai judul halaman | Pondok Pesantren KH. Ahmad Dahlan | |
| 3 | `email` | VARCHAR(100) | Tidak | | Email kontak pemilihan | panitia@example.com | |
| 4 | `mulai` | DATETIME | Tidak | | Waktu pemilihan dibuka | 2024-01-01 08:00:00 | |
| 5 | `selesai` | DATETIME | Tidak | | Waktu pemilihan ditutup | 2030-12-31 17:00:00 | |

### 2.3 `tbl_siswa` (daftar pemilih dan akun pemilih)

| No | Kolom | Tipe data | Wajib | Kunci | Keterangan | Contoh | Usulan kelompok |
|---|---|---|---|---|---|---|---|
| 1 | `id` | INT, auto increment | Ya | Primary key | Nomor urut baris | 1 | |
| 2 | `nim` | VARCHAR(30) | Ya | belum unik | Nomor induk, dipakai login | 1001 | |
| 3 | `kode_akses` | VARCHAR(50) | Ya | | Kata sandi login pemilih; saat impor dibuat dari tanggal lahir (`ddmmyyyy`) | 01012005 | |
| 4 | `nama` | VARCHAR(100) | Ya | | Nama lengkap pemilih | Pemilih Satu | |
| 5 | `tgl_lahir` | VARCHAR(30) | Tidak | | Tanggal lahir, sekarang tersimpan sebagai teks | 2005-01-01 | |
| 6 | `jenis_kelamin` | VARCHAR(20) | Tidak | | Laki-laki atau Perempuan | Laki-laki | |
| 7 | `kelas` | VARCHAR(30) | Tidak | belum relasi | Nama kelas dalam bentuk teks | 7-A | |
| 8 | `tingkat` | VARCHAR(30) | Tidak | | Jenjang, `MTS` atau `MA` | MTS | |
| 9 | `level` | VARCHAR(20) | Ya, bawaan `user` | | Peran akun | user | |

### 2.4 `kelas`

| No | Kolom | Tipe data | Wajib | Kunci | Keterangan | Contoh | Usulan kelompok |
|---|---|---|---|---|---|---|---|
| 1 | `id` | INT, auto increment | Ya | Primary key | Nomor urut baris | 1 | |
| 2 | `kelas` | VARCHAR(30) | Ya | | Nama kelas | 7-A | |
| 3 | `tingkat` | VARCHAR(30) | Ya | | Jenjang, `MTS` atau `MA` | MTS | |

### 2.5 `tbl_kandidat` (pasangan calon)

| No | Kolom | Tipe data | Wajib | Kunci | Keterangan | Contoh | Usulan kelompok |
|---|---|---|---|---|---|---|---|
| 1 | `id` | INT, auto increment | Ya | Primary key | Nomor urut baris | 1 | |
| 2 | `no_urut` | INT | Ya | belum unik | Nomor urut di kertas suara; nilai ini yang tersimpan sebagai suara | 1 | |
| 3 | `nm_paslon` | VARCHAR(150) | Ya | | Nama kandidat (harus ada di daftar pemilih) | Paslon Satu | |
| 4 | `gambar1` | VARCHAR(255) | Tidak | | Hanya nama file foto, filenya ada di `sistem1/foto/` | calon-1.png | |
| 5 | `visi` | TEXT | Tidak | | Visi kandidat | Visi paslon satu | |
| 6 | `misi` | TEXT | Tidak | | Misi kandidat | Misi paslon satu | |

### 2.6 `tbl_pemilihan` (suara yang masuk)

| No | Kolom | Tipe data | Wajib | Kunci | Keterangan | Contoh | Usulan kelompok |
|---|---|---|---|---|---|---|---|
| 1 | `id` | INT, auto increment | Ya | Primary key | Nomor urut baris | 1 | |
| 2 | `nim` | VARCHAR(30) | Ya | belum relasi | Pemilih yang memberi suara (merujuk `tbl_siswa.nim`) | 1001 | |
| 3 | `nama` | VARCHAR(100) | Ya | | Salinan nama pemilih saat memilih | Pemilih Satu | |
| 4 | `kelas` | VARCHAR(30) | Tidak | | Salinan kelas pemilih | 7-A | |
| 5 | `tingkat` | VARCHAR(30) | Tidak | | Salinan tingkat pemilih | MTS | |
| 6 | `vote` | INT | Ya | belum relasi | Nomor urut kandidat yang dipilih (merujuk `tbl_kandidat.no_urut`, bukan `id`) | 1 | |
| 7 | `waktu` | VARCHAR(20) | Tidak | | Jam memilih, format `H:i:sa` | 09:15:02am | |

## 3. Hubungan antartabel

Saat ini **belum ada foreign key** di database. Hubungan di bawah hanya berlaku di kode aplikasi.

| Dari | Ke | Arti |
|---|---|---|
| `tbl_pemilihan.nim` | `tbl_siswa.nim` | Satu pemilih bisa punya suara |
| `tbl_pemilihan.vote` | `tbl_kandidat.no_urut` | Suara menunjuk satu kandidat |
| `tbl_siswa.kelas` + `tbl_siswa.tingkat` | `kelas.kelas` + `kelas.tingkat` | Pemilih berada di satu kelas |
| `pengaturan` dan `admin` | - | Berdiri sendiri |

## 4. Aturan yang harus dijaga

1. NIM pemilih tidak boleh kembar.
2. Satu pemilih hanya boleh punya satu suara.
3. Nomor urut kandidat tidak boleh kembar.
4. Suara harus menunjuk kandidat yang ada.
5. Hasil suara = jumlah baris `tbl_pemilihan` per nilai `vote`.
6. Tombol reset memakai `TRUNCATE`, yang ditolak MySQL pada tabel yang dirujuk foreign key. Kalau foreign key ditambahkan, urutan reset di aplikasi perlu disesuaikan.

## 5. Pertanyaan desain untuk diputuskan bersama

Tulis keputusan di kolom **Keputusan**.

| No | Pertanyaan | Keputusan |
|---|---|---|
| 1 | `tbl_pemilihan` menyimpan lagi nama, kelas, dan tingkat pemilih. Cukup simpan NIM saja dan ambil sisanya lewat relasi? | |
| 2 | `tbl_siswa.kelas` berupa teks. Diganti menjadi relasi ke tabel `kelas` lewat id? | |
| 3 | `admin` dan `tbl_siswa` sama-sama akun yang login dengan NIM dan kode akses. Digabung jadi satu tabel dengan kolom peran, atau tetap dipisah? | |
| 4 | `tgl_lahir` dan `waktu` sekarang teks. Diubah menjadi tipe tanggal dan waktu sungguhan? | |
| 5 | Aturan "satu pemilih satu suara" dijamin juga oleh database (aturan unik), bukan hanya oleh kode? | |
| 6 | `kode_akses` disimpan teks biasa. Dienkripsi (hash)? | |
| 7 | Perlu kebutuhan baru, misalnya beberapa periode pemilihan atau log perubahan? | |
