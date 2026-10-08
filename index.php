<?php
session_start();
include 'koneksi.php';
require_once 'model/query.php';
$error_message = '';

$gusmint = ambilPengaturan();
$title = $gusmint['lembaga'];
?>

<html>
	<head>
    <title><?php echo $title; ?></title>
		<link rel="shortcut icon" href="assets/img/brand/logoipm.png">
		<link rel="stylesheet" href="assets/lib/bootstrap-3/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/pages/landing.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<script src="assets/lib/jquery/jquery.2.1.1.min.js"></script>
		<script src="assets/lib/bootstrap-3/bootstrap.js"></script>
		<script src="assets/js/pages/landing.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

		<style>
		
body {
    font-family: Arial, sans-serif;
}

.text-content {
    text-align: center;
    margin-top: 50px;
}

h1 {
    font-size: 48px;
    font-weight: bold;
}

.color-title {
    background: linear-gradient(to right, yellow, orange);
    -webkit-background-clip: text;
    color: transparent;
}

h2 {
    font-size: 24px;
    margin-bottom: 20px;
}

.login-container {
    margin-top: 20px;
}

.btn {
    text-decoration: none;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    font-size: 16px;
}

.btn:hover {
    background-color: #0056b3;
}

.custom-btn {
    font-family: 'Times New Roman', Times, serif;
}


.cover-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
 	background: linear-gradient(to right, #8BC34A, #558B2F);
     display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
    padding: 20px;
    box-sizing: border-box;
    text-align: left;
}


.navbar {
 background: linear-gradient(to right, #8BC34A, #f5d703, #558B2F);
     border: none;}

.navbar-default .navbar-brand {
    color: #fff;
}

.navbar-default .navbar-brand:hover,
.navbar-default .navbar-brand:focus {
    color: #fff;
}

.navbar-default .navbar-nav > li > a {
    color: #fff;
}

.navbar-default .navbar-nav > li > a:hover,
.navbar-default .navbar-nav > li > a:focus {
    color: #000;
}

.navbar-default .navbar-toggle {
    border-color: #fff;
}

.navbar-default .navbar-toggle .icon-bar {
    background-color: #fff;
}


.box-title {
    display: flex;
    align-items: center;
    padding: 20px;
    border-radius: 10px;
    color: #fff;
}

.cover-image {
    max-width: 200px;
    height: auto;
    margin-right: 20px;
}

.text-content {
    text-align: left;
    margin-top: 20px;
}

.text-content h1,
.text-content h2 {
    margin: 0;
    padding: 5px 0;
}

.login-container {
    margin-top: 20px;
}

.custom-btn {
    display: inline-block;
    background-color: #ffc107;
    color: #333;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    border: none;
}

.custom-btn:hover {
    background-color: #ffc107;
}

.primary {
    background-color: #f0f0f0;
    color: #333;
}

.danger {
    background-color: #f0f0f0;
    color: #333;
}

.gallery {
    margin-bottom: 20px;
}

.gallery-link {
    position: relative;
    display: block;
    overflow: hidden;
}

.caption {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    color: #fff;
    padding: 10px;
    text-align: center;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.caption:hover {
    transform: translateY(0);
}


.row.content {
    margin-botom: 20px;
}

#kandidat .zero-panel {
    background: linear-gradient(to right, #8BC34A, #f5d703, #558B2F);
    color: white;
    padding : 50px;
}

#kandidat .zero-panel-content {
    background: linear-gradient(to right, #8BC34A, #558B2F);
    padding: 5px;
    border-radius: 10px;
    color: white;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

#title-about {
    font-size: 36px;
    margin-bottom: 20px;
    color: #007bff;
}

.kandidat-card {
    background-color: #1E88E5;
    padding: 20px;
    margin: 10px 0;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    color: #FFFFFF;
}

.kandidat-card h3 {
    color: #007bff;
}

.kandidat-img {
    border: 3px solid #8BC34A;
    height: 150px;
}

.percentage {
    color: #28a745;
    font-weight: bold;
}

.kandidat-card b {
    display: block;
    margin-top: 10px;
    color: #333;
}

.kandidat-card center {
    margin-bottom: 10px;
    color: #555;
}


#galeri .zero-panel {
    background: linear-gradient(to right, #8BC34A, #558B2F);
    padding: 30px 15px;
    color: white;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}


#galeri h1 {
    font-size: 28px;
    margin-bottom: 20px;
    color: #558B2F;
}


#galeri p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 30px;
}

