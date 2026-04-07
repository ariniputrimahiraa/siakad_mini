<?php
session_start();

// kalau belum login → ke login
if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}

// kalau sudah login → arahkan sesuai role
if ($_SESSION['role'] == 'admin') {
    header("Location: admin/dashboard.php");
} elseif ($_SESSION['role'] == 'dosen') {
    header("Location: dosen/dashboard.php");
} elseif ($_SESSION['role'] == 'mahasiswa') {
    header("Location: mahasiswa/dashboard.php");
} else {
    // kalau role aneh / kosong
    session_destroy();
    header("Location: auth/login.php");
    exit;
}