<?php

require_once __DIR__ . '/url.php';

function mulaiSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function wajibLogin()
{
    mulaiSession();
    if (empty($_SESSION['login'])) {
        header('location:' . urlProyek('index.php'));
        exit;
    }
}

function wajibAdmin()
{
    wajibLogin();
    if (($_SESSION['level'] ?? '') !== 'admin') {
        header('location:' . urlSistem('index.php'));
        exit;
    }
}

function wajibPemilih()
{
    wajibLogin();
    if (($_SESSION['level'] ?? '') !== 'user') {
        header('location:' . urlSistem('index.php'));
        exit;
    }
}