.gallery-link {
    position: relative;
    display: block;
    overflow: hidden;
    border-radius: 10px;
    margin-bottom: 20px;
}

.gallery-link:hover .caption-content {
    transform: translateY(0);
}

.caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: rgba(0, 0, 0, 0.6);
    color: white;
    padding: 10px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.caption-content {
    text-align: center;
}

.caption-content span {
    font-size: 18px;
    font-weight: bold;
}

.img-responsive {
    display: block;
    width: 100%;
    height: auto;
    transition: transform 0.3s ease;
}

.img-responsive:hover {
    transform: scale(1.05);
}

.zero-panel-content {
 	background: linear-gradient(to right, #8BC34A, #558B2F);
    padding: 5px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    text-align: center;
}

#kandidat .zero-panel-content h1 {
    font-size: 28px;
    margin-bottom: 20px;
    color: #000; 
}

.zero-panel-content p {
    font-size: 16px;
    line-height: 1.6;
    color: #666;
}

.zero-panel-content:hover {
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    transform: translateY(-5px);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}


#text-about-left img {
    transition: transform 0.3s ease;
}

#text-about-left img:hover {
    transform: scale(1.2);
}

.btn-primary {
    position: relative;
    display: inline-block;
    padding: 10px 20px;
    color: #fff;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    outline: none;
    text-align: center;
    overflow: hidden;
    transition: background 0.3s ease;
    background-image: linear-gradient(to right, #ffd700, #f7ca18);}

.btn-primary .gradient {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background-image: linear-gradient(to right, #f7ca18, #ffd700);
    transition: left 0.3s ease;
}

.btn-primary:hover .gradient {
    left: 0;
}
.btn-primary:active {
    background-color: #ffd700;
    background-image: none;
}

.btn-primary i {
    margin-left: 5px;
}

.btn-primary.btn-lg {
    font-size: 18px;
    padding: 15px 30px;
}

.role {
    margin-top: 15px;
    padding: 5px 10px;
    font-weight: bold;
    text-align: center;
    background-color: #ffd700;
    color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.role:hover {
    background-color: #ffd700;
}

.role:before {
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


.role:hover:before {
    transform: skewX(45deg) translateX(80%);
}


</style>
	</head>
	<body id="home" class="content danger">
		<nav class="navbar navbar-default navbar-fixed">
			<div class="container">
				<div class="navbar-header">
					<a href="." class="navbar-brand" style="margin-bottom: 15px;">
						<h1>SuaraIPM</h1>
						<h2 style="margin-bottom: 20px;">pondok pesantren KH.Ahmad Dahlan</h2>
					</a>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#zero-menu" aria-expanded="true" id="toggle-button">
						<span class="sr-only">Menu Utama</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
                <div class="navbar-collapse collapse" id="zero-menu" aria-expanded="true">
                <ul class="nav navbar-right">
                    <li>
                        <a href="#home" rel="page-scroll">Beranda</a>
                    </li>
                    <li>
                        <a href="#kandidat" rel="page-scroll" title="Kandidat Ketua OSIS">Kandidat</a>
                    </li>
                    <li>
                        <a href="#galeri" rel="page-scroll" title="Galeri Kegiatan OSIS">Galeri</a>
                    </li>
                    <li>
                        <a href="login/admin/" title="Login Admin">admin</a>
                    </li>
                </ul>
            </div>
			</div>
		</nav>

		<div class="cover">
    
</div>
		
        <div class="row content">
			<div class="cover-overlay">
				<div class="box-title">
            <img src="assets/img/brand/logo-uom.png" alt="Deskripsi Gambar" class="cover-image">
            <div class="text-content">
                <h1>Suara<span class="color-title">IPM</span></h1>
				<h2>Pemilihan Ketua IPM (Ikatan Pelajar Muhammadiyah)</h2>
				<p class="subtext">"Mari kita berpartisipasi dalam pemilihan yang jujur dan inklusif. Suara kita adalah Nuun, demi pena dan apa yang dituliskannya!"</p>
                <a href="login/pemilih/" class="btn btn-primary btn-lg role">Login Sekarang <i class="fas fa-arrow-right"></i></a>				
            </div>
        </div>
				<div class="clear"></div>
			</div>
		</div>


		<div class="row content" id="kandidat">
			<div class="col-md-12 primary text-center zero-panel">
				<div class="col-md-8 zero-panel-content">
                    <h1 style="text-align: center; color: #333;"> KANDIDAT IPM </h1>
                </div>
				<?php
                foreach (ambilSemuaPaslon() as $r) {
                    $nokandidat = $r['no_urut'];
                    $nama = $r['nm_paslon'];
                    $foto = $r['gambar1'];
                    $visi = $r['visi'];
                    $misi = $r['misi'];

                    $jumlahsuara = hitungSuaraPaslon($nokandidat);

                    $total_pemilih = hitungPemilih();

                    if ($total_pemilih > 0) {
                        $persentase_suara_kandidat = ($jumlahsuara / $total_pemilih) * 100;
                        $persentase_suara_kandidat = round($persentase_suara_kandidat);
                    } else {
                        $persentase_suara_kandidat = 0;
                    }

                    ?>
                    <div class="col-md-6 text-justify col-sm-6" id="text-about-left">
                        <center>
                            <h3>No. <?php echo $nokandidat; ?> - <?php echo $nama; ?></h3>
                            <img style="border-radius: 50%; width: 150px; height: 150px;" src="sistem1/foto/<?php echo $foto; ?>" alt="Foto Kandidat <?php echo $nokandidat; ?>">
                            <h2><?php echo $persentase_suara_kandidat; ?>%</h2>
                            <?php echo $jumlahsuara; ?> suara
                        </center>
                        <center><?php echo $visi; ?></center>
                        <center><?php echo $misi; ?></center>
                    </div>
                    <?php
                }
                ?>
				<div class="clear"></div>
			</div>
		</div>

		<div class="row content" id="galeri">
			<div class="col-md-12 primary text-center zero-panel">
				<div class="col-md-8 zero-panel-content">
                <h1 style="text-align: center; color: #333;"> GALERI KEGIATAN PONDOK </h1>
                <p>
                    Inilah beberapa kegiatan Pongdok yang terdokumentasikan.
                </p>
                </div>
				<div class="col-md-4 col-sm-6 gallery">
					<a class="gallery-link" href="#">
						<div class="caption">
							<div class="caption-content danger">
								<span>Sanlat 2017</span>
							</div>
						</div>
						<img src="assets/img/gallery/galeri1.jpg" class="img-responsive" alt>
					</a>
				</div>
				<div class="col-md-4 col-sm-6 gallery">
					<a class="gallery-link" href="#">
						<div class="caption">
							<div class="caption-content danger">
								<span>Tahun Ajaran Baru</span>
							</div>
						</div>
						<img src="assets/img/gallery/galeri2.jpg" class="img-responsive" alt>
					</a>
				</div>
				<div class="col-md-4 col-sm-6 gallery">
					<a class="gallery-link" href="#">
						<div class="caption">
							<div class="caption-content danger">
								<span>Ujian Tengah Semester</span>
							</div>
						</div>
						<img src="assets/img/gallery/galeri4.jpg" class="img-responsive" alt>
					</a>
				</div>
				<div class="col-md-4 col-sm-6 gallery">
					<a class="gallery-link" href="#">
						<div class="caption">
							<div class="caption-content danger">
								<span>Workshop Depicta 2016</span>
							</div>
						</div>
						<img src="assets/img/gallery/galeri8.jpg" class="img-responsive" alt>
					</a>
				</div>
				<div class="col-md-4 col-sm-6 gallery">
					<a class="gallery-link" href="#">
						<div class="caption">
							<div class="caption-content danger">
								<span>Sertijab 2014</span>
							</div>
						</div>
						<img src="assets/img/gallery/galeri5.jpg" class="img-responsive" alt>
					</a>
				</div>
				<div class="col-md-4 col-sm-6 gallery">
					<a class="gallery-link" href="#">
						<div class="caption">
							<div class="caption-content danger">
								<span>Nuzulul Qur'an</span>
							</div>
						</div>
						<img src="assets/img/gallery/galeri6.jpg" class="img-responsive" alt>
					</a>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<script type="text/javascript" src="assets/lib/jquery/jquery.easypiechart.min.js"></script>
	</body>
</html>
