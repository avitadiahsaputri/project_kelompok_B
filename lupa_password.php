<?php
include 'koneksi.php';
require_once 'model/query.php';
include 'send_email.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send'])) {
    $email = $_POST['email'];
    $row = cariAdminDenganEmail($email);

    if ($row) {
        $data_text = "Data Akun Admin\n";
        foreach ($row as $column => $value) {
            $data_text .= "$column: $value\n";
        }

        if (sendVerificationCodeByEmail($email, $data_text)) {
            echo "<script>alert('Informasi akun telah dikirim. Silakan cek email Anda.'); window.location.href = 'index.php';</script>";
        } else {
            $error_message = "Gagal mengirim email.";
        }
    } else {
        $error_message = "Email tidak terhubung dengan admin.";
    }
} 

$gusmint = ambilPengaturan();

if ($gusmint) {
    $title = $gusmint['lembaga'];
} else {
    $title = "Tidak ada data pengaturan ditemukan";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <link rel="icon" type="image/png" href="assets/img/brand/Logo.png"/>
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/base/util.css">
    <link rel="stylesheet" type="text/css" href="assets/css/base/main.css">
    <link rel="stylesheet" type="text/css" href="assets/css/pages/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .alert-danger {
            margin-top: 10px; 
            margin-bottom: 5px; 
            padding: 10px; 
            color: red; 
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

        .btn-back {
            
            line-height: 1.5;
            color: #ffd700;
            text-transform: uppercase;
            width: 100%;
            height: 50px;
            border-radius: 25px;
            background: linear-gradient(135deg, #006400, #008000);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 25px;
            border: none;
            cursor: pointer;
            transition: background 0.4s ease;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, #008000, #006400);         }

        .btn-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    <img class="wave" src="assets/img/login/wafe.png">
    <div class="container">
        <div class="img">
            <img src="assets/img/login/user.png">
        </div>
        <div class="login-content">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Masukkan email Anda</h5>
                        <input type="email" class="input" name="email" id="email" autocomplete="off" required="required">
                    </div>
                </div>
                <?php if ($error_message): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <div class="btn-container">
                    <input type="submit" class="btn" name="send" id="send" value="Send">
                    <button type="button" class="btn-back" onclick="window.location.href='login/admin/index.php';">Back</button>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="assets/js/pages/login.js"></script>
    <script>
        $('.js-tilt').tilt({
            scale: 1
        });
    </script>
</body>
</html>
