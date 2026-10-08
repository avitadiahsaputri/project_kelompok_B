<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();

include '../../koneksi.php';
require_once '../../model/query.php';

if(isset($_GET['confirm'])) {
    $hapus = hapusSemuaSuara() !== false;

    if($hapus) {
    echo "<script>alert('Suara Masuk Berhasil Di Hapus');document.location='../pages/dpt.php'</script>";
    } else {
    echo "<script>alert('Suara Masuk Gagal Di Hapus, Coba ulangi lagi');document.location='../pages/dpt.php'</script>";
    }
}

?>


