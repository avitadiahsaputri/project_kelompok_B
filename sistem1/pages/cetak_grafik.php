<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();

include '../../koneksi.php';
require_once '../../model/query.php';
$gusmint = ambilPengaturan();
$title = $gusmint['lembaga'];
$total_dpt = hitungPemilih();
$total_memilih = hitungPemilihYangMemilih();
?>
<!DOCTYPE html>
<html lang="id-ID">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../../assets/img/brand/Logo.png">
    <title>Laporan</title>
    <link rel="stylesheet" type="text/css" href="../../assets/css/components/sweetalert.css">
    <link href="../assets/css/bootstrap.css" rel="stylesheet" />
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href="../assets/css/custom.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="../assets/js/jquery-1.10.1.min.js"></script>
    <script src="../assets/js/highcharts.js"></script>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }

        .container {
            margin-top: 30px;
        }

        .page-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .report-info {
            margin-bottom: 20px;
        }

        .report-info table {
            width: 60%;
            margin: 0 auto;
        }

        .report-info table td {
            padding: 5px;
            font-weight: bold;
        }

        .candidate-table {
            width: 80%;
            margin: 0 auto;
        }

        .candidate-table th,
        .candidate-table td {
            text-align: center;
            padding: 8px;
        }

        .candidate-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="page-title">
            <img src="../../assets/img/brand/Logo.png" style="width:5%; height:auto;">
            <h4>LAPORAN PEROLEHAN SUARA</h4>
            <h5>PEMILIHAN KETUA IPM (Ikatan Pelajar Muhammadiyah)</h5>
            <h5>Pondok Pesantren KH. Ahmad Dahlan Sipirok</h5>
        </div>

        <div class="report-info">
            <table>
                <tr>
                    <td>Jumlah Pemilih</td>
                    <td>: <?php echo $total_dpt; ?></td>
                </tr>
                <tr>
                    <td>Total sudah memilih</td>
                    <td>: <?php echo $total_memilih; ?></td>
                </tr>
                <tr>
                    <td>Total belum memilih</td>
                    <td>: <?php echo $total_dpt - $total_memilih; ?></td>
                </tr>
            </table>
        </div>

        <div class="candidate-table">
            <table class="table table-striped table-bordered table-hover">
                <tr>
                    <th>No. Urut</th>
                    <th>Nama Kandidat</th>
                    <th>Jumlah Suara</th>
                </tr>
                <?php
                foreach (ambilSemuaPaslon() as $d) {
                    $vote = $d['no_urut'];
                    $jmlh_suara = hitungSuaraPaslon($vote);
                ?>
                    <tr>
                        <td><?php echo $vote; ?></td>
                        <td><?php echo $d['nm_paslon']; ?></td>
                        <td><?php echo $jmlh_suara; ?></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>

    <script>
        window.print();
    </script>

    <script src="assets
