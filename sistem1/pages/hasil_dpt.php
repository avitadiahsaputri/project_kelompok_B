<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';
$gusmint = ambilPengaturan();
$title = $gusmint['lembaga'];

if (isset($_GET['nomorUrut']) && $_GET['nomorUrut'] !== "Semua") {
    $result = ambilSuaraPaslon($_GET['nomorUrut']);
} else {
     $result = ambilSuaraUrutPilihan();

}
?>


<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="shortcut icon" href="../../assets/img/brand/Logo.png">
    <title><?php echo $title; ?></title>
  <link href="../assets/css/font-awesome.css" rel="stylesheet" />
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.0/css/boxicons.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../css/dpt.css">


    <link rel="stylesheet" href="../../assets/css/components/footer.css">
</head>
<body> 
	

    <?php include "../view/header.php";?>
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
        </nav>
        <div id="page-wrapper"> 
           <main>
			<div class="head-title">
				<div class="left">
					<h1>Data Suara</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Data Suara</a>
                		</li>
						<li>
							<i class='bx bx-chevron-right'></i>
						</li>
                		<li>
                		    <a class="active" href="#">Data Suara</a>
                		</li>
            		</ul>
				</div>
			</div>

			<div class="table-data">
                
				<div class="order">
                    
                    <a class="btn btn-danger" href="../actions/reset_suara.php?confirm=true" onclick="return confirm('Anda yakin ingin menghapus semua data?')">Reset Suara</a>

                    <div class="container">

                    <form action="#" method="GET" id="filterForm" class="filter-form">
                    <div class="filter-wrapper">
                        <select id="nomorUrut"  name="nomorUrut" class="form-control">
                            <option value="Semua">No</option>
                            <?php
                            foreach (daftarNomorUrut() as $nomor_urut) {
                                echo "<option value='$nomor_urut'>$nomor_urut</option>";
                            }
                            ?>
                        </select>
                        <input   type="submit" class="btn btn-success" value="pilih">
                    </div>
                    </form>

                </div>   
					<div class="table-responsive"  style="margin-top: 20px;">
						<table id="tabel" class="table table-striped table-bordered table-hover">
							<thead>
							<tr>
								<th style="text-align:center;">No</th>
								<th style="text-align:center;">Username</th>
								<th style="text-align:center;">nama</th>
								<th style="text-align:center;">Pilihan</th>
								<th style="text-align:center;">Waktu</th>
                    		</tr>
							</thead>
							  <tbody>
            <?php
           

            $no = 1;

             if (count($result) > 0) {
                    foreach ($result as $row) {
                        echo "<tr>";
                        echo "<td class='align-middle text-center'>" . $no++ . "</td>";
                        echo "<td>" . $row['nim'] . "</td>";
                        echo "<td class='text-align:center'>" . $row['nama'] . "</td>";
                        echo "<td style='text-align:center;'>" . $row['vote'] . "</td>";
                        echo "<td style='text-align:center;'>" . $row['waktu'] . "</td>";
                        echo "</tr>";
                    }
            } else {
                echo "<tr><td colspan='5'>Tidak ada data yang ditemukan.</td></tr>";
            }
            ?>
        </tbody>
               			</table>
					</div>
				</div>
			</div>

			<div class="navigation-container">
				<button id="prevButton">Previous</button>
				<span id="pageNumber">1</span>
			<button id="nextButton">Next</button>
 	 		</div>

			</main>

        <?php include '../view/footer.php'; ?>

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

document.addEventListener("DOMContentLoaded", function() {
    var table = document.getElementById("tabel");
    var tbody = table.getElementsByTagName("tbody")[0];
    var rowCount = tbody.rows.length;

    var slideLimit = 4;
    var currentSlide = 1;
    var totalSlides = Math.ceil(rowCount / slideLimit);

    var prevButton = document.getElementById("prevButton");
    var nextButton = document.getElementById("nextButton");
    var pageNumber = document.getElementById("pageNumber");
    var navigationContainer = document.querySelector('.navigation-container');

    function updateButtonState() {
        pageNumber.textContent = currentSlide;

        if (currentSlide === totalSlides || rowCount <= slideLimit) {
            nextButton.classList.remove('button-active');
            nextButton.classList.add('button-disabled');
            nextButton.disabled = true;
        } else {
            nextButton.classList.remove('button-disabled');
            nextButton.classList.add('button-active');
            nextButton.disabled = false;
        }

        if (currentSlide === 1 || rowCount <= slideLimit) {
            prevButton.classList.remove('button-active');
            prevButton.classList.add('button-disabled');
            prevButton.disabled = true;
        } else {
            prevButton.classList.remove('button-disabled');
            prevButton.classList.add('button-active');
            prevButton.disabled = false;
        }
    }

    function showCurrentSlide() {
        var startRowIndex = (currentSlide - 1) * slideLimit;
        var endRowIndex = Math.min(startRowIndex + slideLimit, rowCount);

        for (var i = 0; i < rowCount; i++) {
            tbody.rows[i].style.display = "none";
        }

        for (var i = startRowIndex; i < endRowIndex; i++) {
            tbody.rows[i].style.display = "";
        }

        updateButtonState();
    }

    if (rowCount <= slideLimit) {
        navigationContainer.style.display = 'none';
    } else {
        navigationContainer.style.display = 'flex';
    }

    prevButton.addEventListener("click", function() {
        if (currentSlide > 1) {
            currentSlide--;
            showCurrentSlide();
        }
    });

    nextButton.addEventListener("click", function() {
        if (currentSlide < totalSlides) {
            currentSlide++;
            showCurrentSlide();
        }
    });
    
    document.getElementById("filterForm").addEventListener("submit", function(event) {
        event.preventDefault();
        var nomorUrut = document.getElementById("nomorUrut").value;
        window.location.href = "hasil_dpt.php?nomorUrut=" + nomorUrut;
    });
});

	</script>
   <script src="../assets/js/custom.js"></script>
<script src="../../assets/js/pages/dashboard.js"></script>


    </body>
</html>