<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();

require '../../vendor/autoload.php';
include '../../koneksi.php';
require_once '../../model/query.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['import'])) {
    $file = $_FILES['excel_file']['tmp_name'];

    $spreadsheet = IOFactory::load($file);

    $sheet = $spreadsheet->getActiveSheet();
    $defaultLevel = "user";
    $sheetData = $sheet->toArray();
    foreach ($sheetData as $key => $row) {
        if ($key == 0) continue;

        $nim = $row[1];
        $nama = $row[2];
        $tgl_lahir_excel = $row[3];

        $tgl_lahir = null;
        if ($tgl_lahir_excel != '0000-00-00' && !empty($tgl_lahir_excel)) {
            $date = DateTime::createFromFormat('d/m/Y', $tgl_lahir_excel);
            if ($date !== false) {
                $tgl_lahir = $date->format('Y-m-d');
            } else {
                echo "Format tanggal tidak valid: $tgl_lahir_excel <br>";
            }
        }

        $jenis_kelamin = $row[4];
        $kelas = $row[5];
        $tingkat = $row[6];
        $kode_akses = date('dmY', strtotime(str_replace('/', '-', $tgl_lahir)));

    
        $hasil = tambahPemilih($nim, $kode_akses, $nama, $tgl_lahir, $jenis_kelamin, $kelas, $tingkat, $defaultLevel);

        if ($hasil === false) {
            echo "Gagal menyimpan data ke database.<br>";
        } else {
            if ($hasil > 0) {
            echo "<script>alert('Data berhasil disimpan'); window.location='../pages/upload_dpt.php';</script>";
            } else {
            echo "<script>alert('Terjadi kesalahan saat import data'); window.location='../pages/upload_dpt.php';</script>";
            }
        }
    }
     $koneksi->close();
}
?>
