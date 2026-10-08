<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


function db_jalankan($sql, $tipe = '', $param = [])
{
    global $koneksi;
    $stmt = mysqli_prepare($koneksi, $sql);
    if ($tipe !== '') {
        mysqli_stmt_bind_param($stmt, $tipe, ...$param);
    }
    mysqli_stmt_execute($stmt);
    return $stmt;
}

function db_semua($sql, $tipe = '', $param = [])
{
    $stmt = db_jalankan($sql, $tipe, $param);
    $hasil = mysqli_stmt_get_result($stmt);
    $baris = $hasil ? mysqli_fetch_all($hasil, MYSQLI_ASSOC) : [];
    mysqli_stmt_close($stmt);
    return $baris;
}

function db_satu($sql, $tipe = '', $param = [])
{
    $baris = db_semua($sql, $tipe, $param);
    return $baris[0] ?? null;
}

function db_angka($sql, $tipe = '', $param = [])
{
    $baris = db_satu($sql, $tipe, $param);
    return $baris ? (int)array_values($baris)[0] : 0;
}

function db_eksekusi($sql, $tipe = '', $param = [])
{
    try {
        $stmt = db_jalankan($sql, $tipe, $param);
        $jumlah = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $jumlah;
    } catch (mysqli_sql_exception $e) {
        return false;
    }
}


function cariAdmin($nim, $kodeAkses)
{
    return db_satu(
        "SELECT * FROM admin WHERE nim = ? AND kode_akses = ?",
        'ss', [$nim, $kodeAkses]
    );
}

function cariAdminDenganEmail($email)
{
    return db_satu("SELECT * FROM admin WHERE email = ?", 's', [$email]);
}

function ambilAdminUtama()
{
    return db_satu("SELECT * FROM admin WHERE id = 1");
}

function ubahKodeAksesAdmin($id, $kodeBaru)
{
    return db_eksekusi(
        "UPDATE admin SET kode_akses = ? WHERE id = ?",
        'si', [$kodeBaru, (int)$id]
    );
}

function cariPemilih($nim, $kodeAkses)
{
    return db_satu(
        "SELECT * FROM tbl_siswa WHERE nim = ? AND kode_akses = ?",
        'ss', [$nim, $kodeAkses]
    );
}


function ambilPengaturan()
{
    return db_satu("SELECT * FROM pengaturan LIMIT 1");
}

function simpanPengaturan($lembaga, $email, $mulai, $selesai)
{
    return db_eksekusi(
        "UPDATE pengaturan SET lembaga = ?, email = ?, mulai = ?, selesai = ? WHERE id = 1",
        'ssss', [$lembaga, $email, $mulai, $selesai]
    );
}

function resetJadwalPemilihan()
{
    return db_eksekusi("UPDATE pengaturan SET mulai = NULL, selesai = NULL WHERE id = 1");
}

function cariPemilihDenganNim($nim)
{
    return db_satu("SELECT * FROM tbl_siswa WHERE nim = ?", 's', [$nim]);
}

function nimPemilihSudahAda($nim, $kecualiId = null)
{
    if ($kecualiId === null) {
        return db_angka("SELECT COUNT(*) FROM tbl_siswa WHERE nim = ?", 's', [$nim]) > 0;
    }
    return db_angka(
        "SELECT COUNT(*) FROM tbl_siswa WHERE nim = ? AND id != ?",
        'si', [$nim, (int)$kecualiId]
    ) > 0;
}

function tambahPemilih($nim, $kodeAkses, $nama, $tglLahir, $jenisKelamin, $kelas, $tingkat, $level = 'user')
{
    return db_eksekusi(
        "INSERT INTO tbl_siswa (nim, kode_akses, nama, tgl_lahir, jenis_kelamin, kelas, tingkat, level)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
        'ssssssss', [$nim, $kodeAkses, $nama, $tglLahir, $jenisKelamin, $kelas, $tingkat, $level]
    );
}

function ubahPemilih($id, $nim, $nama, $kodeAkses, $tglLahir, $jenisKelamin, $kelas, $tingkat)
{
    return db_eksekusi(
        "UPDATE tbl_siswa SET nim = ?, nama = ?, kode_akses = ?, tgl_lahir = ?, jenis_kelamin = ?, kelas = ?, tingkat = ?
         WHERE id = ?",
        'sssssssi', [$nim, $nama, $kodeAkses, $tglLahir, $jenisKelamin, $kelas, $tingkat, (int)$id]
    );
}

function hapusPemilih($id)
{
    return db_eksekusi("DELETE FROM tbl_siswa WHERE id = ?", 'i', [(int)$id]);
}

function hapusSemuaPemilih()
{
    return db_eksekusi("TRUNCATE TABLE tbl_siswa");
}

function cariDaftarPemilih($cari = null, $tingkat = null)
{
    if ($cari !== null) {
        return db_semua("SELECT * FROM tbl_siswa WHERE nama LIKE ?", 's', ['%' . $cari . '%']);
    }
    if ($tingkat !== null) {
        return db_semua("SELECT * FROM tbl_siswa WHERE tingkat = ? ORDER BY nama ASC", 's', [$tingkat]);
    }
    return db_semua("SELECT * FROM tbl_siswa ORDER BY nim ASC");
}

function ambilNamaPemilih()
{
    return array_column(db_semua("SELECT nama FROM tbl_siswa"), 'nama');
}

function namaPemilihAda($nama)
{
    return db_angka("SELECT COUNT(*) FROM tbl_siswa WHERE nama = ?", 's', [$nama]) > 0;
}

