<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';


if(isset($_GET['confirm'])) {
    $hapus = hapusSemuaPaslon() !== false;

    if($hapus) {
    echo "<script>alert('Data Berhasil Dihapus');document.location='../pages/input_data_paslon.php'</script>";
} else {
    echo "<script>alert('Data Gagal Dihapus, Coba ulangi lagi');document.location='../pages/input_data_paslon.php'</script>";
    }
}
?>