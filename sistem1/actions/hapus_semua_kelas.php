<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';


if(isset($_GET['confirm'])) {
    $hapus = hapusSemuaKelas() !== false;

    if($hapus) {
    echo "<script>alert('Data Berhasil Dihapus');document.location='../index.php?page=kelas'</script>";
} else {
    echo "<script>alert('Data Gagal Dihapus');document.location='../index.php?page=kelas'</script>";
    }
}
?>