<?php
session_start();
if ($_SESSION['role'] != 'mahasiswa') exit('Akses ditolak');

require_once '../core/Mahasiswa.php';

// ambil data
$nilaiData = json_decode(file_get_contents("../data/nilai.json"), true);
$matkul = json_decode(file_get_contents("../data/matkul.json"), true);

$nilai = [];
$nim = $_SESSION['nim'];

// ambil nilai milik mahasiswa
foreach ($nilaiData as $n) {
    if ($n['nim'] == $nim) {
        $nilai[] = $n['nilai'];
    }
}

// buat object mahasiswa
$mhs = new Mahasiswa($_SESSION['nama'], $nim);
$mhs->setNilai($nilai);

// POLYMORPHISM
function cetakLaporan(CetakLaporan $obj) {
    echo $obj->cetak();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>KHS Mahasiswa</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}

body{
    display:flex;
    min-height:100vh;
    background:#f4f7fb;
}

/* SIDEBAR */
.sidebar{
    width:70px;
    background:linear-gradient(180deg,#052455,#0a3a7a);
    display:flex;
    flex-direction:column;
    align-items:center;
    padding:20px 0;
    gap:15px;
}

.sidebar a{
    width:45px;height:45px;
    display:flex;align-items:center;justify-content:center;
    color:white;border-radius:12px;font-size:18px;
    transition:.25s;position:relative;
}

.sidebar a:hover{
    background:rgba(255,255,255,.15);
    transform:scale(1.1);
}

.sidebar a span{
    position:absolute;left:60px;
    background:#052455;color:white;
    padding:5px 10px;border-radius:6px;
    font-size:12px;opacity:0;transition:.2s;
}

.sidebar a:hover span{opacity:1}

.logout{margin-top:auto;background:white;color:#052455}

/* MAIN */
.main{flex:1;padding:20px}

.header{
    display:flex;justify-content:space-between;
    align-items:center;margin-bottom:20px;
}

.header h1{color:#052455;font-size:20px}

.user{
    background:white;padding:8px 12px;
    border-radius:6px;font-size:13px;
    box-shadow:0 3px 10px rgba(0,0,0,.08);
}

/* TABLE */
.table-box{
    background:white;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.table-header{
    background:#052455;color:white;
    padding:12px;font-size:14px;
}

.row{
    display:grid;
    grid-template-columns:2fr 1fr;
    padding:12px;border-bottom:1px solid #eee;
    font-size:13px;
}

.row:hover{background:#f9fbff}

/* REPORT */
.report{
    margin-top:20px;
    background:white;
    padding:15px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    font-size:13px;
}

/* BUTTON */
.print-btn{
    margin-top:15px;
    padding:10px 15px;
    background:#052455;color:white;
    border:none;border-radius:8px;
    cursor:pointer;font-size:13px;
}

.print-btn:hover{background:#0a3a7a}

</style>
</head>
<body>

<div class="sidebar">

    <a href="dashboard.php">
        <i class="fas fa-home"></i>
        <span>Dashboard</span>
    </a>

    <a href="khs.php">
        <i class="fas fa-file-alt"></i>
        <span>KHS</span>
    </a>

    <a href="../auth/logout.php" class="logout">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>

</div>

<div class="main">

    <div class="header">
        <h1>Kartu Hasil Studi</h1>
        <div class="user">Halo, <?= $_SESSION['nama'] ?></div>
    </div>

    <div class="table-box">
        <div class="table-header">Data Nilai</div>

        <?php
        foreach ($nilaiData as $n) {
            if ($n['nim'] == $nim) {
                foreach ($matkul as $m) {
                    if ($m['kode'] == $n['kode_matkul']) {
                        echo "<div class='row'>
                                <div>{$m['nama']}</div>
                                <div>{$n['nilai']}</div>
                              </div>";
                    }
                }
            }
        }
        ?>

    </div>

    <div class="report">
        <?php cetakLaporan($mhs); ?>
    </div>

    <button onclick="window.print()" class="print-btn">
        <i class="fas fa-print"></i> Cetak KHS
    </butt