<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';
$gusmint = ambilPengaturan();
$title = $gusmint['lembaga'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../../assets/img/brand/Logo.png">
    <title><?php echo $title; ?></title>
    <link href="../assets/css/font-awesome.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.0/css/boxicons.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="../assets/js/jquery-1.10.1.min.js"></script>
    <script src="../assets/js/highcharts.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../css/hasil_suara.css">

    <link rel="stylesheet" href="../../assets/css/components/footer.css">
</head>
<body>
    <?php include "../view/header.php"; ?>
    <section id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <i class='bx bx-menu'></i>
        <form action="#" class="d-none">
            <div class="form-input">
                <input type="search">
                <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
            </div>
        </form>
        <div class="ml-auto d-flex align-items-center">
            <input type="checkbox" id="switch-mode" hidden>
            <a href="#" class="notification d-none mr-3">
                <i class='bx bxs-bell'></i>
            </a>
            <div class="profile">
            <img src="../assets/img/logo.png" alt="Profile Picture" id="profile-pic">
            <div class="profile-popup <?php echo $_SESSION['level'] == 'user' ? 'user' : 'non-user'; ?>" id="profile-popup">
            <?php if($_SESSION['level'] == 'user'){ ?>
                <h3><?php echo $d['nama']; ?></h3>
                <p><span>Nim</span>: <?php echo $d['nim']; ?></p>
                <p><span>Tanggal Lahir</span>: <?php echo date('d-m-Y', strtotime($d['tgl_lahir'])); ?></p>
                <p><span>Jenis Kelamin</span>: <?php echo $d['jenis_kelamin']; ?></p>
                <p><span>Tingkat</span>: <?php echo $d['tingkat']; ?></p><p><span>Kelas</span>: <?php echo $d['kelas']; ?></p>
                <p class="role"><?php echo $_SESSION['level']; ?></p>
                <?php } else { ?>
                    <h3><?php echo $_SESSION['nama']; ?></h3>
                    <p>Pondok pesantren KH.Ahmad Dahlan</p>
                    <p><?php echo $_SESSION['email']; ?></p>
                    <p class="role"><?php echo $_SESSION['level']; ?></p>
                <?php } ?>
            </div>
        </div>
    </nav>
        <div id="page-wrapper">
            <main>
                <div class="head-title">
                    <div class="left">
                        <h1>Hasil Suara</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Hasil Suara</a>
                            </li>
                            <li>
                                <i class='bx bx-chevron-right'></i>
                            </li>
                            <li>
                                <a class="active" href="#">Hasil Suara</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div id="page-inner" style="margin-top: 20px;">
                    <a class="btn" style="margin-bottom: 20px;" href="cetak_grafik.php" target="_blank"><i class="fa fa-print"> Laporan</i></a>
                    <div id="vote">
                        <div id="mygraph"></div>
                        <div id="mygraph11"></div>
                    </div>
                </div>
            </main>
           <?php include '../view/footer.php'; ?>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            var chart1 = new Highcharts.Chart({
                chart: {
                    renderTo: 'mygraph',
                    type: 'column'
                },
                title: {
                    text: 'Hasil Suara Pemilihan'
                },
                xAxis: {
                    categories: ['Nama Kandidat']
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Suara'
                    }
                },
                series: [
                    <?php
                    $data = [];
                    foreach (ambilSemuaPaslon(false) as $ambil) {
                        $i = $ambil['no_urut'];
                        $hasil = $ambil['nm_paslon'];
                        $suara = hitungSuaraPaslon($i);
                        $data[] = array('name' => $hasil, 'y' => $suara);
                    }
                    usort($data, function ($a, $b) {
                        return $b['y'] <=> $a['y'];
                    });
                    foreach ($data as $item) {
                    ?>
                    {
                        name: '<?php echo $item['name']; ?>',
                        data: [<?php echo $item['y']; ?>]
                    },
                    <?php } ?>
                ]
            });

            var chart2 = new Highcharts.Chart({
                chart: {
                    renderTo: 'mygraph11',
                    type: 'column'
                },
                title: {
                    text: 'Statistik Pemilihan'
                },
                xAxis: {
                    categories: ['Statistik']
                },
                yAxis: {
                    title: {
                        text: 'Jumlah Suara'
                    }
                },
                series: [
                    {
                        name: 'Sudah memilih',
                        data: [
                            <?php 
                            $suara_masuk = hitungSemuaSuara();
                            echo $suara_masuk;
                            ?>
                        ]
                    },
                    {
                        name: 'Belum memilih',
                        data: [
                            <?php 
                            $jumlah_dpt = hitungPemilih();
                            echo $jumlah_dpt - $suara_masuk;
                            ?>
                        ]    
                    }
                ]
            });
        });
    </script>
    <script>
         document.getElementById('profile-pic').addEventListener('click', function() {
            var popup = document.getElementById('profile-popup');
            popup.classList.toggle('active');
            this.classList.toggle('active');
        });

        window.addEventListener('click', function(event) {
            var popup = document.getElementById('profile-popup');
            var profilePic = document.getElementById('profile-pic');
            if (!popup.contains(event.target) && event.target !== profilePic) {
                popup.classList.remove('active');
                profilePic.classList.remove('active');
            }
    
        });
    </script>
    <script src="../assets/js/jquery-1.10.2.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script src="../../assets/js/pages/dashboard.js"></script>
</body>
</html>
