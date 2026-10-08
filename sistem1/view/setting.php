<?php
$gusmint = ambilPengaturan();
$title = $gusmint['lembaga'];

if (isset($_POST['simpan'])) {
    simpanPengaturan($_POST['lembaga'], $_POST['email'], $_POST['mulai'], $_POST['selesai']);

    echo "<script>window.alert('Berhasil')
    window.location='index.php?page=pengaturan'</script>";
}

if (isset($_POST['update'])) {
    ubahKodeAksesAdmin(1, $_POST['text1']);

    echo "<script>window.alert('Berhasil')
    window.location='index.php?page=pengaturan'</script>";
}

if (isset($_POST['reset_tanggal'])) {
    if (resetJadwalPemilihan() !== false) {
        echo "<script>alert('Tanggal berhasil direset!');</script>";
        echo "<script>window.location='index.php?page=pengaturan';</script>";
    } else {
        echo "<script>alert('Gagal mereset tanggal.');</script>";
    }
}

function tanggal_indo($tanggal, $cetak_hari = false)
{
    $hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');

    $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $split = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];

    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>setting</title>
    <link href="assets/css/font-awesome.css" rel="stylesheet" />

 <style>
    .container {
        max-width: 1000px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    
    .table-data {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-top: 20px;
    }

    .column {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .column.small {
        max-width: 100%;
    }

   .column h2 {
    margin-top: 0;
    font-size: 24px;
    color: #333;
    font-family: Arial, sans-serif;
}

    .form-group {
        margin-bottom: 10px;
    }

   .form-group label {
    display: block;
    margin-bottom: 5px;
   color: #666;
       font-family: Arial, sans-serif;
        font-size: 16px;
}

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="datetime-local"],
    .form-group input[type="password"],
    .form-group input[type="submit"],
    .form-group select {
        width: 100%;
padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
          font-family: Arial, sans-serif; 
          font-size: 16px;
    }

    .form-group input[type="submit"] {
        padding: 12px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
         font-family: Arial, sans-serif;
          font-size: 16px; 
    }

    .form-group input[type="submit"]:hover {
        background-color: #45a049;
         font-family: Arial, sans-serif;
    }

    .table-responsive {
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
    }

    @media screen and (min-width: 1000px) {
        .table-data {
            flex-direction: row;
        }

        .column.small {
            flex: 0.5;
            max-width: calc(50% - 30px);
        }

        .column.large {
            flex: 0.5;
            max-width: calc(50% - 20px);
        }
    }

    .table-responsive table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.table-responsive th,
.table-responsive td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}

.table-responsive th {
    background-color: #45a049;
}

.form-group input[type="submit"].password-update {
    background-color: #ccc;
}

.form-group input[type="submit"].password-update.active {
    background-color: #4CAF50;
    font-size: 16px; 
     font-family: Arial, sans-serif;
}

.form-group input[type="submit"].password-update.active:hover {
    background-color: #45a049;
     font-family: Arial, sans-serif;
}

#passwordMismatch {
    color: red;
    display: none;
    margin-top: 5px;
     font-family: Arial, sans-serif;
     font-size: 14px;
}
.btn-reset {
        padding: 10px 20px;
        background-color: #ff6347;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: background-color 0.3s ease;
        margin-bottom: 10px;
    }

    .btn-reset:hover {
        background-color: #ff483b;
    }
    
</style>

</head>
<body>
<main>
    
  <div class="head-title">
            <div class="left">
            <h1>Setting</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Setting</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Pengaturan</a>
                </li>
            </ul>
        </div>  
      </div>

    <div class="container">
        <div class="table-data">
            <div class="order column small">
               <h2 style="margin-bottom: 20px;">Ganti Password</h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <?php
                        $rubah_pw = ambilAdminUtama();
                    ?>
                    <div class="form-group">
                        <label>Password lama</label>
                        <input  style="color: #000;" type="text" name="pw_lama"  required="required" maxlength="8" class="form-control" value="<?php echo $rubah_pw['kode_akses']; ?> " readonly>
                    </div>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input  style="color: #000;" type="text" id="text1" required="required" minlength="4" maxlength="8"  name="text1" oninput="checkText()" >
                    </div>
                   <div class="form-group">
    <label>Ulangi Password Baru</label>
    <input  style="color: #000;"  type="password" id="text2" required="required"  minlength="4"  maxlength="8" name="text2" oninput="checkText()" >
    <div id="passwordMismatch">Password tidak cocok.</div>
</div>

<div class="form-group">
    <input type="submit" class="btn btn-success password-update" id="update" name="update" value="Update" class="form-control" disabled>
</div>
                </form>
            </div>
            <div class="order column large">
                <h2 style="margin-bottom: 20px;" > Pengaturan</h2>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Nama Lembaga</label>
                        <input  style="color: #000;" type="text" name="lembaga" required="required" class="form-control" value="<?php echo $title; ?>">
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input  style="color: #000;" type="email" name="email" required="required" class="form-control" value="<?php echo $gusmint['email']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input   style="color: #000;"type="datetime-local"  required="required"  name="mulai" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input  style="color: #000;" type="datetime-local" required="required"  name="selesai" class="form-control">
                    </div>
                    <div class="form-group">
                        <input  type="submit" class="btn btn-success" name="simpan" value="Simpan" class="form-control">
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            
            <?php
            foreach (array_filter([ambilPengaturan()]) as $gusmint) {
            ?>
            <form id="resetForm" action="" method="post">
                <input type="hidden" name="reset_tanggal" value="true">
                <input type="button" style="margin-bottom: 20px;" class="btn btn-danger" value="Reset Tanggal Pelaksanaan" onclick="confirmReset()">
            </form>
                <table class="table table-striped table-bordered table-hover">
                    <tr>
                        <th>Pemilihan</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                    </tr>
                    <tr>
                        <td><?php echo $gusmint['lembaga']; ?></td>
                        <td><?php echo $gusmint['mulai']; ?></td>
                        <td><?php echo $gusmint['selesai']; ?></td>
                    </tr>
                </table>
            <?php } ?>
        </div>
         
</main>

<script>
    function confirmReset() {
            if (confirm('Anda yakin ingin mereset tanggal?')) {
                document.getElementById('resetForm').submit();
            }
        }

function checkText() {
    const text1 = document.getElementById('text1').value;
    const text2 = document.getElementById('text2').value;
    const updateButton = document.getElementById('update');
    const passwordMismatch = document.getElementById('passwordMismatch');

    if (text1 === text2) {
        updateButton.disabled = false;
        updateButton.classList.add('active');
        passwordMismatch.style.display = 'none';
    } else {
        updateButton.disabled = true;
        updateButton.classList.remove('active');
        passwordMismatch.style.display = 'block';
    }
}

</script>
<script src="assets/js/jquery-1.10.2.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