function hitungPemilih()
{
    return db_angka("SELECT COUNT(*) FROM tbl_siswa WHERE level = 'user'");
}


function ambilKelas($tingkat = null, $terbaruDulu = false)
{
    if ($tingkat !== null) {
        return db_semua("SELECT * FROM kelas WHERE tingkat = ?", 's', [$tingkat]);
    }
    return db_semua("SELECT * FROM kelas ORDER BY id " . ($terbaruDulu ? 'DESC' : 'ASC'));
}

function daftarNamaKelas($tingkat)
{
    return db_semua(
        "SELECT DISTINCT kelas FROM kelas WHERE tingkat = ? ORDER BY kelas ASC",
        's', [$tingkat]
    );
}

function kelasSudahAda($kelas, $tingkat)
{
    return db_angka(
        "SELECT COUNT(*) FROM kelas WHERE kelas = ? AND tingkat = ?",
        'ss', [$kelas, $tingkat]
    ) > 0;
}

function tambahKelas($kelas, $tingkat)
{
    return db_eksekusi("INSERT INTO kelas (kelas, tingkat) VALUES (?, ?)", 'ss', [$kelas, $tingkat]);
}

function hapusKelas($id)
{
    return db_eksekusi("DELETE FROM kelas WHERE id = ?", 'i', [(int)$id]);
}

function hapusSemuaKelas()
{
    return db_eksekusi("TRUNCATE TABLE kelas");
}


function ambilSemuaPaslon($urutkan = true)
{
    return db_semua("SELECT * FROM tbl_kandidat" . ($urutkan ? " ORDER BY no_urut ASC" : ""));
}

function ambilPaslon($id)
{
    return db_satu("SELECT * FROM tbl_kandidat WHERE id = ?", 'i', [(int)$id]);
}

function daftarNomorUrut()
{
    return array_column(
        db_semua("SELECT DISTINCT no_urut FROM tbl_kandidat ORDER BY no_urut ASC"),
        'no_urut'
    );
}

function hitungPaslon()
{
    return db_angka("SELECT COUNT(*) FROM tbl_kandidat");
}

function nomorUrutSudahAda($noUrut)
{
    return db_angka("SELECT COUNT(*) FROM tbl_kandidat WHERE no_urut = ?", 's', [$noUrut]) > 0;
}

function namaPaslonSudahAda($nama)
{
    return db_angka("SELECT COUNT(*) FROM tbl_kandidat WHERE nm_paslon = ?", 's', [$nama]) > 0;
}

function tambahPaslon($noUrut, $nama, $gambar, $visi, $misi)
{
    return db_eksekusi(
        "INSERT INTO tbl_kandidat (no_urut, nm_paslon, gambar1, visi, misi) VALUES (?, ?, ?, ?, ?)",
        'sssss', [$noUrut, $nama, $gambar, $visi, $misi]
    );
}

function ubahPaslon($id, $noUrut, $nama, $gambar, $visi, $misi)
{
    return db_eksekusi(
        "UPDATE tbl_kandidat SET no_urut = ?, nm_paslon = ?, gambar1 = ?, visi = ?, misi = ? WHERE id = ?",
        'sssssi', [$noUrut, $nama, $gambar, $visi, $misi, (int)$id]
    );
}

function hapusPaslon($id)
{
    return db_eksekusi("DELETE FROM tbl_kandidat WHERE id = ?", 'i', [(int)$id]);
}

function hapusSemuaPaslon()
{
    return db_eksekusi("TRUNCATE TABLE tbl_kandidat");
}


function cariSuara($nim)
{
    return db_satu("SELECT * FROM tbl_pemilihan WHERE nim = ? LIMIT 1", 's', [$nim]);
}

function sudahMemilih($nim)
{
    return cariSuara($nim) !== null;
}

function simpanSuara($nim, $nama, $kelas, $tingkat, array $pilihan, $waktu)
{
    $ok = true;
    foreach ($pilihan as $noUrut) {
        $stmt = db_jalankan(
            "INSERT INTO tbl_pemilihan (nim, nama, kelas, tingkat, vote, waktu) VALUES (?, ?, ?, ?, ?, ?)",
            'ssssis', [$nim, $nama, $kelas, $tingkat, (int)$noUrut, $waktu]
        );
        $ok = $ok && mysqli_stmt_affected_rows($stmt) === 1;
        mysqli_stmt_close($stmt);
    }
    return $ok;
}

function ambilSemuaSuara()
{
    return db_semua("SELECT * FROM tbl_pemilihan ORDER BY id ASC");
}

function ambilSuaraHalaman($mulai, $jumlah)
{
    return db_semua("SELECT * FROM tbl_pemilihan LIMIT ?, ?", 'ii', [(int)$mulai, (int)$jumlah]);
}

function ambilSuaraPaslon($noUrut)
{
    return db_semua("SELECT * FROM tbl_pemilihan WHERE vote = ?", 's', [$noUrut]);
}

function ambilSuaraUrutPilihan()
{
    return db_semua("SELECT * FROM tbl_pemilihan ORDER BY vote ASC");
}

function hitungSuaraPaslon($noUrut)
{
    return db_angka("SELECT COUNT(*) FROM tbl_pemilihan WHERE vote = ?", 's', [$noUrut]);
}

function hitungSemuaSuara()
{
    return db_angka("SELECT COUNT(*) FROM tbl_pemilihan");
}

function hitungPemilihYangMemilih()
{
    return db_angka("SELECT COUNT(DISTINCT nim) FROM tbl_pemilihan");
}

function hapusSemuaSuara()
{
    return db_eksekusi("TRUNCATE TABLE tbl_pemilihan");
}
