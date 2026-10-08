<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';

if (isset($_POST['simpan'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $kelas = $_POST['daftarKelas'];
    $tingkat = $_POST['tingkat'];

    $kode_akses = date('dmY', strtotime(str_replace('/', '-', $lahir)));

    if (nimPemilihSudahAda($nis)) {
        echo "<script>alert('NIS ini sudah terdaftar'); window.location='../pages/upload_dpt.php';</script>";
    } else {
        $result = tambahPemilih($nis, $kode_akses, $nama, $lahir, $jenis_kelamin, $kelas, $tingkat);

        if ($result !== false) {
            echo "<script>alert('Data berhasil ditambahkan'); window.location='../pages/upload_dpt.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menambahkan data'); window.location='../pages/upload_dpt.php';</script>";
        }
    }
}
?>
