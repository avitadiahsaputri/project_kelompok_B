# Kamus Data E-Voting

**Nama database:** `suaraipm`

## Tabel yang dibutuhkan

| No | Tabel | Fungsi |
|---|---|---|
| 1 | `admin` | Akun admin (panitia) |
| 2 | `pengaturan` | Pengaturan pemilihan (nama lembaga, waktu mulai dan selesai) |
| 3 | `tbl_siswa` | Daftar pemilih (DPT) sekaligus akun login pemilih |
| 4 | `kelas` | Daftar kelas dan tingkatnya |
| 5 | `tbl_kandidat` | Pasangan calon yang dipilih |
| 6 | `tbl_pemilihan` | Suara yang sudah masuk |

## Kolom per tabel

### `admin`

| No | Kolom | Tipe data | Wajib | Kunci | Keterangan | Contoh |
|---|---|---|---|---|---|---|
| 1 | `id` | INT, auto increment | Ya | Primary key | Nomor urut baris | 1 |
| 2 | `nim` | VARCHAR(30) | Ya | | Nama pengguna untuk login | admin |
| 3 | `nama` | VARCHAR(100) | Ya | | Nama lengkap admin | Administrator |
| 4 | `email` | VARCHAR(100) | Ya | | Tujuan email lupa kode akses | admin@example.com |
| 5 | `kode_akses` | VARCHAR(50) | Ya | | Kata sandi login | admin123 |
| 6 | `level` | VARCHAR(20) | Ya, bawaan `admin` | | Peran akun | admin |

### `pengaturan`

| No | Kolom | Tipe data | Wajib | Kunci | Keterangan | Contoh |
|---|---|---|---|---|---|---|
| 1 | `id` | INT, auto increment | Ya | Primary key | Selalu bernilai 1 | 1 |
| 2 | `lembaga` | VARCHAR(150) | Ya | | Nama lembaga, tampil sebagai judul halaman | Pondok Pesantren KH. Ahmad Dahlan |
| 3 | `email` | VARCHAR(100) | Tidak | | Email kontak pemilihan | panitia@example.com |
| 4 | `mulai` | DATETIME | Tidak | | Waktu pemilihan dibuka | 2024-01-01 08:00:00 |
| 5 | `selesai` | DATETIME | Tidak | | Waktu pemilihan ditutup | 2030-12-31 17:00:00 |

### `tbl_siswa`

| No | Kolom | Tipe data | Wajib | Kunci | Keterangan | Contoh |
|---|---|---|---|---|---|---|
| 1 | `id` | INT, auto increment | Ya | Primary key | Nomor urut baris | 1 |
| 2 | `nim` | VARCHAR(30) | Ya | | Nomor induk, dipakai login | 1001 |
| 3 | `kode_akses` | VARCHAR(50) | Ya | | Kata sandi login pemilih | 01012005 |
| 4 | `nama` | VARCHAR(100) | Ya | | Nama lengkap pemilih | Pemilih Satu |
| 5 | `tgl_lahir` | VARCHAR(30) | Tidak | | Tanggal lahir | 2005-01-01 |
| 6 | `jenis_kelamin` | VARCHAR(20) | Tidak | | Laki-laki atau Perempuan | Laki-laki |
| 7 | `kelas` | VARCHAR(30) | Tidak | | Nama kelas | 7-A |
| 8 | `tingkat` | VARCHAR(30) | Tidak | | Jenjang, `MTS` atau `MA` | MTS |
| 9 | `level` | VARCHAR(20) | Ya, bawaan `user` | | Peran akun | user |

### `kelas`

| No | Kolom | Tipe data | Wajib | Kunci | Keterangan | Contoh |
|---|---|---|---|---|---|---|
| 1 | `id` | INT, auto increment | Ya | Primary key | Nomor urut baris | 1 |
| 2 | `kelas` | VARCHAR(30) | Ya | | Nama kelas | 7-A |
| 3 | `tingkat` | VARCHAR(30) | Ya | | Jenjang, `MTS` atau `MA` | MTS |

### `tbl_kandidat`

| No | Kolom | Tipe data | Wajib | Kunci | Keterangan | Contoh |
|---|---|---|---|---|---|---|
| 1 | `id` | INT, auto increment | Ya | Primary key | Nomor urut baris | 1 |
| 2 | `no_urut` | INT | Ya | | Nomor urut di kertas suara | 1 |
| 3 | `nm_paslon` | VARCHAR(150) | Ya | | Nama kandidat | Paslon Satu |
| 4 | `gambar1` | VARCHAR(255) | Tidak | | Nama file foto kandidat | calon-1.png |
| 5 | `visi` | TEXT | Tidak | | Visi kandidat | Visi paslon satu |
| 6 | `misi` | TEXT | Tidak | | Misi kandidat | Misi paslon satu |

### `tbl_pemilihan`

| No | Kolom | Tipe data | Wajib | Kunci | Keterangan | Contoh |
|---|---|---|---|---|---|---|
| 1 | `id` | INT, auto increment | Ya | Primary key | Nomor urut baris | 1 |
| 2 | `nim` | VARCHAR(30) | Ya | | NIM pemilih yang memberi suara | 1001 |
| 3 | `nama` | VARCHAR(100) | Ya | | Nama pemilih | Pemilih Satu |
| 4 | `kelas` | VARCHAR(30) | Tidak | | Kelas pemilih | 7-A |
| 5 | `tingkat` | VARCHAR(30) | Tidak | | Tingkat pemilih | MTS |
| 6 | `vote` | INT | Ya | | Nomor urut kandidat yang dipilih | 1 |
| 7 | `waktu` | VARCHAR(20) | Tidak | | Jam memilih | 09:15:02am |
