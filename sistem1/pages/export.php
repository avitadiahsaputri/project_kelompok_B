<?php
require_once __DIR__ . '/../../model/auth.php';
wajibAdmin();
include '../../koneksi.php';
require_once '../../model/query.php';
$gusmint = ambilPengaturan();
$title = $gusmint['lembaga'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../../assets/img/brand/Logo.png">
    <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.0/css/boxicons.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
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
        .btn-icon i {
            margin-right: 8px;
        }

        @media (max-width: 968px) {
    .table-responsive form {
        display: none;
    }
}

@media (max-width: 768px) {
    .navbar form {
        display: none;
    }
    .navbar .bx-menu {
        display: block;
    }
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
            <a href="#" class="profile">
                <img src="../assets/img/logo.png" class="img-fluid" alt="Profile Image">
            </a>
        </div>
    </nav>
    <div id="page-wrapper">
        <main>
            <div class="head-title">
                    <div class="left">
                        <h1>Export Data</h1>
                        <ul class="breadcrumb">
                            <li><a href="#">Pemilih</a></li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li><a class="active" href="#">Export Data</a></li>
                        </ul>
                    </div>
                </div>
              <div class="table-data">
                    <div class="order">
<div class="container">
    <div class="data-tables datatable-dark" id="mauexport" width="100%" cellspacing="0">
        <div class="table-responsive">
            <table id="data-kelas" class="table table-striped table-bordered table-hover " style="overflow-x: auto;">
                <thead>
                    
                    <tr>
                        <th class="align-middle text-center">No</th>
                        <th class="align-middle text-center">Nim</th>
                        <th class="align-middle text-center">Nama</th>
                        <th class="align-middle text-center">tanggal lahir</th>
                        <th class="align-middle text-center">Jenis kelamin</th>
                        <th class="align-middle text-center">Kelas</th>
                        <th class="align-middle text-center">Tingkat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (isset($_GET['cari'])) {
                        $cari = $_GET['cari'];
                        $data = cariDaftarPemilih($cari);
                    } elseif (isset($_GET['tingkat'])) {
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
                        <td class="align-middle text-center"><?php echo $d['nama']; ?></td> 
                        <td class="align-middle text-center"><?php echo $d['tgl_lahir']; ?></td> 
                        <td class="align-middle text-center"><?php echo $d['jenis_kelamin']; ?></td>
                        <td class="align-middle text-center"><?php echo $d['kelas']; ?></td>
                        <td class="align-middle text-center"><?php echo $d['tingkat']; ?></td>
                       
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
   </div>
   </div>
    </main>
     <?php include '../view/footer.php'; ?>
     </div>
</section>
<script src="../../assets/js/pages/dashboard.js"></script> 
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#data-kelas').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>

</body>
</html>
