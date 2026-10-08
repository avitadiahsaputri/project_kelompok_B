<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';

$gusmint = ambilPengaturan();
$title = $gusmint['lembaga'];

$error_message = '';
$nomor_urut = '';
$nm_paslon = '';
$visi = '';
$misi = '';
$warningMessage = '';

function clean_input($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor_urut = clean_input($_POST['no_urut']);
    $nm_paslon = clean_input($_POST['nm_paslon']);
    $visi = clean_input($_POST['visi']);
    $misi = clean_input($_POST['misi']);
    
    if (strlen($nomor_urut) < 1 || strlen($nomor_urut) > 4 || !is_numeric($nomor_urut)) {
        $error_message = 'Nomor urut harus berupa angka dengan panjang minimal 2 dan maksimal 4 digit.';
    } else {
        if (nomorUrutSudahAda($nomor_urut)) {
            $warningMessage = 'Nomor urut sudah ada di database. Silakan masukkan nomor urut yang berbeda.';    
        } else {
            $nama_terdaftar = namaPemilihAda($nm_paslon);

            $nm_paslon = $_POST['nm_paslon'];
            $visi = $_POST['visi'];
            $misi = $_POST['misi'];

            if (!$nama_terdaftar) {
                $warningMessage = 'Nama kandidat tidak terdaftar di database. Silakan pilih dari daftar yang tersedia.';
            } else {
                if (namaPaslonSudahAda($nm_paslon)) {
                    $warningMessage = 'Nama kandidat sudah dicalonkan.';
                } else {
                    $ekstensi_diperbolehkan = array('png', 'jpg', 'JPG', 'PNG', 'jpeg', 'JPEG');
                    $gambar1 = $_FILES['gambar1']['name'];
                    $x = explode('.', $gambar1);
                    $ekstensi = strtolower(end($x));
                    $ukuran = $_FILES['gambar1']['size'];
                    $file_tmp = $_FILES['gambar1']['tmp_name'];
                    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
                        if ($ukuran <= 2000000) {
                            if (copy($file_tmp, '../foto/' . $gambar1)) {        
                                $query = tambahPaslon($nomor_urut, $nm_paslon, $gambar1, $visi, $misi) !== false;
                                if ($query) {
                                echo "<script>alert('Data berhasil di Tambahkan'); window.location.href='input_data_paslon.php';</script>";
                                } else {
                                    $error_message = 'Gagal menyimpan data ke database.';
                                }
                            } else {
                                $error_message = 'Gagal mengupload gambar.';
                            }
                        } else {
                            $error_message = 'Ukuran file terlalu besar.';
                        }
                    } else {
                        $error_message = 'Ekstensi file tidak diperbolehkan.';
                    }
                }
            }
        }
    }
}
$nama_siswa = ambilNamaPemilih();

$nomor_urut_input = htmlspecialchars($nomor_urut);
$nm_paslon_input = htmlspecialchars($nm_paslon);
$visi_input = htmlspecialchars($visi);
$misi_input = htmlspecialchars($misi);

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
if (isset($_SESSION['warningMessage'])) {
    $warningMessage = $_SESSION['warningMessage'];
    unset($_SESSION['warningMessage']);
}

