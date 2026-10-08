<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';

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
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../../assets/img/brand/Logo.png">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.0/css/boxicons.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

	<link rel="stylesheet" href="../assets/css/style.css">
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
            --kunif: #4CAF50;
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


        .class {
            display: flex;
            align-items: center;
        }

        .container {
            display: flex;
            align-items: center;
        }

        .select-wrapper {
            display: flex;
            align-items: center;
        }


.container label {
            margin-right: 10px;
        }

        .container select {
            flex: 1;
            margin-right: 8px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .container input[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .modal-body .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        .modal-body .form-group label {
            width: 100%;
            text-align: left;
        }

        .modal-body .form-group input[type="text"],
        .modal-body .form-group input[type="number"],
        .modal-body .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .container select {
            flex: 1;
            margin-right: 8px;
            padding: 8px;
            border: 1px solid ; 
            border-radius: 4px;
            box-sizing: border-box;
            min-width: 150px;
        }

        @media only screen and (max-width: 768px) {
            .select-wrapper {
                display: flex;
                flex-direction: column;
                align-items: stretch;
            }

            .select-wrapper label,
            .select-wrapper select,
            .select-wrapper input[type="submit"] {
                width: 100%;
                margin-top: 10px;
            }
        
        }

        .select-wrapper {
            display: flex;
            align-items: center;
        }

        .select-wrapper select,
        .select-wrapper  {
            flex: 1;
            margin-right: 8px;
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

        
.form-group input,
        .form-group select {
            font-size: 14px;
            color: #333;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            width: 100%;
            height: auto;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #45a049;
            box-shadow: 0 0 8px rgba(60, 145, 230, 0.2);
            outline: none;
        }

        .form-group label {
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }

        select {
            background: #fff;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-position: right 10px center;
            background-repeat: no-repeat;
        }

        select option {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

  
        .table-data .orderBox .container form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .table-data .orderBox .container form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .table-data .orderBox form input[type="submit"] {
            background-color: #45a049;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .table-data .orderBox form input[type="submit"]:hover {
            background-color: #45a049;
        }


        .orderBox {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        
        .btn-primary {
                    background-color: var(--kunif);
                    border-color: yellow;
                    color: white;
                    padding: 10px 20px;
                    font-size: 16px;
                    border-radius: 4px;
                    transition: background-color 0.3s, border-color 0.3s, color 0.3s;
        }
        .btn-primary:hover {
            background-color: #45a049;
            border-color: yellow;
        }
        .btn-primary:focus, .btn-primary:active {
            background-color: var(--kunif);
            outline: none;
        }
        .btn-primary i {
            margin-right: 5px;
        }

        .btn-edit {
            background-color: #ffc107;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
            width: 80px;
            height: 40px;
        }

        .btn-edit:hover {
            background-color: #ffca2f;
        }

        .btn-delete {
            
            background-color: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 80px;
            height: 40px;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
        .modal-header {
            background-color: #4CAF50;
            color: yellow;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .modal-header .close {
            color: white;
            opacity: 1;
        }

        .modal-header .close:hover {
            color: #ddd;
        }
        .btn-icon {
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            width: 40px; 
            height: 40px; 
            background-color: #007bff;
            border: none;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
            padding: 8px;
        }


.btn-icon .fas {
            font-size: 1.5em;
            margin-right: 0;
        }

        .btn-icon {
            margin-top: 20px;
            margin-left: 10px;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-tambah {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-import {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-export {
            background-color: #ffc107;
            border-color: #ffc107;
        }
        .btn-hapus-semua {
            background-color: #dc3545;
            border-color: #ffc107;
        }
        .btn-icon i {
            margin-right: 5px;
        }
        .btn-icon:focus {
    outline: 2px solid #218838;
    box-shadow: none;
}

.btn-icon:focus,
.btn-icon:active {
    box-shadow: none;
    outline: none;
}

.btn-icon span {
    display: none;
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
.delete-btn, .edit-btn {
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    padding: 0;
    border: none;
}

.delete-btn i{
    margin-top: 13px;
}
.edit-btn i{
    margin-left: 5px;
}
.delete-btn i, .edit-btn i {
    font-size: 20px;
}

.modal-footer .btn-primary[name="simpan"],
.modal-footer .btn-primary[name="import"] {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    outline: none;
}

.modal-footer .btn-primary[name="simpan"]:hover,
.modal-footer .btn-primary[name="import"]:hover {
    background-color: #218838;
}

.modal-footer .btn-primary[name="simpan"]:focus,
.modal-footer .btn-primary[name="import"]:focus {
    outline: 2px solid #218838;
    box-shadow: none;
}

.alert-primary {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}
.modal-footer .btn-primary[name="edit"] {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    outline: none;
}

.modal-footer .btn-primary[name="edit"]:hover {
    background-color: #218838;
}

.modal-footer .btn-primary[name="edit"]:focus {
    outline: 2px solid #218838;
    box-shadow: none;
}

.modal-footer .btn-primary[name="edit"]:active {
    background-color: #1e7e34;
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
                <div class="head-title">
                    <div class="left">
                        <h1>Pemilih</h1>
                        <ul class="breadcrumb">
                            <li><a href="#">Pemilih</a></li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li><a class="active" href="#">Data Pemilih</a></li>
                        </ul>
                    </div>
                </div>
                <div id="page-inner">
                    <div class="row">
                            <div class="container">
                                <button type="button" class="btn btn-icon btn-tambah" data-toggle="modal" data-target="#tambahDataModal" title="Tambah Data">
                                    <i class="fas fa-plus fa-lg"></i> 
                                </button>
                                <a href="../actions/hapus_semua.php?confirm=true" onclick="return confirm('Anda yakin ingin menghapus semua data?')" class="btn btn-icon btn-hapus-semua" title="Hapus Semua Data">
                                    <i class="fas fa-trash fa-lg"></i> 
                                </a>
                                <button type="button" class="btn btn-icon btn-import" data-toggle="modal" data-target="#importDataModal" title="Import Data">
                                    <i class="fas fa-file-import fa-lg" style="margin-right: 5px;"></i>
                                </button>
                                <a href="export.php" class="btn btn-icon btn-export" title="Export Data">
                                    <i class="fas fa-file-export fa-lg" style="margin-left: 5px;"></i> 
                                </a>
                                <a href="../templates/template-dpt.xlsx"style="margin-left: 10px; margin-top: 20px"  download class="btn btn-success">
                                    <i class="fas fa-download fa-lg"></i>
                                     <span class="d-none d-md-inline"> Download Template</span>
                                </a>
                                <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pemilih</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="../actions/add-pemilih.php" method="post" enctype="multipart/form-data" name="addForm" onsubmit="return validateForm()">
                                            <div class="modal-body">
                                                <div class="form-group ">
                                                    <label>NIS:</label>
                                                    <input  style="color: #000;" required type="number" name="nis" class="form-control">
                                                </div>
                                                <div class="form-group ">
                                                    <label >Nama:</label>
                                                    <input  style="color: #000;"required onkeypress="filterNumbers(event)" type="text" name="nama" class="form-control">
                                                </div> 
                                                <div class="form-group">
                                                    <label for="tanggal_lahir">Tanggal Lahir:</label>
                                                    <input style="color: #000;" type="date" name="tanggal_lahir" required class="form-control">
                                                </div>

                                                <div class="form-group">
                                                    <label for="jenis_kelamin">Jenis Kelamin:</label>
                                                    <select required id="jenis_kelamin" name="jenis_kelamin"  class="form-control">
                                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                                        <option value="Laki-laki">Laki-laki</option>
                                                        <option value="Perempuan">Perempuan</option>
                                                    </select>                                
                                                </div>
            
                                                <div class="form-group ">
                                                    <label for="tingkat">Tingkat:</label>
                                                    <select required id="tingkat" name="tingkat" onchange="tampilkanKelas()" class="form-control">
                                                        <option value="" style="display:none;">Pilih Tingkat</option>
                                                        <option value="MA">MA</option>
                                                        <option value="MTS">MTs</option>
                                                    </select>                                
                                                </div>
                                                <div class="form-group ">
                                                    <label for="kelas">Kelas:</label>
                                                    <select required id="daftarKelas" name="daftarKelas" style="display:none;" class="form-control "></select>
                                                </div>                      
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" name="simpan" onclick="return validateForm() && confirm('Apakah Anda yakin ingin menambahkan data?');" class="btn btn-primary">Tambah</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        </div>

                <div class="modal fade" id="importDataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import Data Pemilih dari Excel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="../actions/import-pemilih.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group ">
                                    <label>Pilih file Excel:</label>
                                    <input required type="file" name="excel_file" class="form-control-file">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="import" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

                        <div class="table-data">
                            <div class="orderBox">
                            <h2>Data Pemilih</h2>
                            <div class="class">
                                <div class="container">
                                    <form action="upload_dpt.php" method="GET">
                                        <div class="select-wrapper">
                                            <label for="tingkat">Tingkat</label>
                                            <select id="tingkat" name="tingkat" onchange="tampilkanPemilih()">
                                                <option value="Semua">Semua</option>
                                                <option value="MA">MA</option>
                                                <option value="MTS">MTs</option>
                                            </select>
                                            <input type="submit" value="Pilih">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="table-data">
                    <div class="order">

                                <div class="table-responsive">
                                    <?php 
                                    if (isset($_GET['cari'])) {
                                        $cari = $_GET['cari'];
                                        echo "<b>Hasil pencarian: " . $cari . "</b>";
                                    } elseif (isset($_GET['tingkat'])) {
                                        $tingkat = $_GET['tingkat'];
                                    }
                                    ?>
                                    <table id="data-kelas" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="align-middle text-center">No</th>
                                                <th class="align-middle text-center">NIS</th>
                                                <th class="align-middle text-center">Nama</th>
                                                <th class="align-middle text-center">tanggal lahir</th>
                                                <th class="align-middle text-center">Jenis Kelamin</th>
                                                <th class="align-middle text-center">Kelas</th>
                                                <th class="align-middle text-center">Tingkat</th>
                                                <th class="align-middle text-center">Tools</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $no = 1;
                                            if (isset($_GET['cari'])) {
                                                $cari = $_GET['cari'];
                                                $data = cariDaftarPemilih($cari);
                                            } elseif (isset($_GET['tingkat']) && $_GET['tingkat'] !== "Semua") {
    										    $tingkat = $_GET['tingkat'];
                                                $data = cariDaftarPemilih(null, $tingkat);
                                            } else {
                                                $data = cariDaftarPemilih();
                                            }
                                            foreach ($data as $d) {
                                            ?>
                                            <tr>
                                                <td class="align-middle text-center"><?php echo $no++; ?></td>
                                                <td class="align-middle text-center"><?php echo $d['nim']; ?></td>
                                                <!-- <td class="align-middle text-center"><?php echo $d['kode_akses']; ?></td> -->
                                                <td class="align-middle text-center"><?php echo $d['nama']; ?></td>
                                                <td class="align-middle text-center"><?php echo date('d-m-Y', strtotime($d['tgl_lahir'])); ?></td>
                                                <td class="align-middle text-center"><?php echo $d['jenis_kelamin']; ?></td>
                                                <td class="align-middle text-center"><?php echo $d['kelas']; ?></td>
                                                <td class="align-middle text-center"><?php echo $d['tingkat']; ?></td>
                                                <td class="align-middle text-center">
                                                    <button class="btn btn-warning edit-btn" data-toggle="modal" data-target="#editDataModal<?php echo $d['id']; ?>"> <i class="fas fa-edit fa-lg" style='color:#f3f3f3'  ></i></button>
                                                    <div class="modal fade" id="editDataModal<?php echo $d['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Pemilih</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form action="../actions/proses_edit_pemilih.php" method="post" enctype="multipart/form-data">

                                                                    <div class="modal-body">
                                                                        <div class="form-group ">
                                                                            <label>NIS:</label>
                                                                            <input  style="color: #000;" required="required" type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                                                            <input   style="color: #000;" required="required" type="text" name="nim" value="<?php echo $d['nim']; ?>" class="form-control">
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <label>Nama:</label>
                                                                            <input  style="color: #000;" required="required" type="text" name="nama" value="<?php echo $d['nama']; ?>" class="form-control">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="tanggal_lahir">Tanggal Lahir:</label>
                                                                            <input style="color: #000;" type="date" name="tanggal_lahir" value="<?php echo $d['tgl_lahir']; ?>" required class="form-control">
                                                                        </div>

                                                                       <div class="form-group">
                                                                            <label for="jenis_kelamin">Jenis Kelamin:</label>
                                                                            <select style="color: #000;" required="required" name="jenis_kelamin" class="form-control">
                                                                                <option value="Laki-laki" <?php if ($d['jenis_kelamin'] == 'Laki-laki') echo 'selected="selected"'; ?>>Laki-laki</option>
                                                                                <option value="Perempuan" <?php if ($d['jenis_kelamin'] == 'Perempuan') echo 'selected="selected"'; ?>>Perempuan</option>
                                                                            </select>
                                                                        </div>

                                                                         <div class="form-group ">
                                                                            <label for="tingkat">Tingkat:</label>
                                                                           <select  style="color: #000;" required="required" id="tingkat<?php echo $d['id']; ?>" name="tingkat" onchange="Kelas(<?php echo $d['id']; ?>)" class="form-control">
                                                                                <option value="<?php echo $d['tingkat']; ?>"><?php echo $d['tingkat']; ?></option>
                                                                                <option value="MA">MA</option>
                                                                                <option value="MTS">MTs</option>
                                                                            </select>                                
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <label for="editKelas">Kelas:</label>
                                                                            <select  style="color: #000;" id="editKelas<?php echo $d['id']; ?>" name="kelas" class="form-control">
                                                                                <option value="<?php echo $d['kelas']; ?>"><?php echo $d['kelas']; ?></option>
                                                                            </select>
                                                                        </div>
                                                                                    
                                                                    </div>
                                                                  <div class="modal-footer">
                                                                    <button type="submit" name="edit" onclick="return validateeditForm() && confirm('Apakah Anda yakin ingin menyimpan perubahan?');" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
                                                                  </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a class="btn btn-danger delete-btn" href="../actions/hapus_pemilih.php?id=<?php echo $d['id']; ?>" onclick="return confirm('Anda yakin mau menghapus item ini ?')"><i class="fas fa-trash fa-lg"></i> </a>
                                                </td>
                                            </tr>
                                            <?php } ?>
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
        function filterNumbers(event) {
            var keyCode = event.keyCode || event.which;
            var keyValue = String.fromCharCode(keyCode);
            var regex = /[0-9]/;

            if (regex.test(keyValue)) {
                event.preventDefault();
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="../../assets/js/pages/dashboard.js"></script> 
    <script src="../js/upload_dpt.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
</body>
</html>
