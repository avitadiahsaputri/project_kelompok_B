<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';


if(isset($_GET['confirm'])) {
    $hapus = hapusSemuaPemilih() !== false;

    if($hapus) {
    echo "<script>alert('Data Berhasil Dihapus');document.location='../pages/upload_dpt.php'</script>";
} else {
    echo "<script>alert('Data Gagal Dihapus, Coba ulangi lagi');document.location='../pages/upload_dpt.php'</script>";
    }
}
?>
