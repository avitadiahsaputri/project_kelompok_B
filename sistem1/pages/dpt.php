<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';
$gusmint = ambilPengaturan();
$title = $gusmint['lembaga'];


$limit = 100;
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$limit_start = ($page - 1) * $limit;
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

  <style>
    
         :root {
            --poppins: "Poppins", sans-serif;
            --lato: "Lato", sans-serif;
            --light: #f9f9f9;
            --blue: #3c91e6;
            --light-blue: #cfe8ff;
            --grey: #eee;
            --dark-grey: #aaaaaa;
            --dark: #342e37;
            --red: #db504a;
            --yellow: #ffce26;
            --light-yellow: #fff2c6;
            --orange: #fd7238;
            --light-orange: #ffe0d3;
        }


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
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        @media screen and (max-width: 600px) {
            th, td {
                font-size: 12px;
            }
        }


        .navigation-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 16px;
            gap: 16px;
        }

        .navigation-container button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            width: 100px;
        }

        .navigation-container button:hover { 
           background-color: #45a049;
        }


        .navigation-container button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .navigation-container span {
            width: 100px;
            text-align: center;
        }


.order .class {
  display: flex;
  align-items: center;
  justify-content: space-between; 
}

.class {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
  padding: 16px;
  border-radius: 4px;
}


.table-data .order .container form input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.table-data .order .container form input[type="submit"]:hover {
    background-color: #45a049;
}

.table-data .order form input[type="submit"] {
    background-color: #dc3545;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.table-data .order form input[type="submit"]:hover {
    background-color: #c82333;
}
.container {
    align-items: center;
    padding: 8px;
    border-radius: 4px;
    width: 100%;
}

.container select {
    margin-right: 8px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 100%;
}

.container input[type="submit"] {
    padding: 8px 16px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.container input[type="submit"]:hover {
    background-color: #45a049;
}

@media screen and (max-width: 1000px) {
    .container {
        flex-direction: column;
        align-items: stretch;
    }

    .container select,
    .container input[type="submit"] {
        margin-right: 0;
        margin-bottom: 8px;
        width: 100%;
    }
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}


.btn-success {
    display: inline-block;
    font-size: 0.875em;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    color: white;
    background: #28a745;
}

.btn-success:hover {
    background: #218838;
}

.btn-danger {
    display: inline-block;
    font-size: 0.875em;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
    color: white;
    background: #dc3545;
}

.btn-danger:hover {
    background: #c82333;
}


.form-group.submit-button {
    margin-top: 20px;
}

.btn-success,
.btn-danger {
    margin-right: 10px;
}


.sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #f8f9fa;
    transition: background-color 0.3s, color 0.3s;
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


.class {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 24px;
  padding: 16px;
  border-radius: 4px;
}


#filterForm {
    margin-buttom: 5px;
    height: 3px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.form-group {
    margin-right: 10px;
   
}


.filter-wrapper{
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.filter-wrapper select {
    margin-right: 10px;
    margin-bottom: 5px;
    width: 100%;    
}

.filter-wrapper input[type="submit"] {
    margin-right: 10px;
    margin-bottom: 5px;
    width: 100%;
}
@media screen and (max-width: 568px) {
    .filter-form {
        display: flex;
    }

    .filter-wrapper {
        width: 100px;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
    }

      .filter-wrapper select {
        width: 100px;
        margin-bottom: 2px;
    }

    .btn .btn-success {
        margin-top: 10px;
        margin-bottom: 10px;
        width: 100px;
    }
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

                                $limit = 100;
                                $page = (isset($_GET['page']))? $_GET['page'] : 1;
                        
                                $limit = 100;
                        
                                $limit_start = ($page - 1) * $limit;
                        
                                if (isset($_GET['nomorUrut']) && $_GET['nomorUrut'] !== "Semua") {
                                        $data_dpt = ambilSemuaSuara();
                                    } else {
                                        $data_dpt = ambilSuaraHalaman($limit_start, $limit);
                                    }                               
                                    $no = $limit_start + 1;
                                if (count($data_dpt) > 0) {
                                foreach ($data_dpt as $d) {
                                    ?>
								<tr>
									<td class="align-middle text-center"><?php echo $no; ?></td>
									<td><?php echo $d['nim']; ?></td>
									<td class="text-align:center"><?php echo $d['nama']; ?></td>
									<td style="text-align:center;"><?php echo $d['vote']; ?></td>
									<td style="text-align:center;"><?php echo $d['waktu']; ?></td>
									<!--<td style="text-align:center;"><a class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin akan mengHAPUS suara ini ?!')" href="../actions/reset_suara.php?id=<?php echo $d['id']; ?>"><i class="fa fa-recycle">  </i></a></td>-->
                    			</tr>
                                    <?php
                                    $no++;
                                    }
                                    } else {
                                    ?>
                                    <tr>
                                        <td colspan="5" style="text-align:center;">Tidak ada data</td>
                                    </tr>
                                    <?php
                                }
                                ?>
							</tbody>
               			</table>
					</div>

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

