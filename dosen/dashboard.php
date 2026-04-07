<?php
session_start();

// CEK LOGIN
if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

// CEK ROLE DOSEN
if ($_SESSION['role'] != 'dosen') {
    exit('Akses ditolak');
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Dosen</title>

<style>
body {
    font-family: Arial;
    background: #eef2f7;
    margin: 0;
}

.container {
    width: 90%;
    margin: 20px auto;
}

.card {
    background: white;
    padding: 20px;
    border-radius: 10px;
}

.menu a {
    display: block;
    padding: 10px;
    margin: 10px 0;
    background: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.menu a:hover {
    background: #2980b9;
}
</style>

</head>
<body>

<div class="container">
<div class="card">

<h1>Dashboard Dosen</h1>
<p>Halo, <b><?= $_SESSION['nama'] ?></b></p>

<div class="menu">
    <a href="nilai.php">📊 Input Nilai Mahasiswa</a>
    <a href="../auth/logout.php">🚪 Logout</a>
</div>

</div>
</div>

</body>
</html>