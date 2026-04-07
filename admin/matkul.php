<?php
session_start();
if ($_SESSION['role'] != 'admin') exit('Akses ditolak');

require_once '../core/Admin.php';

$admin = new Admin($_SESSION['nama']);
$file = "../data/matkul.json";
$data = json_decode(file_get_contents($file), true);

// TAMBAH
if (isset($_POST['tambah'])) {
    $admin->tambahData($file, [
        "kode" => $_POST['kode'],
        "nama" => $_POST['nama'],
        "sks" => $_POST['sks']
    ]);
    header("Location: matkul.php");
}

// HAPUS
if (isset($_GET['hapus'])) {
    $admin->hapusData($file, "kode", $_GET['hapus']);
    header("Location: matkul.php");
}
?>

<h2>Kelola Mata Kuliah</h2>

<form method="POST">
<input name="kode" placeholder="Kode">
<input name="nama" placeholder="Nama">
<input name="sks" placeholder="SKS">
<button name="tambah">Tambah</button>
</form>

<hr>

<?php foreach ($data as $m): ?>
<?= $m['kode'] ?> - <?= $m['nama'] ?>
<a href="?hapus=<?= $m['kode'] ?>">Hapus</a>
<br>
<?php endforeach; ?>