<?php
$fileConfig = file_exists(__DIR__ . '/config.local.php')
    ? __DIR__ . '/config.local.php'
    : __DIR__ . '/config.example.php';
$config = require $fileConfig;

try {
    $koneksi = mysqli_connect($config['host'], $config['username'], $config['password'], $config['database']);
} catch (mysqli_sql_exception $e) {
    die('Koneksi database gagal: ' . $e->getMessage()
        . '<br>Periksa pengaturan di config.local.php (contoh: config.example.php) dan pastikan MySQL menyala.');
}
