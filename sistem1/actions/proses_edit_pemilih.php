<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tingkat = $_POST['tingkat'];
    $kelas = $_POST['kelas'];

    $kode_akses = date('dmY', strtotime(str_replace('/', '-', $lahir)));

    if (nimPemilihSudahAda($nim, $id)) {
        echo "<script>alert('NIS ini sudah terdaftar.'); window.location='../pages/upload_dpt.php';</script>";
    } else {
        $result = ubahPemilih($id, $nim, $nama, $kode_akses, $lahir, $jenis_kelamin, $kelas, $tingkat);

        if ($result !== false) {
            echo "<script>alert('Data berhasil diubah'); window.location='../pages/upload_dpt.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengubah data'); window.location='../pages/upload_dpt.php';</script>";
        }
    }
}
?>
