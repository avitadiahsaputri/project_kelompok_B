<?php
require_once __DIR__ . '/../../model/auth.php';
wajibPemilih();
include '../../koneksi.php';
require_once '../../model/query.php';
$pengaturan = ambilPengaturan();
$title = $pengaturan['lembaga'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="<?php echo $title; ?>" itemprop="description">
  <link href="../../assets/img/brand/Logo.png" rel="shortcut icon">
  <title><?php echo $title; ?></title>
  <link href="../assets/css/font-awesome.css" rel="stylesheet">
  <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.0/css/boxicons.min.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
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

    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        background-color: #f8f9fa;
        transition: background-color 0.3s, color 0.3s;
    }

    .sidebar a, .sidebar li {
        color: inherit;
        text-decoration: none;
    }

    .sidebar a:hover, .sidebar li:hover {
        color: inherit;
        background-color: inherit;
        text-decoration: none;
    }

    .navigation-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .navigation-container button {
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 5px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        width: 200px;
    }

    .navigation-container button:hover {
        background-color: #45a049;
    }

    .navigation-container button[disabled] {
        opacity: 0.65;
    }

    .navigation-container button.btn-secondary {
        background-color: #6c757d;
        color: #fff;
    }

    .navigation-container button.btn-secondary:hover {
        background-color: #5a6268;
    }

    .table-data .order .head form input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 200px;
    }

    .table-data .order .head form input[type="submit"]:hover {
        background-color: #45a049;
    }

    .table-data .order form input[type="submit"] {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 200px;
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
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        width: 200px;
    }

    .class input[type="submit"]:hover {
        background-color: #45a049;
    }

    .orderBox {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .container {
        display: flex;
        align-items: center;
        padding: 8px;
        border-radius: 4px;
    }

    .container input[type="submit"] {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 200px;
    }

    .container input[type="submit"]:hover {
        background-color: #45a049;
    }

    @media screen and (max-width: 1000px) {
        .container {
            flex-direction: column;
            align-items: stretch;
        }
        .container select, .container input[type="submit"] {
            margin-right: 0;
            margin-bottom: 8px;
            width: 100%;
        }
    }

    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        transition: 0.3s;
    }
    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .card-body img {
        cursor: pointer;
        transition: transform 0.2s;
    }
    .card-body img:hover {
        transform: scale(1.1);
    }

    .candidate-card img {
        width: 175px;
        height: 200px;
        object-fit: cover;
        border-radius: 5px;
    }

    @media (max-width: 576px) {
        .candidate-card {
            margin-bottom: 20px;
        }
    }

    input[type="checkbox"] {
        transform: scale(1.5);
        margin-bottom: 10px;
    }

    .candidates-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .candidates-row .candidate-card {
        flex: 1 1 calc(33.333% - 20px);
        box-sizing: border-box;
    }

    .candidate-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px;
        margin: 10px;
        border: 1px solid #ddd;
        border-radius: 10px;
        transition: box-shadow 0.3s;
    }

    .candidate-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .candidates-row .candidate-card {
            flex: 1 1 calc(50% - 20px);
        }
    }

    @media (max-width: 576px) {
        .candidates-row .candidate-card {
            flex: 1 1 100%;
        }
    }

    .card-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 8px;
        text-align: center;
    }

    .card-text {
        font-size: 14px;
        text-align: center;
    }

    .vote-button {
        margin-top: 10px;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 200px;
    }

    .vote-button:disabled {
        background-color: #ddd;
        color: #999;
        cursor: not-allowed;
    }

    .vote-button:hover {
        background-color: #45a049;
    }

    .navbar {
        width: 100%;
        height: 56px;
        background-color: var(--light);
        padding: 0 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        left: 0;
        z-index: 1000;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
    }
  </style>
    <link rel="stylesheet" href="../../assets/css/components/footer.css">
