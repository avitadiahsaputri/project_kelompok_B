<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';

function clean_input($data) {
    return htmlspecialchars(trim($data));
}

$error_message = '';
$warningMessage = '';
$nomor_urut_input = '';
$nm_paslon_input = '';
$visi_input = '';
$misi_input = '';
$gambar_lama = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = ambilPaslon($id);

    if ($data) {
        $nomor_urut_input = $data['no_urut'];
        $nm_paslon_input = $data['nm_paslon'];
        $visi_input = $data['visi'];
        $misi_input = $data['misi'];
        $gambar_lama = $data['gambar1'];
    } else {
        $error_message = 'Data tidak ditemukan.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor_urut = clean_input($_POST['no_urut']);
    $nm_paslon = clean_input($_POST['nm_paslon']);
    $visi = clean_input($_POST['visi']);
    $misi = clean_input($_POST['misi']);

    if (strlen($nomor_urut) < 1 || strlen($nomor_urut) > 4 || !is_numeric($nomor_urut)) {
        $error_message = 'Nomor urut harus berupa angka dengan panjang minimal 1 dan maksimal 4 digit.';
    } else {
        if (!isset($_GET['id'])) {
            if (nomorUrutSudahAda($nomor_urut)) {
                $warningMessage = 'Nomor urut sudah ada di database. Silakan masukkan nomor urut yang berbeda.';
            }
        }

        if (!namaPemilihAda($nm_paslon)) {
            $warningMessage = 'Nama kandidat tidak terdaftar di database. Silakan pilih dari daftar yang tersedia.';
        }

        if ($_FILES['gambar1']['error'] === 0) {
            $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
            $gambar1 = $_FILES['gambar1']['name'];
            $x = explode('.', $gambar1);
            $ekstensi = strtolower(end($x));
            $ukuran = $_FILES['gambar1']['size'];
            $file_tmp = $_FILES['gambar1']['tmp_name'];

            if (in_array($ekstensi, $ekstensi_diperbolehkan)) {
                if ($ukuran <= 2000000) {
                    $upload_path = '../foto/' . $gambar1;
                    if (move_uploaded_file($file_tmp, $upload_path)) {
                        if (!empty($gambar_lama)) {
                            unlink('../foto/' . $gambar_lama);
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
        } else {
            $gambar1 = $gambar_lama;
        }

        if (empty($error_message) && empty($warningMessage)) {
            if (isset($_GET['id'])) {
                $result_update = ubahPaslon($id, $nomor_urut, $nm_paslon, $gambar1, $visi, $misi);
                if ($result_update !== false) {
                    echo "<script>alert('Data berhasil di Update'); window.location.href='input_data_paslon.php';</script>";
                } else {
                    $error_message = 'Gagal mengupdate data ke database.';
                }
            } else {
                $result_insert = tambahPaslon($nomor_urut, $nm_paslon, $gambar1, $visi, $misi);
                if ($result_insert !== false) {
                    echo "<script>alert('Data berhasil di Tambahkan'); window.location.href='input_data_paslon.php';</script>";
                } else {
                    $error_message = 'Gagal menyimpan data ke database.';
                }
            }
        }
    }
}

    $gusmint = ambilPengaturan();
    $title = $gusmint['lembaga'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
        <link rel="shortcut icon" href="../../assets/img/brand/Logo.png">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.0/css/boxicons.min.css">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="../assets/css/style.css">

    <style>


        .nav-link {
            color: var(--dark);
            text-decoration: none;
            font-size: 16px;
            transition: 0.3s ease;
            text-align: center;
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


        @media (max-width: 768px) {

            .nav-link {
                font-size: 14px;
            }
        }

       .readonly-input {
        font-size: 20px;
        color: #6c757d;
        border: none;
        background-color: transparent;
        outline: none;
        width: 100%;
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
                <a href="#" class="notification d-none mr-3"><i class='bx bxs-bell'></i></a>
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
            </div>            </div>
        </nav>
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
            <a href="input_data_paslon.php" class="btn btn-secondary" style="margin-top: 20px;">Kembali</a>

                <div class="table-data">
                    <div class="order">

                        <div class="head">
                            
                            <h2 style="margin-bottom: 20px;">Edit Kandidat</h2>  
                <?php if (!empty($error_message)) : ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <?php if (!empty($warningMessage)) : ?>
                    <div class="alert alert-warning"><?php echo $warningMessage; ?></div>
                <?php endif; ?> 
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group" >
                                        <label for="no_urut">Nomor Urut</label>
                                        <input type="text" name="no_urut" value="<?php echo $data['no_urut']; ?>" readonly class="form-control">        
                                    </div>
                                    <div class="form-group">
                                        <label for="nm_paslon">Nama Kandidat</label>
                                        <input  style="color: #000;" type="text" name="nm_paslon" value="<?php echo $data['nm_paslon']; ?>" required autocomplete="off" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="visi">Visi</label>
                                        <input  style="color: #000;" type="text" onkeypress="filterNumbers(event)" name="visi" value="<?php echo $data['visi']; ?>" required autocomplete="off" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="misi">Misi</label>
                                        <input  style="color: #000;" type="text" onkeypress="filterNumbers(event)" name="misi" value="<?php echo $data['misi']; ?>" required autocomplete="off" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="gambar1">Foto Kandidat</label>
                                        <input  style="color: #000;" type="file" name="gambar1" class="form-control-file">
                                        <br>
                                        <img src="../foto/<?php echo $data['gambar1']; ?>" style="max-width: 100px; height: auto;">
                                    </div>
                                    <div class="form-group" style="margin-top: 20px;">
                                        <input type="submit" class="btn btn-success" name="update" value="Update" class="form-control">
                                    </div>
                                </form>

                        </div>
                    </div>
                </div>
                <div class="table-data">
                    <div class="order">
                        <div class="class">
                            <h2>Data Kandidat</h2> 
                        </div> 
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
                                            <a class="btn btn-warning" href="edit.php?id=<?php echo $d['id']; ?>"><i class='bx bx-edit' style='color:#f3f3f3'></i></a>
                                            <a class="btn btn-danger" onclick="return confirm('Yakin hapus data ini !!!')" href="../actions/hapus.php?id=<?php echo $d['id']; ?>"><i class='bx bx-message-square-x'></i></a>
                                        </td>                        
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
   function hanyaAngka(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            evt.preventDefault();
        }
    }
function formatNomorUrut(input) {
    var value = input.value.replace(/\D/g, '');
    if (value.length >= 2 && value.length <= 4) {
        input.value = value;
        document.getElementById('error-message').textContent = '';
    } else if (value.length > 4) {
        input.value = value.slice(0, 4);
        document.getElementById('error-message').textContent = '';
    } else {
        if (value.length === 0) {
            document.getElementById('error-message').textContent = 'Nomor urut tidak boleh kosong.';
        } else {
            document.getElementById('error-message').textContent = 'Nomor urut harus memiliki panjang minimal 2 digit.';
        }
        input.value = ('0' + value).slice(-2);
    }
}


document.addEventListener("DOMContentLoaded", function() {
    var table = document.getElementById("tabel");
    var tbody = table.getElementsByTagName("tbody")[0];

    var rowCount = tbody.rows.length;

    var slideLimit = 4;
    var currentSlide = 1;
    var totalSlides = Math.ceil(rowCount / slideLimit);

    function showCurrentSlide() {
        var startRowIndex = (currentSlide - 1) * slideLimit;
        var endRowIndex = Math.min(startRowIndex + slideLimit, rowCount);

        for (var i = 0; i < rowCount; i++) {
            tbody.rows[i].style.display = "none";
        }

        for (var i = startRowIndex; i < endRowIndex; i++) {
            tbody.rows[i].style.display = "";
        }

        if (pageNumber) {
            pageNumber.textContent = currentSlide;
        }

        if (nextButton) {
            nextButton.disabled = (currentSlide === totalSlides);
        }

        if (prevButton) {
            prevButton.disabled = (currentSlide === 1);
        }
    }

    var prevButton = document.getElementById("prevButton");
    var pageNumber = document.getElementById("pageNumber");
    var nextButton = document.getElementById("nextButton");

    showCurrentSlide();

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
});


</script>
<script src="../assets/js/jquery-1.10.2.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="../../assets/js/pages/dashboard.js"></script>

</body>
</html>
