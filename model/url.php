<?php

function urlProyek($path = '')
{
    $skrip = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $posisi = strpos($skrip, '/sistem1/');
    $dasar = ($posisi !== false) ? substr($skrip, 0, $posisi) : rtrim(dirname($skrip), '/');
    return $dasar . '/' . ltrim($path, '/');
}

function urlSistem($path = '')
{
    return urlProyek('sistem1/' . ltrim($path, '/'));
}