</head>
<body>
  <?php include "../view/header.php"; ?>
  <section id="content">
    <nav>
      <i class='bx bx-menu'></i> <a class="nav-link" href="#"></a>
      <form action="#">
        <div class="form-input" style="display: none;">
          <input type="search"> <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
        </div>
      </form><input hidden="" id="switch-mode" type="checkbox"> <a class="notification" href="#" style="display: none;"><i class=
      'bx bxs-bell'></i></a> <a class="profile" href="#"><img src="../assets/img/logo.png"></a>
    </nav>
    <div id="page-wrapper">
      <main>

        <div class="head-title">
          <div class="left">
            <h1>Data Suara</h1>
            <ul class="breadcrumb">
              <li>
                <a class="navbar-brand" href="#">Kertas Suara Online: <b><?php echo $_SESSION['nama']; ?></b></a>
              </li>
            </ul>
          </div>
        </div>


        <div id="page-inner">
          <div class="table-data">
            <div class="order">
                    <div class="container">
                      <form method="post" action="">
                        <div class="row justify-content-center">
                          <div class="col-md-12">
                            <h2 class="text-center">Daftar Kandidat</h2>

                            <div class="candidates-row">
                              
                              <?php
                                foreach(ambilSemuaPaslon() as $d){
                               ?>
                              
                              <div class="candidate-card">
                                <input style="transform: scale(2);" type="checkbox" name="checkbox[]" onchange="check();" value="<?php echo $d['no_urut']; ?>">
                                <img style="width: 175px; height:200px;" src="<?php echo "../foto/".$d['gambar1']; ?>" onclick="toggleCheckbox(this);">
                                <p style="font-size: 11px; text-align: center;"><?php echo $d['nm_paslon']; ?></p>
                              </div>
                              
                              <?php } ?>
                               

                            </div>

                          </div>
                        </div>
                          <div class="navigation-container">
                                <center>
                                  <?php
                                  date_default_timezone_set('Asia/jakarta');
                                  $sekarang = date('Y-m-d H:i:s');
                                  $mulai = $pengaturan['mulai'];
                                  $selesai = $pengaturan['selesai'];

                             
                                  if ($sekarang >= $selesai){
                                      echo"
                                          <br><h2 style='color:red;align:center;padding: 10px; border-radius: 15px; width: 100%;'><strong>- waktu pemilihan sudah ditutup -</strong></h2>";
                                  }
                                  elseif ($sekarang >= $mulai){
                                      echo"<button type='submit' name='vote' id='vote' >VOTE</button>";
                                  }
                                  else{
                                      echo"
                                          <br><h2 style='color:red;align:center;padding: 10px; border-radius: 15px; width: 100%;'><strong>- belum saatnya pemilihan -</strong></h2>";
                                  }
                                  ?>
                                </center>
                                </div>

                      </form>
                </div>
               
                <?php
                if (isset($_POST['vote'])) {
                      date_default_timezone_set('Asia/jakarta');
                      $waktu = date('H:i:sa');
                      $nim = $_SESSION['nim'];
                      $nama = $_SESSION['nama'];
                      $kelas = $_SESSION['kelas'];
                      $tingkat = $_SESSION['tingkat'];
                      $checkbox_values = $_POST['checkbox'] ?? [];
                    if (sudahMemilih($nim)) {
                          echo "<script>alert('Anda tidak bisa melakukan voting lagi'); window.location='../index.php'</script>";
                    } elseif (empty($checkbox_values)) {
                          echo "<script>alert('Silakan pilih salah satu kandidat terlebih dahulu'); window.location='vote.php'</script>";
                    } else {
                        $result = simpanSuara($nim, $nama, $kelas, $tingkat, $checkbox_values, $waktu);
                        if ($result){
                            echo"<script>window.alert('Pilihan Anda telah disimpan.')
                                window.location='../index.php'</script>";
                            } else {
                            echo "<script>window.alert('Terjadi kesalahan dalam menyimpan data.')
                                window.location='vote.php'</script>";
	                    }
	
                  }
              }
                ?>
              </div>

            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="alert alert-danger text-center">
                <strong>Voting hanya dapat dilakukan satu kali.</strong>
              </div>
            </div>
          </div>

        </div>
      </main>
       <?php include '../view/footer.php'; ?>
    </div>
  </section>

  <script>
function toggleCheckbox(element) {
    var checkbox = element.closest('.candidate-card').querySelector('input[type="checkbox"]');
    checkbox.checked = !checkbox.checked;
    check();
}

function check() {
    var checkedBoxes = document.querySelectorAll('input[type="checkbox"]:checked');
    var voteButton = document.getElementById('vote');

    if (checkedBoxes.length === 0) {
        voteButton.disabled = true;
    } else if (checkedBoxes.length > 1) {
        alert('Hanya satu pilihan yang dapat dipilih.');
        checkedBoxes.forEach(function(box) {
            box.checked = false;
        });
        voteButton.disabled = true;
    } else {
        voteButton.disabled = false;
    }
}


        </script>
   
  <script src="../../assets/js/pages/dashboard.js">
  </script>
  <script src="../../assets/js/components/sweetalert.min.js">
  </script>
  </script>
  <script src="../assets/js/jquery-1.10.2.js">
  </script>
  <script src="../assets/js/bootstrap.min.js">
  </script>
  <script src="../assets/js/custom.js">
  </script>
</body>
</html>