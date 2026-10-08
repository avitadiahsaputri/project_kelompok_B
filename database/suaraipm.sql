-- Skema database E-Voting (suaraipm)
-- Direkonstruksi dari query yang dipakai di kode, plus data contoh untuk demo.
-- Import lewat phpMyAdmin: buka database suaraipm -> tab Import -> pilih file ini.

CREATE DATABASE IF NOT EXISTS suaraipm CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE suaraipm;

DROP TABLE IF EXISTS tbl_paslon, tbl_dpt, data_paslon, kelas, pengaturan, admin;

-- Akun admin (login di /login/admin/ memakai nim + kode_akses)
CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nim VARCHAR(30) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  kode_akses VARCHAR(50) NOT NULL,
  level VARCHAR(20) NOT NULL DEFAULT 'admin'
);

-- Pengaturan pemilihan (selalu 1 baris, id = 1)
CREATE TABLE pengaturan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  lembaga VARCHAR(150) NOT NULL,
  email VARCHAR(100) DEFAULT NULL,
  mulai DATETIME DEFAULT NULL,
  selesai DATETIME DEFAULT NULL
);

-- Daftar pemilih tetap (DPT)
CREATE TABLE tbl_dpt (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nim VARCHAR(30) NOT NULL,
  kode_akses VARCHAR(50) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  tgl_lahir VARCHAR(30) DEFAULT NULL,
  jenis_kelamin VARCHAR(20) DEFAULT NULL,
  kelas VARCHAR(30) DEFAULT NULL,
  tingkat VARCHAR(30) DEFAULT NULL,
  level VARCHAR(20) NOT NULL DEFAULT 'user'
);

-- Pasangan calon
CREATE TABLE data_paslon (
  id INT AUTO_INCREMENT PRIMARY KEY,
  no_urut INT NOT NULL,
  nm_paslon VARCHAR(150) NOT NULL,
  gambar1 VARCHAR(255) DEFAULT NULL,
  visi TEXT,
  misi TEXT
);

-- Suara masuk (kolom vote berisi no_urut paslon yang dipilih)
CREATE TABLE tbl_paslon (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nim VARCHAR(30) NOT NULL,
  nama VARCHAR(100) NOT NULL,
  kelas VARCHAR(30) DEFAULT NULL,
  tingkat VARCHAR(30) DEFAULT NULL,
  vote INT NOT NULL,
  waktu VARCHAR(20) DEFAULT NULL
);

CREATE TABLE kelas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kelas VARCHAR(30) NOT NULL,
  tingkat VARCHAR(30) NOT NULL
);

-- ===== Data contoh =====
-- Login admin: NIM "admin", kode akses "admin123"
INSERT INTO admin (nim, nama, email, kode_akses, level)
VALUES ('admin', 'Administrator', 'admin@example.com', 'admin123', 'admin');

INSERT INTO pengaturan (id, lembaga, email, mulai, selesai)
VALUES (1, 'Pemilihan Contoh', 'admin@example.com', '2024-01-01 08:00:00', '2030-12-31 17:00:00');

INSERT INTO kelas (kelas, tingkat) VALUES ('A', '1'), ('B', '1');

INSERT INTO tbl_dpt (nim, kode_akses, nama, tgl_lahir, jenis_kelamin, kelas, tingkat, level) VALUES
('1001', 'pass1001', 'Pemilih Satu', '2005-01-01', 'Laki-laki', 'A', '1', 'user'),
('1002', 'pass1002', 'Pemilih Dua',  '2005-02-02', 'Perempuan', 'A', '1', 'user'),
('1003', 'pass1003', 'Pemilih Tiga', '2005-03-03', 'Laki-laki', 'B', '1', 'user');

INSERT INTO data_paslon (no_urut, nm_paslon, gambar1, visi, misi) VALUES
(1, 'Paslon Satu', 'calon-1.png', 'Visi paslon satu', 'Misi paslon satu'),
(2, 'Paslon Dua',  'calon-2.png', 'Visi paslon dua',  'Misi paslon dua');
