<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'dosen') {
    exit('Akses ditolak');
}

require_once '../core/Dosen.php';

$dosen = new Dosen($_SESSION['nama']);
$file = "../data/nilai.json";

// ambil data
$mahasiswa = json_decode(file_get_contents("../data/mahasiswa.json"), true);
$matkul = json_decode(file_get_contents("../data/matkul.json"), true);
$data = json_decode(file_get_contents($file), true);
if (!$data) {
    $data = [];
}

// ================== DELETE ==================
if (isset($_GET['hapus'])) {
    $hapusKey = $_GET['hapus'];

    $data = array_filter($data, function($item) use ($hapusKey) {
        return md5($item['nim'].$item['kode_matkul']) !== $hapusKey;
    });

    file_put_contents($file, json_encode(array_values($data), JSON_PRETTY_PRINT));
    header("Location: nilai.php");
    exit;
}

// ================== EDIT LOAD ==================
$editData = null;
if (isset($_GET['edit'])) {
    foreach ($data as $d) {
        if (md5($d['nim'].$d['kode_matkul']) === $_GET['edit']) {
            $editData = $d;
            break;
        }
    }
}

// ================== SIMPAN / UPDATE ==================
if (isset($_POST['simpan'])) {

    $nim = $_POST['nim'];
    $kode = $_POST['kode'];
    $nilai_input = (int) $_POST['nilai'];

    // VALIDASI NILAI
    if ($nilai_input < 0 || $nilai_input > 100) {
        exit("Nilai harus antara 0 - 100");
    }

    // hapus dulu jika edit
    if (isset($_POST['edit_key'])) {
        $data = array_filter($data, function($item) {
            return md5($item['nim'].$item['kode_matkul']) !== $_POST['edit_key'];
        });
    }

    // simpan data baru
    $data[] = [
        "nim" => $nim,
        "kode_matkul" => $kode,
        "nilai" => $nilai_input
    ];

    file_put_contents($file, json_encode(array_values($data), JSON_PRETTY_PRINT));

    header("Location: nilai.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Input Nilai</title>

<link rel="icon" href="../assets/buk.png" type="image/png">

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
    color: #333;
}

/* SIDEBAR (TIDAK DIUBAH) */
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
}

.logout {
    margin-top: auto;
    background: white;
    color: #052455;
}

/* MAIN */
.main {
    flex: 1;
    padding: 14px;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 14px;
}

.header h1 {
    font-size: 18px;
}

.header div {
    font-size: 13px;
    color: #666;
}

/* FORM */
.form-box {
    background: white;
    padding: 14px;
    border-radius: 10px;
    margin-bottom: 14px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
}

.full {
    grid-column: span 2;
}

input, select {
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 13px;
    outline: none;
}

input:focus, select:focus {
    border-color: #052455;
}

/* BUTTON */
button {
    padding: 8px;
    background: #052455;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
}

button:hover {
    background: #0a3a7a;
}

/* TABLE */
.table-box {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.table-header, .row {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    padding: 10px 12px;
    font-size: 13px;
}

.table-header {
    background: #052455;
    color: white;
    font-weight: 500;
}

.row {
    border-bottom: 1px solid #eee;
    align-items: center;
}

.row:hover {
    background: #f9fbfd;
}

/* ACTION */
.actions a {
    margin-right: 5px;
    text-decoration: none;
    font-size: 11px;
    padding: 4px 7px;
    border-radius: 5px;
    color: white;
}

.edit {
    background: #f0ad4e;
}

.delete {
    background: #d9534f;
}
</style>
</head>

<body>

<div class="sidebar">
    <a href="dashboard.php"><i class="fas fa-home"></i></a>
    <a href="nilai.php"><i class="fas fa-chart-line"></i></a>
    <a href="../auth/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i></a>
</div>

<div class="main">

<div class="header">
    <h1>Input Nilai</h1>
    <div>Halo, <?= $_SESSION['nama'] ?></div>
</div>

<div class="form-box">
    <form method="POST" class="form-grid">

        <select name="nim" required>
            <option value="">Mahasiswa</option>
            <?php foreach ($mahasiswa as $m): ?>
                <option value="<?= $m['nim'] ?>" 
                    <?= ($editData && $editData['nim'] == $m['nim']) ? 'selected' : '' ?>>
                    <?= $m['nim'] ?> - <?= $m['nama'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="kode" required>
            <option value="">Mata Kuliah</option>
            <?php foreach ($matkul as $mk): ?>
                <option value="<?= $mk['kode'] ?>"
                    <?= ($editData && $editData['kode_matkul'] == $mk['kode']) ? 'selected' : '' ?>>
                    <?= $mk['kode'] ?> - <?= $mk['nama'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input class="full" type="number" name="nilai" placeholder="Nilai (0-100)" min="0" max="100" required
            value="<?= isset($editData['nilai']) ? $editData['nilai'] : '' ?>">

        <?php if ($editData): ?>
            <input type="hidden" name="edit_key" value="<?= md5($editData['nim'].$editData['kode_matkul']) ?>">
        <?php endif; ?>

        <button class="full" name="simpan">
            <?= $editData ? 'Update Nilai' : 'Simpan Nilai' ?>
        </button>

    </form>
</div>

<div class="table-box">
    <div class="table-header">
        <div>NIM</div>
        <div>Kode MK</div>
        <div>Nilai</div>
        <div>Aksi</div>
    </div>

    <?php if(empty($data)): ?>
        <div class="row">Belum ada data</div>
    <?php else: ?>
        <?php foreach ($data as $n): 
            $key = md5($n['nim'].$n['kode_matkul']);
        ?>
        <div class="row">
            <div><?= $n['nim'] ?></div>
            <div><?= $n['kode_matkul'] ?></div>
            <div><?= $n['nilai'] ?></div>
            <div class="actions">
                <a class="edit" href="?edit=<?= $key ?>">Edit</a>
                <a class="delete" href="?hapus=<?= $key ?>" onclick="return confirm('Hapus data?')">Hapus</a>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

</div>
</body>
</html>