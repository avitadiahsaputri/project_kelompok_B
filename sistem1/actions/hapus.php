<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';

$id = $_GET['id'];

$paslon = ambilPaslon($id);
if ($paslon) {
    $foto = "../foto/" . $paslon['gambar1'];
    if (is_file($foto)) {
        unlink($foto);
    }

    if (hapusPaslon($id) !== false) {
        echo "<script>alert('Data Berhasil Di Hapus');document.location='../pages/input_data_paslon.php'</script>";
    } else {
        echo "<script>alert('Data Gagal Di Hapus, Coba ulangi lagi');document.location='../pages/input_data_paslon.php'</script>";
    }
}
?>
