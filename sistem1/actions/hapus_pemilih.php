<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';

if (isset($_GET['id'])) {
    if (hapusPemilih($_GET['id']) !== false) {
        echo "<script>
                alert('Data pemilih berhasil dihapus.');
                window.location.href = '../pages/upload_dpt.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data pemilih.');
                window.location.href = '../pages/upload_dpt.php';
              </script>";
    }
} else {
    echo "<script>
            alert('ID pemilih tidak ditemukan.');
            window.location.href = '../pages/upload_dpt.php';
          </script>";
}
?>
