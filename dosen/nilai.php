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

// SIMPAN NILAI
if (isset($_POST['simpan'])) {
    $dosen->inputNilai($file, [
        "nim" => $_POST['nim'],
        "kode_matkul" => $_POST['kode'],
        "nilai" => $_POST['nilai']
    ]);

    header("Location: nilai.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Input Nilai</title>

<style>
body { font-family: Arial; background: #eef2f7; }
.container { width: 90%; margin: 20px auto; }
.card { background: white; padding: 20px; border-radius: 10px; }

input, button {
    width: 100%;
    padding: 10px;
    margin: 5px 0;
}

button {
    background: #2ecc71;
    color: white;
    border: none;
}

table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

td, th {
    border: 1px solid #ddd;
    padding: 10px;
}
</style>

</head>
<body>

<div class="container">
<div class="card">

<h2>Input Nilai Mahasiswa</h2>

<form method="POST">
<input name="nim" placeholder="NIM Mahasiswa" required>
<input name="kode" placeholder="Kode Matkul" required>
<input name="nilai" placeholder="Nilai" required>
<button name="simpan">Simpan Nilai</button>
</form>

<a href="dashboard.php">⬅ Kembali</a>

<?php
// TAMPIL DATA NILAI
$data = json_decode(file_get_contents($file), true);
?>

<h3>Data Nilai</h3>

<table>
<tr>
<th>NIM</th>
<th>Kode Matkul</th>
<th>Nilai</th>
</tr>

<?php foreach ($data as $n): ?>
<tr>
<td><?= $n['nim'] ?></td>
<td><?= $n['kode_matkul'] ?></td>
<td><?= $n['nilai'] ?></td>
</tr>
<?php endforeach; ?>

</table>

</div>
</div>

</body>
</html>