$nama_siswa = ambilNamaPemilih();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title><?php echo $title; ?></title>
    <link rel="shortcut icon" href="../../assets/img/brand/Logo.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.0/css/boxicons.min.css">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../css/data_paslon.css">
    <style>
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


        .class input[type="submit"] {
        padding: 8px 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        width: 100px;
        }

        .class input[type="submit"]:hover {
        background-color: #45a049;
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
            display: flex;
            align-items: center;
            padding: 8px;
            border-radius: 4px;
        }

        .container select {
            flex: 1;
            margin-right: 8px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 250px;
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

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-success {
            width: 100%;
            padding: 8px 16px;
            border-radius: 4px;
        }

        .form-group.submit-button {
            margin-top: 20px;
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

        .btn-group {
            display: flex;
            align-items: center;
            justify-content: center;
            
        }

        .edit-btn,
        .delete-btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            padding: 0;
            text-align: center;
            margin-left: 5px;
            border-radius: 4px;
        }

        .edit-btn {
            margin-right: 5px;
        }

        .edit-btn i,
        .delete-btn i {
            font-size: 20px;
            color: #f3f3f3;
        }
    </style>
    <link rel="stylesheet" href="../../assets/css/components/footer.css">
</head>
      
     
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
                        <h1>Kandidat</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Kandidat</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="#">Data Kandidat</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div id="page-inner">
                    <div class="table-data">
                        <div class="order">
                            <div class="head">
                                <h2 style="margin-bottom: 20px;">Input Kandidat</h2>  
                                <?php if (!empty($error_message)) : ?>
                                <div class="alert alert-danger"><?php echo $error_message; ?></div>
                                <?php endif; ?>
                                <?php if (!empty($warningMessage)) : ?>
                                    <div class="alert alert-warning"><?php echo $warningMessage; ?></div>
                                <?php endif; ?>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                    <label for="no_urut">Nomor Urut</label>
                                        <input type="text" name="no_urut" id="no_urut" required="required" autocomplete="off" class="form-control" maxlength="4" >
                                        <small style="color: gray;">Min 2, Max 4 digit</small>           
                                    </div>
                                    <div class="form-group">
                                        <label for="nm_paslon">Nama Kandidat</label>
                                        <input style="color: #000;" type="text" name="nm_paslon" id="nm_paslon" required="required" autocomplete="off" class="form-control" list="siswaDropdown" value="<?php echo $nm_paslon_input; ?>" >
                                        <datalist id="siswaDropdown">
                                            <?php foreach ($nama_siswa as $siswa) { ?>
                                                <option value="<?php echo $siswa; ?>">
                                            <?php } ?>
                                        </datalist>
                                         <span id="warningMessage" style="color: red; display: none;">Nama tidak valid. Silakan pilih dari daftar.</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="visi">Visi</label>
                                        <input  style="color: #000;" type="text" name="visi" required="required" autocomplete="off" class="form-control" onkeypress="filterNumbers(event)" value="<?php echo $visi_input; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="misi">Misi</label>
                                        <input  style="color: #000;" type="text" name="misi" required="required" autocomplete="off" class="form-control" onkeypress="filterNumbers(event)" value="<?php echo $misi_input; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="gambar1">Foto Kandidat</label>
                                        <input  style="color: #000;" type="file" name="gambar1" required="required" class="form-control-file">
                                    </div>
                                    <div class="form-group" style="margin-top: 20px;">
                                        <input   type="submit" class="btn btn-success" name="Tambah" value="Tambah" class="form-control">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-data">
                    <div class="order">
                        <div class="class">
                            <h2>Data Kandidat</h2> 
                        </div> 
                        <a  style="margin-bottom: 20px;" class="btn btn-danger" href="../actions/hapus_semua_paslon.php?confirm=true" onclick="return confirm('Anda yakin ingin menghapus semua data?')">Reset Kandidat</a>
                        <div class="table-responsive">
                            <table id='tabel' class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No Urut</th>
                                        <th>Nama Kandidat</th>
                                        <th>Foto</th>
                                        <th>Visi</th>
                                        <th>Misi</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    foreach (ambilSemuaPaslon() as $d) {
                                    ?>
                                    <tr>
                                        <td style="text-align:center;"><?php echo $d['no_urut']; ?></td>
                                        <td><?php echo $d['nm_paslon']; ?></td>
                                        <td style="text-align:center;"><img style="max-width: 50px; height:auto;" src="<?php echo "../foto/" . $d['gambar1']; ?>"></td>
                                        <td style="text-align:center;"><?php echo $d['visi']; ?></td>
                                        <td style="text-align:center;"><?php echo $d['misi']; ?></td>
                                        <td style="text-align:center;">
                                        <div class="btn-group">
                                            <a class="btn btn-warning edit-btn" href="edit.php?id=<?php echo $d['id']; ?>">
                                                <i class="fas fa-edit fa-lg" style='color:#f3f3f3'></i>
                                            </a>
                                            <a class="btn btn-danger delete-btn" onclick="return confirm('Yakin hapus data ini !!!')" href="../actions/hapus.php?id=<?php echo $d['id']; ?>">
                                                <i class="fas fa-trash fa-lg"></i>
                                            </a>
                                        </div>                                       </td>                        
                                    </tr>
                                    <?php } ?>
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

function hanyaAngka(event) {
    var charCode = (event.which) ? event.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        event.preventDefault();
}

function formatNomorUrut(input) {
    var value = input.value;
    input.value = value.replace(/[^0-9]/g, '');
}

document.addEventListener('DOMContentLoaded', function() {
    var nomorUrut = "<?php echo htmlspecialchars($nomor_urut); ?>";
    document.getElementById('no_urut').value = nomorUrut;
});


function addDropdownOption(optionText) {
    var option = document.createElement('option');
    option.value = optionText;
    document.getElementById('siswaDropdown').appendChild(option);
}

var inputNama = document.getElementById('nm_paslon');
var listSiswa = <?php echo json_encode($nama_siswa); ?>;

inputNama.addEventListener('input', function() {
    var inputValue = inputNama.value.toLowerCase();
    var filteredSiswa = listSiswa.filter(function(siswa){
        return siswa.toLowerCase().includes(inputValue);
    });
    clearDropdownOptions();
    filteredSiswa.forEach(function(siswa) {
    addDropdownOption(siswa);
    });
});

function clearDropdownOptions() {
    var dropdown = document.getElementById('siswaDropdown');
    dropdown.innerHTML = '';
}

</script>
<script src="../assets/js/jquery-1.10.2.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../assets/js/custom.js"></script>
<script src="../../assets/js/pages/dashboard.js"></script>
<script src="../js/data_paslon.js"></script>