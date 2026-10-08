<?php
$gusmint = ambilPengaturan();
$title = $gusmint['lembaga'];
if (isset($_POST['simpan'])) {
    $kelas = $_POST['kelas'];
    $tingkat = $_POST['tingkat'];


    $count = kelasSudahAda($kelas, $tingkat) ? 1 : 0;
    if ($tingkat == 'MTS' || $tingkat == 'MA') {
       if ($count == 0) {
            tambahKelas($kelas, $tingkat);

            echo "<script>window.alert('Berhasil')
            window.location='index.php?page=kelas'</script>";
        } else {
            echo "<script>window.alert('Gagal menyimpan kelas. Data kelas dan tingkat sekolah sudah ada.')
            window.location='index.php?page=kelas'</script>";
        }
    } else {
        echo "<script>window.alert('Gagal menyimpan kelas. Tingkat sekolah tidak valid.')
        window.location='index.php?page=kelas'</script>";
    }
}

if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $hapus = hapusKelas($id) !== false;
    if ($hapus) {
        echo "<script>alert('Data Berhasil Di Hapus');document.location='index.php?page=kelas'</script>";
    } else {
        echo "<script>alert('Data Gagal Di Hapus, Coba ulangi lagi');document.location='index.php?page=kelas'</script>";
    }
}
?>


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
        background-color: #4CAF50;
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

.orderBox {
    display: flex;
    align-items: center;
    justify-content: space-between;
}


.order h3 {
    align-items: center;
    justify-content: space-between; 
    margin-bottom: 10px;
    font-size: 24px;
}
.delete-btn {
    justify-content: center;
    align-items: center;
    padding: 0;
    width: 40px;
    height: 40px;
}

.delete-btn .fa-trash {
    font-size: 20px;
}


</style>

<main>
    <div class="head-title">
        <div class="left">
            <h1>Kelas</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Kelas</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Kelas</a>
                </li>
            </ul>
        </div>
    </div>

    <div id="page-inner">
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Tambah Kelas</h3> 
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="tingkat">Tingkat sekolah</label>
                            <select style="color: #000;" name="tingkat" required="required" class="form-control" id="tingkat" onchange="formatKelas()">
                            <option value="MA">MA</option>
                            <option value="MTS">MTs</option>
                        </select>
                        </div>
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <input  style="color: #000;"type="text" name="kelas" required="required" class="form-control" id="kelas" oninput="formatKelas()" >
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" name="simpan" value="Tambah" class="form-control">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="table-data">
        <div class="orderBox">
        <h2>Data Kelas</h2>
        <div class="class">
            <div class="container">
                <form id="kelasForm" action="index.php" method="GET">
                    <input type="hidden" name="page" value="kelas">
                    <div class="select-wrapper">
                        <label for="tingkat">Tingkat</label>
                        <select id="tingkat" name="tingkat">
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
        <a style="margin-bottom: 20px;" class="btn btn-danger" href="actions/hapus_semua_kelas.php?confirm=true" onclick="return confirm('Anda yakin ingin menghapus semua data?')">Reset Kelas</a>
        <div class="table-responsive">
             <?php 
             if (isset($_GET['tingkat'])) {
                $tingkat = $_GET['tingkat'];
             }
            ?>
            <table id="data-kelas" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="align-middle text-center">No</th>
                        <th class="align-middle text-center">Kelas</th>
                        <th class="align-middle text-center">Tingkat</th>
                        <th class="align-middle text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                     <?php 
                    $no = 1;
                    if (isset($_GET['tingkat']) && $_GET['tingkat'] !== "Semua") {
    					$tingkat = $_GET['tingkat'];
                         $data = ambilKelas($tingkat);
                    } else {
                         $data = ambilKelas();
                    }
                    foreach ($data as $d) {
                    ?>
                    <tr>
                        <td class="align-middle text-center"><?php echo $no++; ?></td>
                        <td class="align-middle text-center"><?php echo $d['kelas']; ?></td>
                        <td class="align-middle text-center"><?php echo $d['tingkat']; ?></td>
                        <td style="text-align:center;">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" class="form-control" value="<?php echo $d['id']; ?>">
                                <button type="submit" class="btn btn-danger delete-btn" onclick="return confirm('Yakin hapus data ini !!!')" name="hapus">
                                    <i class="fas fa-trash fa-lg"></i>
                                </button>
                            </form>
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

<script>


function formatKelas() {
    var tingkat = document.getElementById('tingkat').value;
    var kelasInput = document.getElementById('kelas');
    var kelas = kelasInput.value.toUpperCase();

    if (tingkat === 'MTS') {
        kelasInput.setAttribute('pattern', '[7-9]-[A-Za-z0-9]+');
        kelasInput.setAttribute('title', 'Kelas untuk tingkat MTS hanya boleh dari kelas 7 sampai kelas 9.');
    } else if (tingkat === 'MA') {
        kelasInput.setAttribute('pattern', '1[0-2]-[A-Za-z0-9]+');
        kelasInput.setAttribute('title', 'Kelas untuk tingkat MA hanya boleh dari kelas 10 sampai kelas 12.');
    }

    if (tingkat === 'MA' && kelas.length === 2 && !isNaN(kelas)) {
        kelas += '-';
    }else if (tingkat === 'MTS' && kelas.length === 1 && !isNaN(kelas)) {
        kelas += '-';

    }
  

    kelasInput.value = kelas;
}


   document.addEventListener("DOMContentLoaded", function() {
    var table = document.getElementById("data-kelas");
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

    showCurrentSlide();
});

</script>

