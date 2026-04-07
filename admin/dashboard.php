<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: ../auth/login.php");
if ($_SESSION['role'] != 'admin') exit('Akses ditolak');
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin</title>
<style>
body { font-family: Arial; background:#f4f6f9; }
.container { width:90%; margin:auto; }
.card { background:white; padding:20px; margin-top:20px; border-radius:10px; }
a { display:block; margin:10px 0; }
</style>
</head>
<body>

<div class="container">
<div class="card">
<h1>Dashboard Admin</h1>

<p>Halo, <?= $_SESSION['nama'] ?></p>

<a href="mahasiswa.php">Kelola Mahasiswa</a>
<a href="matkul.php">Kelola Mata Kuliah</a>
<a href="../auth/logout.php">Logout</a>

</div>
</div>

</body>
</html>