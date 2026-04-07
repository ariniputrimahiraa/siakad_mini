<?php
session_start();
if (!isset($_SESSION['login'])) header("Location: ../auth/login.php");
if ($_SESSION['role'] != 'admin') exit('Akses ditolak');
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    display: flex;
    min-height: 100vh;
    background: #f4f7fb;
}

/* SIDEBAR ICON ONLY */
.sidebar {
    width: 70px;
    background: linear-gradient(180deg, #052455, #0a3a7a);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px 0;
    gap: 15px;
}

.sidebar a {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border-radius: 12px;
    font-size: 18px;
    transition: 0.25s;
    position: relative;
}

.sidebar a:hover {
    background: rgba(255,255,255,0.15);
    transform: scale(1.1);
}

/* TOOLTIP */
.sidebar a span {
    position: absolute;
    left: 60px;
    background: #052455;
    color: white;
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 12px;
    opacity: 0;
    white-space: nowrap;
    transition: 0.2s;
}

.sidebar a:hover span {
    opacity: 1;
}

.logout {
    margin-top: auto;
    background: white;
    color: #052455;
}

.logout:hover {
    background: #e6ecf5;
}

/* MAIN */
.main {
    flex: 1;
    padding: 20px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header h1 {
    color: #052455;
    font-size: 20px;
}

.user {
    background: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 13px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
}

.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
}

.card {
    background: white;
    padding: 18px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.06);
    transition: 0.2s;
}

.card:hover {
    transform: translateY(-3px);
}

.card h3 {
    color: #052455;
    margin-bottom: 6px;
    font-size: 16px;
}

.card p {
    font-size: 12px;
    color: #666;
}

</style>
</head>
<body>

<div class="sidebar">

    <a href="mahasiswa.php">
        <i class="fas fa-user-graduate"></i>
        <span>Mahasiswa</span>
    </a>

    <a href="matkul.php">
        <i class="fas fa-book"></i>
        <span>Mata Kuliah</span>
    </a>

    <a href="../auth/logout.php" class="logout">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>

</div>

<div class="main">

    <div class="header">
        <h1>Dashboard</h1>
        <div class="user">Halo, <?= $_SESSION['nama'] ?></div>
    </div>

    <div class="cards">

        <a href="mahasiswa.php" style="text-decoration:none">
            <div class="card">
                <h3>Mahasiswa</h3>
                <p>Kelola data mahasiswa</p>
            </div>
        </a>

        <a href="matkul.php" style="text-decoration:none">
            <div class="card">
                <h3>Mata Kuliah</h3>
                <p>Kelola data mata kuliah</p>
            </div>
        </a>

    </div>

</div>

</body>
</html>
