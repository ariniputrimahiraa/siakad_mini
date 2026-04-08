<?php
session_start();
if ($_SESSION['role'] != 'admin') exit('Akses ditolak');

require_once '../core/Admin.php';

$admin = new Admin($_SESSION['nama']);
$file = "../data/mahasiswa.json";
$data = json_decode(file_get_contents($file), true);

// ================= TAMBAH =================
if (isset($_POST['tambah'])) {
    $admin->tambahData($file, [
        "nim" => $_POST['nim'],
        "nama" => $_POST['nama'],
        "prodi" => $_POST['prodi']
    ]);
    header("Location: mahasiswa.php");
}

// ================= HAPUS =================
if (isset($_GET['hapus'])) {
    $admin->hapusData($file, "nim", $_GET['hapus']);
    header("Location: mahasiswa.php");
}

// ================= AMBIL DATA EDIT =================
$editData = null;
if (isset($_GET['edit'])) {
    foreach ($data as $d) {
        if ($d['nim'] == $_GET['edit']) {
            $editData = $d;
            break;
        }
    }
}

// ================= PROSES EDIT =================
if (isset($_POST['edit'])) {
    foreach ($data as &$d) {
        if ($d['nim'] == $_POST['nim_lama']) {
            $d['nim'] = $_POST['nim'];
            $d['nama'] = $_POST['nama'];
            $d['prodi'] = $_POST['prodi'];
        }
    }
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    header("Location: mahasiswa.php");
}

// ================= SEARCH =================
$keyword = isset($_GET['cari']) ? strtolower($_GET['cari']) : '';

if ($keyword != '') {
    $data = array_filter($data, function ($m) use ($keyword) {
        return strpos(strtolower($m['nim']), $keyword) !== false ||
               strpos(strtolower($m['nama']), $keyword) !== false ||
               strpos(strtolower($m['prodi']), $keyword) !== false;
    });
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kelola Mahasiswa</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}

body{display:flex;min-height:100vh;background:#f4f7fb;}

.sidebar{
    width:70px;background:linear-gradient(180deg,#052455,#0a3a7a);
    display:flex;flex-direction:column;align-items:center;
    padding:20px 0;gap:15px;
}

.sidebar a{
    width:45px;height:45px;display:flex;align-items:center;justify-content:center;
    color:white;border-radius:12px;font-size:18px;transition:.25s;position:relative;
}

.sidebar a:hover{background:rgba(255,255,255,.15);transform:scale(1.1);}

.sidebar a span{
    position:absolute;left:60px;background:#052455;color:white;
    padding:5px 10px;border-radius:6px;font-size:12px;opacity:0;transition:.2s;
}

.sidebar a:hover span{opacity:1}
.logout{margin-top:auto;background:white;color:#052455}

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

.form-box{
    background:white;padding:20px;border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
    margin-bottom:20px;max-width:500px;
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(120px,1fr));
    gap:10px;
}

input{
    padding:10px;border-radius:8px;
    border:1px solid #ccc;font-size:13px;
}

input:focus{border-color:#052455;outline:none}

button{
    background:#052455;color:white;
    border:none;border-radius:8px;
    padding:10px;cursor:pointer;font-size:13px;
}

button:hover{background:#0a3a7a}

.table-box{
    background:white;border-radius:12px;overflow:hidden;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.table-header{
    background:#052455;color:white;
    padding:12px;font-size:14px;
}

.row{
    display:grid;
    grid-template-columns:1fr 2fr auto;
    padding:12px;border-bottom:1px solid #eee;
    align-items:center;font-size:13px;
}

.row:hover{background:#f9fbff}

.btn-hapus{color:red;text-decoration:none;font-size:12px;}

.empty{text-align:center;padding:15px;font-size:13px;color:#888;}
</style>
</head>
<body>

<div class="sidebar">
    <a href="dashboard.php"><i class="fas fa-home"></i><span>Dashboard</span></a>
    <a href="mahasiswa.php"><i class="fas fa-users"></i><span>Mahasiswa</span></a>
    <a href="matkul.php"><i class="fas fa-book"></i><span>Matkul</span></a>
    <a href="../auth/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
</div>

<div class="main">

<div class="header">
    <h1>Kelola Mahasiswa</h1>
    <div class="user">Halo, <?= $_SESSION['nama'] ?></div>
</div>

<div class="form-box">
    <form method="POST">
        <div class="form-grid">
            <input name="nim" placeholder="NIM" required
            value="<?php echo isset($editData['nim']) ? $editData['nim'] : ''; ?>">

            <input name="nama" placeholder="Nama" required
            value="<?php echo isset($editData['nama']) ? $editData['nama'] : ''; ?>">

            <input name="prodi" placeholder="Prodi" required
            value="<?php echo isset($editData['prodi']) ? $editData['prodi'] : ''; ?>">

            <?php if ($editData): ?>
                <input type="hidden" name="nim_lama" value="<?php echo $editData['nim']; ?>">
                <button name="edit">Update</button>
            <?php else: ?>
                <button name="tambah">Tambah</button>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- SEARCH (tanpa ubah layout besar) -->
<div class="form-box">
    <form method="GET">
        <div class="form-grid">
            <input name="cari" placeholder="Cari NIM / Nama / Prodi">
            <button>Cari</button>
        </div>
    </form>
</div>

<div class="table-box">
    <div class="table-header">Data Mahasiswa</div>

    <?php if(empty($data)): ?>
        <div class="empty">Belum ada data</div>
    <?php else: ?>
        <?php foreach ($data as $m): ?>
            <div class="row">
                <div><?= $m['nim'] ?></div>
                <div><?= $m['nama'] ?> (<?= $m['prodi'] ?>)</div>
                <div>
                    <a href="?edit=<?= $m['nim'] ?>">Edit</a> |
                    <a class="btn-hapus" href="?hapus=<?= $m['nim'] ?>">Hapus</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</div>
</body>
</html>