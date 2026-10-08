<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("location:../index.php");
    exit;
}
include '../koneksi.php';
require_once '../model/query.php';
require_once '../model/url.php';

if ($_SESSION['level'] == 'admin') {

    $gusmint = ambilPengaturan();
    $title = $gusmint['lembaga'];
    $total_dpt = hitungPemilih();

    $total_kandidat = hitungPaslon();

    $total_memilih = hitungPemilihYangMemilih();

} elseif ($_SESSION['level'] == 'user') {
    $nim = $_SESSION['nim'];
    $d = cariPemilihDenganNim($nim);

    $gusmint = ambilPengaturan();
    $title = $gusmint['lembaga'];
}


$page = 1;

if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/brand/Logo.png">
    <title><?php echo $title; ?></title>

	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.0/css/boxicons.min.css">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
    @import url("https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap");


.nav-link {
            color: var(--dark);
            text-decoration: none;
            font-size: 16px;
            transition: 0.3s ease;
            text-align: center;
        }


        @media (max-width: 768px) {

            .nav-link {
                font-size: 14px;
            }
        }
        .sidebar a,
        .sidebar li {
          color: inherit;
          text-decoration: none;
        }

        .btn-warning.btn-circle {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            background-color: #ffc107;
            color: white;
        }

        .btn-warning.btn-circle:hover {
            background-color: #e0a800;
            color: white;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #333;
            color: #fff;
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
    <link rel="stylesheet" href="../assets/css/components/footer.css">
</head>
<body>  
    <?php include "view/header.php";?>
    <section id="content">
        <nav>
            <i class='bx bx-menu' ></i>
            <a href="#" class="nav-link"></a>
            <form action="#" >
                <div class="form-input" style="display: none;">
                    <input type="search" >
                    <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <a href="#" class="notification" style="display: none;">
                <i class='bx bxs-bell' ></i>
            </a>
            <div class="profile">
                <img src="assets/img/logo.png" alt="Profile Picture" id="profile-pic">
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
            <?php 
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                    switch ($page) {
                            case 'home':
                                include "view/home.php";
                                break;
                            case 'kelas':
                                include "view/kelas.php";
                                break;
                            case 'pengaturan':
                                include "view/setting.php";
                                break;			
                            default:
                                echo "<center><h3>Maaf. Halaman tidak di temukan !</h3></center>";
                                break;
                        }
                }else{
                    include "view/home.php";
                }
            ?>

            <?php include 'view/footer.php'; ?>
        </div>    
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
    </script>
    <script src="assets/js/script.js"></script>
    <script src="../assets/js/components/sweetalert.min.js"></script>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>   