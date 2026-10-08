<?php
session_start();
include '../../koneksi.php';
require_once '../../model/query.php';

$error_message = '';

if(isset($_POST['login'])){
    $r = cariAdmin($_POST['nim'], $_POST['kode_akses']);
    if($r){
        $_SESSION["login"] = true;
        $_SESSION['nim'] = $r['nim'];
        $_SESSION['nama'] = $r['nama'];
        $_SESSION['email'] = $r['email'];
        $_SESSION['level'] = $r['level'];
        header('location:../../sistem1');
        exit();
    }else{
        $error_message = "Kode Akses Salah";
    }
}

$gusmint = ambilPengaturan();

if ($gusmint) {
    $title = $gusmint['lembaga'];
} else {
    echo "Data tidak ditemukan.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <link rel="icon" type="image/png" href="../../assets/img/brand/Logo.png"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/base/util.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/base/main.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/pages/login.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/components/sweetalert.css">


    <meta name="viewport" content="width=device-width, initial-scale=1">
     <style>
        .alert-danger {
            margin-top: 10px;
            margin-bottom: 5px;
            padding: 10px;
            color: red;
        }
        .btn {
            margin-top: 10px;
            border-radius : 50px
        }

        .btn {
            display: block;
            width: 100%;
            height: 50px;
            border-radius: 25px;
            outline: none;
            border: none;
            background-image: linear-gradient(to right, #ffd700, #ffc300, #ffd700);
            background-size: 200%;
            font-size: 1.2rem;
            color: #2e8b57;
            font-family: "Poppins", sans-serif;
            text-transform: uppercase;
            margin: 1rem 0;
            cursor: pointer;
            transition: 0.5s;
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
    </style>
</head>
<body>
    <img class="wave" src="../../assets/img/login/wafe.png">
    <div class="container">
        <div class="img">
            <img src="../../assets/img/login/user.png">
        </div>
        <div class="login-content">
            <a href="../../index.php" class="home-link">Home</a>
            <form action="" method="post">
                <img src="../../assets/img/brand/muhammadiyah.png">
                <h2 class="title">welcome</h2>
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
                <a href="../../lupa_password.php">Forgot Password?</a>

                 <?php if ($error_message): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <input type="submit" class="btn" name="login" id="login" value="Login">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="../../assets/js/pages/login.js"></script>
    
    <script src="../../assets/js/components/sweetalert.min.js"></script>

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
