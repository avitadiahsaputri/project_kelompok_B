<?php
session_start();
include '../../koneksi.php';
require_once '../../model/query.php';

$error_message = '';

if(isset($_POST['login'])){
	$r = cariPemilih($_POST['nim'], $_POST['kode_akses']);
	if($r){
		$_SESSION["login"] = true;
		$_SESSION['nim'] = $r['nim'];
		$_SESSION['nama'] = $r['nama'];
		$_SESSION['kelas'] = $r['kelas'];
		$_SESSION['tingkat'] = $r['tingkat'];
		$_SESSION['level'] = $r['level'];
        header('location:../../sistem1');
        exit();
    }else{
        $error_message = "Kode Akses Salah";
    }
}

$gusmint = ambilPengaturan();
$title = $gusmint['lembaga'];
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <link rel="icon" type="image/png" href="../../assets/img/brand/Logo.png"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../../assets/lib/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../assets/lib/animate/animate.css">
	<link rel="stylesheet" type="text/css" href="../../assets/lib/hamburgers/hamburgers.min.css">
	<link rel="stylesheet" type="text/css" href="../../assets/lib/select2/select2.min.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/base/util.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/base/main.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/pages/login.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/components/sweetalert.css">


    <meta name="viewport" content="width=device-width, initial-scale=1">
     <style>
       :root {
    --danger-color: red;
    --btn-bg-color-start: #ffd700;
    --btn-bg-color-middle: #ffc300;
    --btn-bg-color-end: #ffd700;
    --btn-text-color: #2e8b57;
    --btn-font-family: "Poppins", sans-serif;
    --btn-font-size: 1.2rem;
    --btn-border-radius: 25px;
    --btn-height: 50px;
    --btn-margin: 1rem 0;
    --btn-transition: 0.5s;
    --alert-margin-top: 10px;
    --alert-margin-bottom: 5px;
    --alert-padding: 10px;
    --alert-bg-color: rgba(255, 0, 0, 0.1);
}

.alert-danger {
    margin-top: var(--alert-margin-top);
    margin-bottom: var(--alert-margin-bottom);
    padding: var(--alert-padding);
    color: var(--danger-color);
    background: var(--alert-bg-color); 
}

.btn {
    display: block;
    width: 100%;
    height: var(--btn-height);
    border-radius: var(--btn-border-radius);
    outline: none;
    border: none;
    background-image: linear-gradient(to right, var(--btn-bg-color-start), var(--btn-bg-color-middle), var(--btn-bg-color-end));
    background-size: 200%;
    font-size: var(--btn-font-size);
    color: var(--btn-text-color);
    font-family: var(--btn-font-family);
    text-transform: uppercase;
    margin: var(--btn-margin);
    cursor: pointer;
    transition: var(--btn-transition);
}

.btn:hover {
    background-position: right;
}

.home-link {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #4CAF50;
            color: yellow;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-family: var(--btn-font-family);
            font-size: var(--btn-font-size);
            text-transform: uppercase;
            transition: var(--btn-transition);
        }

        .home-link:hover {
            background-color: #45a049;
            color:yellow
        }

        .home-link:active {
            background-color: #3e8e41;
            transform: scale(0.95);
        }

    </style>
</head>
<body>
    <img class="wave" src="../../assets/img/login/wafe.png">
    <div class="container">
        <div class="img">
            <img src="../../assets/img/login/loo.png">
        </div>
        <div class="login-content">
             <a href="../../index.php" class="home-link">Home</a>
            <form action="" method="post">
                <img src="../../assets/img/brand/muhammadiyah.png">
                <h2 class="title">Suara IPM</h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Username</h5>
                        <input type="text" class="input" name="nim" id="nim" autocomplete="off" required="required">
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input type="password" class="input" name="kode_akses" id="kode_akses"  autocomplete="off" required="required">
                    </div>
                </div>

                 <?php if ($error_message): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <input type="submit" class="btn" name="login" id="login" value="Login">
                
            </form>
        </div>
    </div>
    
    <script src="../../assets/js/components/sweetalert.min.js"></script>
    <script type="text/javascript" src="../../assets/js/pages/login.js"></script>


     <?php if(isset($_POST['login'])): ?>
    <script>
        setTimeout(function() {
            swal({
                title: 'Kode Akses Salah',
                type: 'warning',
                timer: 3200,
              
            });
        }, 10);
    </script>
    <?php endif; ?>
</body>
</html>
