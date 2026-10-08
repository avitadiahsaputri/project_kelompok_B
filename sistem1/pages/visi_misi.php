<?php
session_start();
if($_SESSION['level'] != 'user') {
    header("Location: ../index.php");
    exit();
}

include "../../koneksi.php";
require_once '../../model/query.php';
require_once '../../model/url.php';

$gusmint = ambilPengaturan();

if ($gusmint) {
    $title = $gusmint['lembaga'];
} else {
    echo "Data tidak ditemukan.";
}

if ($_SESSION['level'] == 'admin') {

    $gusmint = ambilPengaturan();
    $title = $gusmint['lembaga'];
  

} elseif ($_SESSION['level'] == 'user') {
    $nim = $_SESSION['nim'];
    $d = cariPemilihDenganNim($nim);

    $gusmint = ambilPengaturan();
    $title = $gusmint['lembaga'];
}

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

 <style>
        :root {
            --blue: #3c91e6;
            --dark: #342e37;
            --red: #db504a;
        }


.nav-link {
            color: var(--dark);
            text-decoration: none;
            font-size: 16px;
            transition: 0.3s ease;
            text-align: center;
        }

        .nav-link:hover {
            color: var(--blue);
        }

        @media (max-width: 768px) {

            .nav-link {
                font-size: 14px;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th,
        tbody td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        thead th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        tbody td {
            background-color: #fff;
            color: #333;
        }
        .table-data .order {
            background-color: rgba(0, 128, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
        }

        .table-data {
            background-color: rgba(255, 255, 255, 0.3);
            padding: 20px;
            border-radius: 20px;
        }

        .order .head {
            text-align: center;
        }

        .order .head h2 {
            margin-top: 0;
            color: var(--dark);
        }

        .order .head p {
            margin-bottom: 10px;
            color: var(--dark);
        }

        .order .head marquee {
            color: black;
        }

        .candidate-photo-container {
            position: relative;
            overflow: hidden;
        }

        .candidate-photo {
            width: 100px;
            height: auto;
            border-radius: 50%;
            transition: transform 0.3s;
        }

        .candidate-info {
            position: absolute;
            top: 0;
            left: 110%;
            width: 200px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            transition: left 0.3s;
            visibility: hidden;
            opacity: 0;
        }

        .candidate-photo-container:hover .candidate-photo {
            transform: scale(1.2);
        }

        .candidate-photo-container:hover .candidate-info {
            left: 100%;
            visibility: visible;
            opacity: 1;
        }

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            background-color: rgba(0, 0, 0, 0.8);
            width: 70%;
            height: 70%;
            display: none;
            padding: 20px;
            box-sizing: border-box;
        }

        .popup-content {
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .popup-left img {
            margin-left: 100px;
            margin-top: 50px;
            background-color: white;
            opacity: 0.8;
            width: 100%;
            max-height: 100%;
        }

        .popup-right {
            flex: 1;
            margin-left: 20px;
        }
        .popup-content {
            color: white;
            text-align: center;
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            color: white;
        }

        .sidebar a,
        .sidebar li {
            color: inherit;
            text-decoration: none;
        }

        .sidebar a:hover,
        .sidebar li:hover {
            color: inherit;
            background-color: inherit;
            text-decoration: none;
        }

        .percentage {
            font-size: 50px;
            text-align: center;
            justify-content: space-between;
            color: yellow;

        }

        .profile {
            position: relative;
            cursor: pointer;
        }

        .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            transition: border-color 0.3s;
        }

        .profile img.active {
            border: 2px solid green;
        }

        .profile-popup {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border-radius: 10px;
            z-index: 100;
            width: 300px;
        }


        .profile-popup.active {
            display: block;
        }

        .profile-popup h3 {
            margin-top: 0;
            margin-bottom: 10px;
            text-align: center;
        }

        .profile-popup p {
            margin: 5px 0;
            text-align: left;
        }

        .profile-popup .role {
            margin-top: 15px;
            padding: 5px 10px;
            font-weight: bold;
            text-align: center;
            background-color: #28a745;
            color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .profile-popup .role:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 120%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.2);
            transform: skewX(45deg) translateX(-80%);
            transition: transform 0.3s;
        }


        .profile-popup .role:hover:before {
            transform: skewX(45deg) translateX(80%);
        }

        .profile-popup h3 {
            font-weight: bold;
        }

        .profile-popup.user p:nth-of-type(1),
        .profile-popup.user p:nth-of-type(2),
        .profile-popup.user p:nth-of-type(3),
        .profile-popup.user p:nth-of-type(4),
        .profile-popup.user p:nth-of-type(5) {
            color: #ccc;
        }

        .profile-popup.user p span {
            display: inline-block;
            width: 100px;
            text-align: left
            margin-right: 10px;
        }
        .profile-popup.non-user p:nth-last-of-type(2) {
            font-weight: bold;
        }
        .profile-popup.non-user p:nth-of-type(1) {
            margin-bottom: 5px;
            font-size: 14px;
            text-align: center;
            color: #ccc;
        }
        .profile-popup.non-user p:nth-of-type(2) {
            font-size: 12px;
            color: #ccc;
            text-align: center;
            font-style: italic;
        }
</style>
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
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Kandidat</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>No Urut</th>
                                <th>Nama</th>
								<th>Foto</th>
                                <th>Visi</th>
                                <th>Misi</th>
                            </tr>
                        </thead>

                       <tbody>
                            <?php
                            foreach (ambilSemuaPaslon() as $d) {
                            ?>
                            <tr>
                                <td><?php echo $d['no_urut']; ?></td>
                                <td><?php echo $d['nm_paslon']; ?></td>
                                <td class='candidate-photo-container'>
                                    <img class='candidate-photo' onclick='showPopup(this)' src="<?php echo "../foto/" . $d['gambar1']; ?>">
                                    <div class='popup'>
                                        <div class='popup-content'>
                                            <span class='close-btn' onclick='hidePopup(this)'>&times;</span>
                                            <div class='popup-left'>
                                                <img  style="width: 300px; height: 300px;" src='<?php echo "../foto/" . $d['gambar1']; ?>'>
                                            </div>
                                            <div class='popup-right'>
                                            <h4>Visi</h4>
                                            <p><?php echo $d['visi']; ?></p>
                                            <h4>Misi</h4>
                                            <p><?php echo $d['misi']; ?></p>
                                            <h4>Vote</h4>
                                            <p class="percentage">
                                            <?php
                                            $no_urut_dipilih = $d['no_urut'];

                                            $jumlah_suara_kandidat = hitungSuaraPaslon($no_urut_dipilih);

                                            $total_pemilih = hitungPemilih();

                                            $total_suara_semua_pemilih = $total_pemilih;

                                            $jumlah_suara_kandidat_lainnya = $total_suara_semua_pemilih - $jumlah_suara_kandidat;

                                            $persentase_suara_kandidat = ($jumlah_suara_kandidat / $total_suara_semua_pemilih) * 100;


                                            $persentase_suara_kandidat = round($persentase_suara_kandidat);
                                            echo $persentase_suara_kandidat . "%<br>";
                                            ?>
                                            </p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $d['visi']; ?></td>
                                <td><?php echo $d['misi']; ?></td>                           
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </main>
          
        </div>
         <?php include '../view/footer.php'; ?>
    </section>
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
        function showPopup(image) {
            var popup = image.nextElementSibling;
            popup.style.display = "block";
        }

        function hidePopup(closeBtn) {
            var popup = closeBtn.parentNode.parentNode;
            popup.style.display = "none";
        }
    </script>
    <script src="../assets/js/jquery-1.10.2.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/custom.js"></script>
    <script src="../../assets/js/pages/dashboard.js"></script>
</body>
</html>
