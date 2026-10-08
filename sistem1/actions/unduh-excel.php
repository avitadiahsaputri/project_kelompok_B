<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
require '../../vendor/autoload.php';
include '../../koneksi.php';
require_once '../../model/query.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Data');

$sheet->fromArray(['Nomor', 'Username', 'Nama', 'Pilihan', 'Waktu'], null, 'A1');

$baris = 2;
foreach (ambilSemuaSuara() as $suara) {
    $sheet->fromArray(
        [$suara['id'], $suara['nim'], $suara['nama'], $suara['vote'], $suara['waktu']],
        null,
        'A' . $baris
    );
    $baris++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="data-suara.xlsx"');
header('Cache-Control: max-age=0');

(new Xlsx($spreadsheet))->save('php://output');
mysqli_close($koneksi);
