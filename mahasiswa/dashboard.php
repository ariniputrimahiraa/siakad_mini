<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: ../auth/login.php");
if ($_SESSION['role'] != 'mahasiswa') exit('Akses ditolak');
?>

<h1>Dashboard Mahasiswa</h1>
<p>Halo, <?= $_SESSION['nama'] ?></p>

<a href="khs.php">Lihat KHS</a><br>
<a href="../auth/logout.php">Logout</a>