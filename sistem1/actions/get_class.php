<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';

if (isset($_GET['tingkat'])) {
    echo json_encode(daftarNamaKelas($_GET['tingkat']));
}
?>
