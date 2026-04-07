<?php
session_start();
if ($_SESSION['role'] != 'admin') exit('Akses ditolak');

require_once '../core/Admin.php';

$admin = new Admin($_SESSION['nama']);
$file = "../data/mahasiswa.json";
$data = json_decode(file_get_contents($file), true);

// TAMBAH
if (isset($_POST['tambah'])) {
    $admin->tambahData($file, [
        "nim" => $_POST['nim'],
        "nama" => $_POST['nama'],
        "prodi" => $_POST['prodi']
    ]);
    header("Location: mahasiswa.php");
}

// HAPUS
if (isset($_GET['hapus'])) {
    $admin->hapusData($file, "nim", $_GET['hapus']);
    header("Location: mahasiswa.php");
}
?>

<h2>Kelola Mahasiswa</h2>

<form method="POST">
<input name="nim" placeholder="NIM" required>
<input name="nama" placeholder="Nama" required>
<input name="prodi" placeholder="Prodi" required>
<button name="tambah">Tambah</button>
</form>

<hr>

<?php foreach ($data as $m): ?>
<?= $m['nim'] ?> - <?= $m['nama'] ?>
<a href="?hapus=<?= $m['nim'] ?>">Hapus</a>
<br>
<?php endforeach; ?>